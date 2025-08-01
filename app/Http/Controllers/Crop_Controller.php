<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Crop_Controller extends Controller
{
   public function crop_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Crop.crop_pdf');
    }

    public function successPage()
    {
        return view('pdf_functions_without_login.Crop.success_crop_pdf');
    }

    // public function uploadCroppedPdf(Request $request)
    // {
    //     try {
    //         if (!$request->hasFile('cropped_pdf')) {
    //             Log::error('No cropped_pdf file in request.');
    //             return response()->json(['success' => false, 'error' => 'No file uploaded']);
    //         }

    //         // Save original PDF
    //         if ($request->hasFile('original_pdf')) {
    //             $originalFile = $request->file('original_pdf');
    //             $originalName = $originalFile->getClientOriginalName();
    //             $inputFileName = time() . '_input_' . $originalName;

    //             $uploadPath = public_path('uploads');
    //             if (!file_exists($uploadPath)) {
    //                 mkdir($uploadPath, 0777, true);
    //             }

    //             $originalFile->move($uploadPath, $inputFileName);
    //         } else {
    //             $originalName = 'unknown_original.pdf';
    //             $inputFileName = null;
    //         }

    //         // Save cropped PDF
    //         $croppedFile = $request->file('cropped_pdf');
    //         $croppedOriginalName = $croppedFile->getClientOriginalName();
    //         $storedOutputName = time() . '_cropped_' . $croppedOriginalName;

    //         $outputPath = public_path('output_generated');
    //         if (!file_exists($outputPath)) {
    //             mkdir($outputPath, 0777, true);
    //         }

    //         $croppedFile->move($outputPath, $storedOutputName);

    //         // Store in DB only if user is authenticated
    //         if (Auth::check()) {
    //             $binary = file_get_contents($outputPath . '/' . $storedOutputName);
    //             $base64 = base64_encode($binary);

    //             DB::table('files')->insert([
    //                 'user_id' => Auth::id(),
    //                 'original_file_name' => $originalName,
    //                 'input_file' => $inputFileName ? 'uploads/' . $inputFileName : null,
    //                 'operation' => 'crop',
    //                 'output_file_name' => $storedOutputName,
    //                 'file' => $base64,
    //                 'date' => now(),
    //                 'status' => 'success'
    //             ]);
    //         }

    //         return response()->json(['success' => true]);

    //     } catch (\Exception $e) {
    //         Log::error('uploadCroppedPdf error', ['error' => $e->getMessage()]);
    //         return response()->json(['success' => false, 'error' => 'Server error']);
    //     }
    // }

    public function uploadCroppedPdf(Request $request)
    {
        try {
            Log::info('uploadCroppedPdf called');

            if (!$request->hasFile('cropped_pdf') || !$request->hasFile('pdf_file')) {
                Log::error('No cropped_pdf file in request.');
                return response()->json(['success' => false, 'error' => 'No cropped PDF uploaded']);
            }
            $original = $request->file('pdf_file');

            // Directory setup
            $outputPath = public_path('output_generated');
            $uploadDir = public_path('uploads');
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
            if (!file_exists($outputPath)) {
                mkdir($outputPath, 0777, true);
            }

            // Handle uploaded cropped PDF
            $inputFilename = time()  . $original->getClientOriginalName();
            $croppedFile = $request->file('cropped_pdf');
            $croppedFileName = $croppedFile->getClientOriginalName();
            $outputFilename = time() . '_cropped_' . $croppedFileName;
            $croppedFile->move($outputPath, $outputFilename);
             $original->move($uploadDir, $inputFilename);
            $outputFilePath = $outputPath . '/' . $outputFilename;

            Log::info('Cropped PDF saved at: ' . $outputFilePath);

            // Store to DB if user is logged in
            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputFilePath);
                $encodedPdf = base64_encode($pdfBinary);

                DB::table('files')->insert([
                    'user_id'            => Auth::id(),
                    'original_file_name' => 'input_pdf',
                    'input_file'         => 'uploads/' . $inputFilename,
                    'operation'          => 'Crop Pdf',
                    'output_file_name'   => $outputFilename,
                    'file'               => $encodedPdf,
                    'date'               => now(),
                    'status'             => 'success'
                ]);

                Log::info('PDF stored in DB for user ID: ' . Auth::id());
            } else {
                Log::info('User not authenticated. Skipping DB insert.');
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(), // 👈 TEMP for debugging only
                'trace' => $e->getTraceAsString() // 👈 TEMP
            ]);

            return response()->json(['success' => false, 'error' => 'Server error']);
        }
    }
      
    // public function successPage()
    // {
    //     return view('pdf_functions_without_login.Crop.success_crop_pdf');
    // }
  
}
