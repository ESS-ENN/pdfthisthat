<?php

namespace App\Http\Controllers;
use Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Imagick;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OCR_Controller extends Controller
{
    public function ocr_pdf_LandPage()
    {
        return view('pdf_functions_without_login.OCR.ocr_pdf');
    }

    public function ocr_pdf(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // 10MB
        ]);

        // Ensure necessary folders
        $uploadDir = public_path('uploads');
        $outputDir = public_path('processed');
        $tempImageDir = public_path('temp_images');

        foreach ([$uploadDir, $outputDir, $tempImageDir] as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0775, true);
            }
        }

        // Process the uploaded file
        $file = $request->file('pdf_file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $uniqueName = uniqid() . '_' . $sanitizedName . '.' . $extension;

        // Save uploaded file to public/uploads
        $storedInputPath = 'uploads/' . $uniqueName;
        $fullInputPath = $uploadDir . '/' . $uniqueName;
        $file->move($uploadDir, $uniqueName);

        $outputName = $sanitizedName . '_ocr.pdf';
        $outputPath = $outputDir . DIRECTORY_SEPARATOR . $outputName;

        $text = '';
        $tesseractPath = null;

        if (PHP_OS_FAMILY === 'Windows') {
            $tesseractPath = 'C:\Program Files\Tesseract-OCR\tesseract.exe';
        }

        try {
            // Clear temp images directory
            array_map('unlink', glob("$tempImageDir/*"));

            $imagick = new Imagick();
            $imagick->setResolution(300, 300);
            $imagick->readImage($fullInputPath);
            $imagick->setImageFormat('jpeg');

            foreach ($imagick as $i => $page) {
                $imagePath = $tempImageDir . "/page-$i.jpg";
                $page->writeImage($imagePath);

                $ocr = (new TesseractOCR($imagePath))
                    ->lang('eng'); // use ->executable() if needed for Windows
                
                if ($tesseractPath) {
                    $ocr->executable($tesseractPath);
                }
                $text .= $ocr->run() . "\n\n";
            }

            $imagick->clear();
            $imagick->destroy();

            // Create PDF with OCR text
            $pdf = new Fpdf();
            $pdf->AddPage();
            $pdf->SetFont('Times', '', 12);
            $lines = explode("\n", $text);

            foreach ($lines as $line) {
                $pdf->MultiCell(0, 6, $line);
            }

            $pdf->Output('F', $outputPath);

            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);

                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $originalName,
                    'input_file' => $storedInputPath,
                    'operation' => 'OCR Pdf',
                    'output_file_name' => $outputName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            // Clean up temp images
            array_map('unlink', glob("$tempImageDir/*"));

            return redirect()->route('success_ocr_pdf')->with([
                'success' => 'OCR PDF generated successfully.',
                'downloadLink' => asset("processed/{$outputName}"),
                'download_name' => $outputName,
            ]);

        } catch (\Exception $e) {
            \Log::error("OCR PDF processing failed", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'An error occurred during OCR processing. Please check logs.')->withInput();
        }
    }

    public function success_ocr_pdf()
    {
        return view('pdf_functions_without_login.OCR.success_ocr_pdf');
    }
    
}
