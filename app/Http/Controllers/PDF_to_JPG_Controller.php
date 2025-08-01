<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PDF_to_JPG_Controller extends Controller
{
    
    public function pdf_to_jpg_LandPage()
    {
        return view('pdf_functions_without_login.Pdf_to_jpg.pdf_to_jpg');
    }

    public function pdf_to_jpg(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        $pdfFile = $request->file('pdf');

        $userId = Auth::check() ? Auth::id() : 'guest';
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
        $uniqueName = $userId . '_pdf_' . $timestamp;

        $uploadDir = public_path('uploads');
        $baseImageDir = public_path('pdf_images');
        $imageSubDir = $baseImageDir . '/' . $uniqueName;

        // Ensure directories exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        if (!file_exists($imageSubDir)) {
            mkdir($imageSubDir, 0775, true);
        }

        // Move uploaded file
        $uploadedPath = $uploadDir . '/' . $uniqueName . '.pdf';
        $pdfFile->move($uploadDir, $uniqueName . '.pdf');

        // Ghostscript path
        if (PHP_OS_FAMILY === 'Windows') {
            $ghostscript = '"' . public_path('ghostscript/gswin64c.exe') . '"';
        } else {
            $ghostscript = 'gs'; // Linux/macOS
        }

        $outputImagePattern = $imageSubDir . '/page_%d.jpg';
        $cmd = "$ghostscript -dNOPAUSE -dBATCH -sDEVICE=jpeg -r200 -sOutputFile=\"{$outputImagePattern}\" \"{$uploadedPath}\"";
        exec($cmd, $output, $status);

        if ($status === 0) {
            $imageFiles = glob($imageSubDir . '/page_*.jpg');
            $images = [];

            foreach ($imageFiles as $img) {
                $filename = basename($img);
                $images[] = [
                    'url' => asset('pdf_images/' . $uniqueName . '/' . $filename),
                    'name' => $filename,
                    'page' => (int) preg_replace('/page_(\d+)\.jpg/', '$1', $filename),
                ];

                if (Auth::check()) {
                    DB::table('files')->insert([
                        'user_id' => $userId,
                        'original_file_name' => $pdfFile->getClientOriginalName(),
                        'input_file' => 'uploads/' . $uniqueName . '.pdf',
                        'operation' => 'Pdf to Image',
                        'output_file_name' => $filename,
                        'file' => base64_encode(file_get_contents($img)),
                        'date' => now(),
                        'status' => 'success',
                    ]);
                }
            }

            return redirect()->route('success_pdf_to_jpg')->with([
                'success' => 'Images converted successfully.',
                'images' => $images,
            ]);
        } else {
            return back()->withErrors([
                'conversion' => 'Ghostscript failed. Please ensure it is installed and correctly configured.',
            ]);
        }
    }

    public function successful_protect_pdf()
    {
         return view('pdf_functions_without_login.Pdf_to_jpg.success_pdf_to_jpg');
    }

}
