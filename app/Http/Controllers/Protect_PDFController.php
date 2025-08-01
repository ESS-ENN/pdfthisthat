<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Protect_PDFController extends Controller
{
    public function protect_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Protect_pdf.protect_pdf');
    }

    public function protect_pdf(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'pdf_password' => 'required|string|min:1',
        ]);

        $password = $request->input('pdf_password');

        // Setup folders
        $uploadDir = public_path('uploads');
        $outputDir = public_path('encrypted_pdfs');

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $file = $request->file('pdf');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $uniqueName = uniqid() . '_' . $sanitizedName . '.' . $extension;

        // Move uploaded file
        $storedInputPath = 'uploads/' . $uniqueName;
        $fullInputPath = $uploadDir . '/' . $uniqueName;
        $file->move($uploadDir, $uniqueName);

        // Output path
        $outputName = $sanitizedName . '_protected.pdf';
        $outputPath = $outputDir . '/' . $outputName;

        try {
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->SetProtection(['copy', 'print'], $password);

            $pageCount = $mpdf->SetSourceFile($fullInputPath);

            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $mpdf->ImportPage($i);
                $mpdf->AddPage();
                $mpdf->UseTemplate($templateId);
            }

            $mpdf->Output($outputPath, \Mpdf\Output\Destination::FILE);

            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);

                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $file->getClientOriginalName(),
                    'input_file' => $storedInputPath,
                    'operation' => 'Protect Pdf',
                    'output_file_name' => $outputName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            $downloadLink = asset('encrypted_pdfs/' . $outputName);

            return redirect()->route('success_protect_pdf')->with([
                'success' => 'PDF encrypted successfully.',
                'downloadLink' => $downloadLink,
                'download_name' => $outputName,
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Encryption failed: ' . $e->getMessage());
        }
    }

    public function Successful_protect_pdf()
    {
         return view('pdf_functions_without_login.Protect_pdf.success_protect_pdf');
    }

}
