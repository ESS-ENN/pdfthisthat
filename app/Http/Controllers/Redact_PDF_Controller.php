<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Redact_PDF_Controller extends Controller
{

    public function redact_pdf_LandPage()
    {
         return view('pdf_functions_without_login.Redact_pdf.redact_pdf');
    }

    public function success_redact_pdf()
    {
        return view('pdf_functions_without_login.Redact_pdf.success_redact_pdf');
    }  

    public function store(Request $request)
    {
        $request->validate([
            'original_pdf' => 'required|file|mimes:pdf|max:20480',
            'redacted_pdf' => 'required|file|mimes:pdf|max:20480',
        ]);

        $original = $request->file('original_pdf');
        $redacted = $request->file('redacted_pdf');

        // Generate unique names
        $originalName = $original->getClientOriginalName();
        $storedOriginalName = time() .  '_original.pdf';
        $storedRedactedName = time() .  '_redacted.pdf';

        // Define paths
        $inputPath = public_path('uploads/' . $storedOriginalName);
        $outputPath = public_path('output_generated/' . $storedRedactedName);

        // Move files
        $original->move(public_path('uploads'), $storedOriginalName);
        $redacted->move(public_path('output_generated'), $storedRedactedName);

        // Store in DB if logged in
        if (Auth::check()) {
            $pdfBinary = file_get_contents($outputPath);

            DB::table('files')->insert([
                'user_id' => Auth::id(),
                'original_file_name' => $originalName,
                'input_file' => 'uploads/' . $storedOriginalName,
                'operation' => 'Redact Pdf',
                'output_file_name' => $storedRedactedName,
                'file' => base64_encode($pdfBinary),
                'date' => now(),
                'status' => 'success',
            ]);
        }

        return response()->json(['success' => true]);
    }
    
}
