<?php

namespace App\Http\Controllers;
use Imagick;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Rotate_Controller extends Controller
{
    public function rotate_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Rotate.rotate_pdf');
    }

    public function rotate_pdf(Request $request)
    {
        $request->validate([
            'pdfs' => 'required|array',
            'pdfs.*' => 'mimes:pdf|max:51200', // Max 50MB each
            'rotation' => 'required|in:90,180,270,360',
        ]);

        $angle = (int) $request->rotation;
        $downloadFiles = [];

        // Ensure necessary folders
        $uploadDir = public_path('uploads');
        $outputDir = public_path('rotated');

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        foreach ($request->file('pdfs') as $file) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $uniqueName = uniqid() . '_' . $sanitizedName . '.' . $extension;

            // Save uploaded file to public/uploads
            $storedInputPath = 'uploads/' . $uniqueName;
            $fullInputPath = $uploadDir . '/' . $uniqueName;
            $file->move($uploadDir, $uniqueName);

            $outputName = $sanitizedName . '_rotated.pdf';
            $outputPath = $outputDir . DIRECTORY_SEPARATOR . $outputName;

            try {
                $imagick = new \Imagick();
                $imagick->setResolution(150, 150);
                $imagick->readImage($fullInputPath);
                $imagick->setImageFormat("pdf");

                foreach ($imagick as $page) {
                    $page->rotateImage(new \ImagickPixel('white'), $angle);
                    if ($page->getImageWidth() === 0 || $page->getImageHeight() === 0) {
                        throw new \Exception("Invalid page dimensions. Make sure Ghostscript is installed.");
                    }
                }

                $imagick->writeImages($outputPath, true);
                $imagick->clear();
                $imagick->destroy();

                $downloadFiles[] = asset("rotated/{$outputName}");

                // DB insert per file
                if (Auth::check()) {
                    $pdfBinary = file_get_contents($outputPath);

                    DB::table('files')->insert([
                        'user_id' => Auth::id(),
                        'original_file_name' => $originalName,
                        'input_file' => $storedInputPath,
                        'operation' => 'Rotate Pdf',
                        'output_file_name' => $outputName,
                        'file' => base64_encode($pdfBinary),
                        'date' => now(),
                        'status' => 'success',
                    ]);
                }

            } catch (\Exception $e) {
                return back()->with('error', 'Rotation failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('success_rotate_pdf')->with([
            'success' => 'PDF(s) rotated successfully!',
            'downloadLink' => $downloadFiles[0] ?? null,
            'download_name' => basename($downloadFiles[0] ?? ''),
        ]);
    }

    public function success_rotate_pdf()
    {
        return view('pdf_functions_without_login.Rotate.success_rotate_pdf');
    }
    
}
