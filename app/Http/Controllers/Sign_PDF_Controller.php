<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Sign_PDF_Controller extends Controller
{

    public function sign_pdf_LandPage()
    {
         return view('pdf_functions_without_login.Sign_pdf.sign_pdf');
    }

    public function success_sign_pdf()
    {
        return view('pdf_functions_without_login.Sign_pdf.success_sign_pdf');
    }

    public function storeSignedPdf(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$request->hasFile('pdf_file') || !$request->hasFile('signed_pdf')) {
            return response()->json(['error' => 'Missing files'], 400);
        }

        $original = $request->file('pdf_file');
        $signed = $request->file('signed_pdf');

        $uploadDir = public_path('uploads');
        $outputDir = public_path('output_generated');
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        if (!file_exists($outputDir)) mkdir($outputDir, 0777, true);

        $inputFilename = time()  . $original->getClientOriginalName();
        $outputFilename = time() . '_signed_' . $original->getClientOriginalName();

        $original->move($uploadDir, $inputFilename);
        $signed->move($outputDir, $outputFilename);

        $pdfBinary = file_get_contents($outputDir . '/' . $outputFilename);

        DB::table('files')->insert([
            'user_id' => Auth::id(),
            'original_file_name' => $original->getClientOriginalName(),
            'input_file' => 'uploads/' . $inputFilename,
            'operation' => 'Sign Pdf',
            'output_file_name' => $outputFilename,
            'file' => base64_encode($pdfBinary),
            'date' => now(),
            'status' => 'success',
        ]);

        return response()->json(['success' => true]);
    }


}
