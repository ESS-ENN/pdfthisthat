<?php

namespace App\Http\Controllers;
use Fpdf\Fpdf;
use Imagick;
use ImagickPixel;
use ImagickDraw;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Word_PDF_Controller extends Controller
{
    public function word_to_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Word_to_pdf.word_to_pdf');
    }

    public function word_to_Pdf(Request $request)
    {
        $request->validate([
            'word_file' => 'required|mimes:doc,docx|max:20480', // 20MB max
        ]);

        // Step 1: Store uploaded Word file in public/uploads with unique ID and original name
        $wordFile = $request->file('word_file');
        $originalName = pathinfo($wordFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $wordFile->getClientOriginalExtension();

        $uniqueId = uniqid();
        $sanitizedOriginal = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $uniqueId . '_' . $sanitizedOriginal . '.' . $extension;

        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $wordFile->move($uploadPath, $filename);
        $storedWordPath = 'uploads/' . $filename;
        $fullWordPath = public_path($storedWordPath);

        // Step 2: Convert Word to PDF using LibreOffice with temporary user profile
        $outputDir = storage_path('app/temp');
        $libreOfficePath = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
            ? '"C:\Program Files\LibreOffice\program\soffice.exe"'
            : '/usr/bin/libreoffice';

        $tempLibreProfile = storage_path('app/temp/libreoffice_profile_' . uniqid());
        mkdir($tempLibreProfile, 0755, true);

        $command = $libreOfficePath
            . ' --headless'
            . ' -env:UserInstallation=file://' . $tempLibreProfile
            . ' --convert-to pdf'
            . ' --outdir ' . escapeshellarg($outputDir)
            . ' ' . escapeshellarg($fullWordPath);

        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            @unlink($fullWordPath);
            array_map('unlink', glob("$tempLibreProfile/*"));
            @rmdir($tempLibreProfile);

            return back()->with('error', 'LibreOffice conversion failed: ' . implode("\n", $output));
        }

        $convertedPdfPath = $outputDir . '/' . preg_replace('/\.(docx|doc)$/i', '.pdf', basename($fullWordPath));
        if (!file_exists($convertedPdfPath)) {
            return back()->with('error', 'Converted PDF not found.');
        }

        // Step 3: Convert PDF to images with watermark
        $imagick = new Imagick();
        $imagick->setResolution(300, 300);
        $imagick->readImage($convertedPdfPath);
        $imagick->setImageFormat('jpeg');
        $whiteBackground = new ImagickPixel('white');

        foreach ($imagick as $image) {
            $image->setImageBackgroundColor($whiteBackground);
            $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
            $image->setImageCompressionQuality(90);
            $image->stripImage();

            $watermarkColor = new ImagickPixel('rgba(200, 200, 200, 0.3)');
            $draw = new ImagickDraw();
            $draw->setFillColor($watermarkColor);
            $draw->setFontSize(50);
            $draw->setGravity(Imagick::GRAVITY_CENTER);
            $image->drawImage($draw);
        }

        $imagePaths = [];
        foreach ($imagick as $i => $img) {
            $imagePath = storage_path("app/temp/page_" . $i . ".jpg");
            $img->writeImage($imagePath);
            $imagePaths[] = $imagePath;
        }

        // Step 4: Create final PDF from images
        $pdf = new \FPDF('P', 'mm', 'A4');
        foreach ($imagePaths as $imgPath) {
            [$width, $height] = getimagesize($imgPath);
            $ratio = $width / $height;
            $a4Width = 210;
            $a4Height = 297;

            if ($ratio > ($a4Width / $a4Height)) {
                $displayWidth = $a4Width;
                $displayHeight = $a4Width / $ratio;
            } else {
                $displayHeight = $a4Height;
                $displayWidth = $a4Height * $ratio;
            }

            $x = ($a4Width - $displayWidth) / 2;
            $y = ($a4Height - $displayHeight) / 2;
            $pdf->AddPage();
            $pdf->Image($imgPath, $x, $y, $displayWidth, $displayHeight);
        }

        $finalFilename = $sanitizedOriginal . '_converted_from_word.pdf';

        // Step 5: Save PDF to output folders
        $outputFolder = public_path('output');
        $outputGeneratedFolder = public_path('output_generated');

        if (!file_exists($outputFolder)) {
            mkdir($outputFolder, 0755, true);
        }

        if (!file_exists($outputGeneratedFolder)) {
            mkdir($outputGeneratedFolder, 0755, true);
        }

        $finalPdfPathOutput = $outputFolder . '/' . $finalFilename;
        $finalPdfPathGenerated = $outputGeneratedFolder . '/' . $finalFilename;

        $pdf->Output('F', $finalPdfPathOutput);
        $pdf->Output('F', $finalPdfPathGenerated);

        // Step 6: Limit to 10 files in output_generated
        $genFiles = glob($outputGeneratedFolder . '/*.pdf');
        usort($genFiles, function ($a, $b) {
            return filemtime($a) - filemtime($b);
        });

        if (count($genFiles) > 10) {
            @unlink($genFiles[0]);
        }

        // Step 7: Cleanup temp files
        @unlink($convertedPdfPath);
        foreach ($imagePaths as $img) {
            if (file_exists($img)) {
                @unlink($img);
            }
        }

        // Remove LibreOffice temp profile
        $deleteDirectory = function ($dir) use (&$deleteDirectory) {
            if (!file_exists($dir)) return;
            $items = scandir($dir);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') continue;
                $path = $dir . DIRECTORY_SEPARATOR . $item;
                if (is_dir($path)) {
                    $deleteDirectory($path);
                } else {
                    @unlink($path);
                }
            }
            @rmdir($dir);
        };
        $deleteDirectory($tempLibreProfile);

        // Step 8: Save to DB if logged in
        if (Auth::check()) {
            $pdfBinary = file_get_contents($finalPdfPathOutput);
            DB::table('files')->insert([
                'user_id' => Auth::id(),
                'original_file_name' => $originalName,
                'input_file' => $storedWordPath,
                'operation' => 'Word To Pdf',
                'output_file_name' => $finalFilename,
                'file' => base64_encode($pdfBinary),
                'date' => now(),
                'status' => 'success',
            ]);
        }

        // Step 9: Provide download link
        $downloadUrl = asset("output/{$finalFilename}");

        return redirect()->route('success_word_to_pdf')->with([
            'success' => "PDF generated successfully.",
            'download_link' => $downloadUrl,
            'download_name' => $finalFilename,
        ]);
    }

    public function success_word_to_pdf()
    {
        return view('pdf_functions_without_login.Word_to_pdf.success_word_to_pdf');
    }

}