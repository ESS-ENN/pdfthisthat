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

class RemovePage_Controller extends Controller
{
    
    public function remove_page_LandPage()
    {
        return view('pdf_functions_without_login.Remove_pages.remove_pages');
    }
 
    public function remove_page(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:20480',
            'remove_pages' => 'nullable|string'
        ]);

        $removePages = array_filter(array_unique(array_map('intval', explode(',', $request->input('remove_pages', '')))));

        // Ensure necessary folders
        $uploadDir = public_path('uploads');
        $imageDir = public_path('temp_images');
        $outputDir = public_path('processed');

        foreach ([$uploadDir, $imageDir, $outputDir] as $dir) {
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

        $outputName = $sanitizedName . '_pages_removed.pdf';
        $outputPath = $outputDir . DIRECTORY_SEPARATOR . $outputName;

        try {
            $imagick = new \Imagick();
            $imagick->setResolution(150, 150);
            $imagick->readImage($fullInputPath);
            $imagick->setImageColorspace(\Imagick::COLORSPACE_RGB);

            $pageCount = $imagick->getNumberImages();
            if ($pageCount < 1) {
                throw new \Exception("PDF has no pages.");
            }

            $imagePaths = [];
            for ($i = 0; $i < $pageCount; $i++) {
                $pageNumber = $i + 1;
                if (in_array($pageNumber, $removePages)) continue;

                $imagick->setIteratorIndex($i);
                $imagick->setImageFormat('jpg');

                // If transparent, add white background
                if ($imagick->getImageAlphaChannel()) {
                    $canvas = new \Imagick();
                    $canvas->newImage($imagick->getImageWidth(), $imagick->getImageHeight(), new \ImagickPixel('white'));
                    $canvas->compositeImage($imagick, \Imagick::COMPOSITE_OVER, 0, 0);
                    $canvas->setImageFormat('jpg');
                    $imageBlob = $canvas->getImageBlob();
                    $canvas->clear();
                    $canvas->destroy();
                } else {
                    $imageBlob = $imagick->getImageBlob();
                }

                $imagePath = $imageDir . "/page_$pageNumber.jpg";
                file_put_contents($imagePath, $imageBlob);
                $imagePaths[$pageNumber] = $imagePath;
            }

            $imagick->clear();
            $imagick->destroy();

            // Build new PDF
            $pdf = new \setasign\Fpdi\Fpdi();
            foreach ($imagePaths as $page => $path) {
                $size = getimagesize($path);
                $pdf->AddPage($size[0] > $size[1] ? 'L' : 'P', [$size[0], $size[1]]);
                $pdf->Image($path, 0, 0, $size[0], $size[1]);
            }

            $pdf->Output('F', $outputPath);

            // Clean up temp images
            array_map('unlink', glob("$imageDir/*"));

            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);

                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $originalName,
                    'input_file' => $storedInputPath,
                    'operation' => 'Remove Page',
                    'output_file_name' => $outputName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            return redirect()->route('success_remove_page')->with([
                'success' => 'Selected pages removed successfully!',
                'downloadLink' => asset("processed/{$outputName}"),
                'download_name' => $outputName,
            ]);

        } catch (\Exception $e) {
            \Log::error("PDF page removal failed", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'An error occurred while processing the PDF. Please check logs.')->withInput();
        }
    }

    public function success_remove_page()
    {
        return view('pdf_functions_without_login.Remove_pages.success_remove_pages');
    }

}
