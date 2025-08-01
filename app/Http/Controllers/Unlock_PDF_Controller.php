<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Unlock_PDF_Controller extends Controller
{
    
    public function unlock_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Unlock_pdf.unlock_pdf');
    }
  
    public function unlock_pdf(Request $request)
    {
        // Validate inputs
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:20480',
            'pdf_password' => 'required|string',
        ]);

        try {
            // Handle uploaded file
            $file = $request->file('pdf');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $uniqueName = uniqid() . '_' . $sanitizedName . '.' . $extension;

            $uploadDir = public_path('uploads');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $file->move($uploadDir, $uniqueName);
            $inputFilePath = public_path('uploads/' . $uniqueName);
            $storedInputPath = 'uploads/' . $uniqueName;

            // Prepare output path
            $outputDir = public_path('output');
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $outputFileName = 'unlocked_' . $sanitizedName . '.pdf';
            $outputPath = $outputDir . '/' . $outputFileName;

            // Ghostscript binary based on OS
            if (PHP_OS_FAMILY === 'Windows') {
                $ghostscript = '"' . public_path('ghostscript/gswin64c.exe') . '"';
            } else {
                $ghostscript = 'gs';  // Linux/Unix
            }

            // Escape all arguments
            $password = $request->input('pdf_password');
            if (!preg_match('/^[\x20-\x7E]*$/', $password)) {
                throw new \Exception('Password contains invalid characters.');
            }

            $escapedPassword = escapeshellarg($password);
            $escapedInput = escapeshellarg($inputFilePath);
            $escapedOutput = escapeshellarg($outputPath);

            // Ghostscript unlock command
            $cmd = "$ghostscript -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite " .
                "-dPDFSTOPONERROR -dPDFSETTINGS=/prepress " .
                "-sPDFPassword=$escapedPassword " .
                "-sOutputFile=$escapedOutput $escapedInput 2>&1";

            exec($cmd, $output, $returnCode);

            // Remove uploaded file (optional; comment out if keeping)
            // @unlink($inputFilePath);

            if ($returnCode === 0 && file_exists($outputPath)) {
                // Save record to DB if user is logged in
                if (Auth::check()) {
                    $pdfBinary = file_get_contents($outputPath);
                    DB::table('files')->insert([
                        'user_id' => Auth::id(),
                        'original_file_name' => $originalName,
                        'input_file' => $storedInputPath,
                        'operation' => 'Unlock Pdf',
                        'output_file_name' => $outputFileName,
                        'file' => base64_encode($pdfBinary),
                        'date' => now(),
                        'status' => 'success',
                    ]);
                }

                return redirect()->route('success_unlock_pdf')->with([
                    'success' => 'PDF unlocked successfully.',
                    'downloadLink' => asset('output/' . $outputFileName),
                    'download_name' => $outputFileName,
                ]);
            } else {
                $errorOutput = implode("\n", $output);
                throw new \Exception('Ghostscript failed: ' . $errorOutput);
            }

        } catch (\Exception $e) {
            // Cleanup if needed
            if (isset($inputFilePath) && file_exists($inputFilePath)) {
                @unlink($inputFilePath);
            }
            if (isset($outputPath) && file_exists($outputPath)) {
                @unlink($outputPath);
            }

            return back()->with('error', 'Failed to unlock PDF: ' . $e->getMessage());
        }
    }


    public function success_unlock_pdf()
    {
        return view('pdf_functions_without_login.Unlock_pdf.success_unlock_pdf');
    }

}
