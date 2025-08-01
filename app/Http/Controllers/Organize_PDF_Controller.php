<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use Fpdf\Fpdf;
use Imagick;
use ImagickPixel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Organize_PDF_Controller extends Controller
{
    public function organize_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Organize_pdf.organize_pdf');
    }
 
    public function organize_pdf(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:20480',
            'page_order' => 'required|string',
            'remove_pages' => 'nullable|string'
        ]);

        $pageOrderArray = array_map('intval', explode(',', $request->input('page_order')));
        $removePagesArray = array_filter(array_map('intval', explode(',', $request->input('remove_pages', ''))));

        $file = $request->file('pdf_file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $uniqueName = uniqid() . '_' . $sanitizedName . '.' . $extension;

        // Setup folders
        $uploadDir = public_path('uploads');
        $imageDir = storage_path('app/temp_images');
        $outputDir = public_path('organized');

        foreach ([$uploadDir, $imageDir, $outputDir] as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0775, true);
            }
        }

        // Move file to uploads directory
        $storedInputPath = 'uploads/' . $uniqueName;
        $fullInputPath = $uploadDir . '/' . $uniqueName;
        $file->move($uploadDir, $uniqueName);

        try {
            // Convert PDF to images
            $imagick = new \Imagick();
            $imagick->setResolution(150, 150);
            $imagick->readImage($fullInputPath);
            $imagick->setImageColorspace(\Imagick::COLORSPACE_RGB);

            $pageCount = $imagick->getNumberImages();
            if ($pageCount === 0) {
                throw new \Exception('PDF has 0 pages or failed to load.');
            }

            $allOriginalPages = range(1, $pageCount);
            $combinedPages = array_unique(array_merge($pageOrderArray, $removePagesArray));
            sort($combinedPages);

            if ($combinedPages !== $allOriginalPages) {
                return back()->with('error', 'All pages must be included in either the new order or remove list.');
            }

            foreach ($pageOrderArray as $pageNumber) {
                if ($pageNumber < 1 || $pageNumber > $pageCount) {
                    return back()->with('error', "Invalid page number in order: $pageNumber.");
                }
            }

            // Extract pages as images
            $imagePaths = [];
            for ($i = 0; $i < $pageCount; $i++) {
                $imagick->setIteratorIndex($i);
                $imagick->setImageFormat('jpg');

                if ($imagick->getImageAlphaChannel()) {
                    $canvas = new \Imagick();
                    $canvas->newImage(
                        $imagick->getImageWidth(),
                        $imagick->getImageHeight(),
                        new \ImagickPixel('white')
                    );
                    $canvas->compositeImage($imagick, \Imagick::COMPOSITE_OVER, 0, 0);
                    $canvas->setImageFormat('jpg');
                    $imageBlob = $canvas->getImageBlob();
                    $canvas->clear();
                    $canvas->destroy();
                } else {
                    $imageBlob = $imagick->getImageBlob();
                }

                $imagePath = $imageDir . '/page_' . ($i + 1) . '.jpg';
                file_put_contents($imagePath, $imageBlob);
                $imagePaths[$i + 1] = $imagePath;
            }

            $imagick->clear();
            $imagick->destroy();

            // Build new PDF with selected page order
            $pdf = new \setasign\Fpdi\Fpdi();

            foreach ($pageOrderArray as $pageNumber) {
                if (in_array($pageNumber, $removePagesArray)) {
                    continue;
                }

                if (!isset($imagePaths[$pageNumber])) {
                    throw new \Exception("Missing page $pageNumber.");
                }

                $imagePath = $imagePaths[$pageNumber];
                list($width, $height) = getimagesize($imagePath);

                $pdf->AddPage($width > $height ? 'L' : 'P', [$width, $height]);
                $pdf->Image($imagePath, 0, 0, $width, $height);
            }

            $outputName = $sanitizedName . '_organized.pdf';
            $outputPath = $outputDir . '/' . $outputName;
            $pdf->Output('F', $outputPath);

            // Clean temp images
            array_map('unlink', glob($imageDir . '/*.jpg'));

            // Save in DB
            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);

                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $file->getClientOriginalName(),
                    'input_file' => $storedInputPath,
                    'operation' => 'Organize Pdf',
                    'output_file_name' => $outputName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            $downloadLink = asset('organized/' . $outputName);

            return redirect()->route('success_organize_pdf')->with([
                'success' => 'PDF pages organized successfully!',
                'downloadLink' => $downloadLink,
                'download_name' => $outputName,
            ]);

        } catch (\Exception $e) {
            Log::error('Organize PDF failed: ' . $e->getMessage());
            array_map('unlink', glob($imageDir . '/*.jpg'));

            return back()->with('error', 'Failed to organize PDF: ' . $e->getMessage());
        }
    }

    public function success_organize_pdf()
    {
        return view('pdf_functions_without_login.Organize_pdf.success_organize_pdf');
    }

}
