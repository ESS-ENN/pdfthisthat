<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use Imagick;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\PdfReader\PdfReader;
use Illuminate\Support\Facades\Log;
use PDF; 

use Illuminate\Http\Request;

class Edit_Controller extends Controller
{
    public function Edit_LandPage()
    {
        return view('pdf_functions_without_login.Edit.edit_pdf');
    }

    public function pdf_Editor(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:20480',
        ]);

        try {
            // Create upload directory if it doesn't exist
            $uploadDir = public_path('uploads/');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate unique filename and path
            $fileName = $request->file('pdf_file')->getClientOriginalName();
            $uploadPath = $uploadDir . $fileName;

            // Move uploaded file
            $request->file('pdf_file')->move($uploadDir, $fileName);

            // Store path in session
            session(['pdf_path' => 'uploads/' . $fileName]);
            
            // Convert PDF to images
            $imagesDir = public_path('uploads/images/');
            if (!file_exists($imagesDir)) {
                mkdir($imagesDir, 0777, true);
            }

            $pdfImages = [];
            $imagick = new Imagick();
            $imagick->setResolution(150, 150);
            $imagick->readImage($uploadPath);
            $imagick->setImageFormat('jpeg');

            foreach ($imagick as $i => $page) {
                $imageName = 'page_' . ($i + 1) . '.jpg';
                $imagePath = $imagesDir . $imageName;
                $page->writeImage($imagePath);
                
                // Store relative path for web access
                $pdfImages[] = 'uploads/images/' . $imageName;
            }

            // Clean up Imagick resources
            $imagick->clear();
            $imagick->destroy();

            // Store image paths in session
            session(['pdf_images' => $pdfImages]);

            return view('pdf_functions_without_login.Edit.editor_pdf', [
                'pdfImages' => $pdfImages
            ]);
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'PDF processing failed: ' . $e->getMessage()]);
        }
    }
    
    public function generatePdf(Request $request)
    {
    
        // Validate input
        if (!session()->has('pdf_images')) {
            throw new \Exception('No PDF images found in session');
        }

        $canvasData = $request->input('images');
        if (empty($canvasData)) {
            throw new \Exception('No canvas data received');
        }

        // Prepare directories
        $outputDir = public_path('generated_pdfs/');
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        // Generate unique filename
        $filename = 'edited_' . uniqid() . '.pdf';
        $outputPath = $outputDir . $filename;

        // Process each canvas image
        $imagick = new Imagick();
        $imagick->setResolution(150, 150);

        foreach ($canvasData as $index => $imageData) {
            // Remove data URL prefix
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $imageBinary = base64_decode($imageData);

            $page = new Imagick();
            $page->readImageBlob($imageBinary);
            $page->setImageFormat('pdf');
            $imagick->addImage($page);
            $page->clear();
        }

        // Save as PDF
        $imagick->setImageFormat('pdf');
        $imagick->writeImages($outputPath, true);
        $imagick->clear();

        // Return JSON response for AJAX requests
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'pdf_url' => '/generated_pdfs/' . $filename,
                'filename' => $filename
            ]);
        }

        // For non-AJAX requests, redirect to download
        return redirect('/generated_pdfs/' . $filename);
    }

    public function success_pdf_Editor()
    {        
      return view('pdf_functions_without_login.Edit.success_edit_pdf');
    }

    public function uploadEditedPdf(Request $request)
    {
        // Edited PDF file must exist
        if (!$request->hasFile('pdf')) {
            return response()->json(['success' => false, 'message' => 'Edited PDF is required.']);
        }

        $editedFile = $request->file('pdf');

        // Get original file path from request or session
        $originalFilePath = $request->input('original_pdf_path', session('pdf_path'));

        if (!$originalFilePath || !file_exists(public_path($originalFilePath))) {
            return response()->json(['success' => false, 'message' => 'Original PDF not found.']);
        }

        $originalName = basename($originalFilePath);

        // Save edited PDF
        $editedFilename = 'edited_' . time() . '.' . $editedFile->getClientOriginalExtension();
        $editedFile->move(public_path('output_generated'), $editedFilename);

        $pdfBinary = file_get_contents(public_path("output_generated/{$editedFilename}"));

        // Insert record into DB
        $fileId = DB::table('files')->insertGetId([
            'user_id' => Auth::check() ? Auth::id() : null,
            'original_file_name' => $originalName,
            'input_file' => $originalFilePath,
            'operation' => 'Edit Pdf',
            'output_file_name' => $editedFilename,
            'file' => base64_encode($pdfBinary),
            'date' => now(),
            'status' => 'success'
        ]);

        return response()->json(['success' => true, 'file_id' => $fileId]);
    }
        
}


