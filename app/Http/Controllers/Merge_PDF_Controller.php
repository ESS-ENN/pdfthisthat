<?php

namespace App\Http\Controllers;
use Imagick;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Merge_PDF_Controller extends Controller
{
    
    public function Merge_PDF_LandPage()
    {
        return view('pdf_functions_without_login.Merge_pdf.merge_pdfs');
    }
        
    public function Merge_PDF(Request $request)
    {
        if (!$request->has('merge')) {
            return redirect()->back()->with('error', 'Please select PDFs to merge.');
        }

        $uploadDir = public_path('uploads');
        $imagesDir = public_path('pdf_images');
        $outputDir = public_path('output_generated');
        $inputPdfsDir = public_path('input_pdfs'); // New directory for input PDFs

        foreach ([$uploadDir, $imagesDir, $outputDir, $inputPdfsDir] as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
        }
       

        // Clear old files in images directory
        $items = glob("$imagesDir/*");
        foreach ($items as $item) {
            if (is_file($item)) {
                unlink($item);
            }
        }

        $uploadedFiles = [];
        $originalFilenames = [];
        $inputPdfPaths = [];

        // Handle file uploads and preserve order
        if ($request->hasFile('pdfs')) {
            foreach ($request->file('pdfs') as $file) {
                if ($file->isValid() && $file->getClientOriginalExtension() === 'pdf') {
                    $filename = $file->getClientOriginalName();
                    $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
                    
                    // Store in uploads directory for processing
                    $file->move($uploadDir, $filename);
                    $uploadedFiles[] = $uploadDir . '/' . $filename;
                    
                    // Also store in input_pdfs directory for archiving
                    $inputPdfPath = $inputPdfsDir . '/' . $filename;
                    copy($uploadDir . '/' . $filename, $inputPdfPath);
                    $inputPdfPaths[] = $inputPdfPath;
                    
                    $originalFilenames[] = $filename;
                }
            }
        }

        if (empty($uploadedFiles)) {
            return redirect()->back()->with('error', 'No valid PDFs were uploaded.');
        }

        // Create zip archive of input PDFs
        $zipFileName = 'input_pdfs_' . time() . '.zip';
        $zipFilePath = $inputPdfsDir . '/' . $zipFileName;
        $zip = new \ZipArchive();
        
        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            foreach ($inputPdfPaths as $pdfPath) {
                $zip->addFile($pdfPath, basename($pdfPath));
            }
            $zip->close();
            
            // Clean up individual PDF files after zipping
            array_map('unlink', $inputPdfPaths);
        } else {
            \Log::error("Failed to create zip archive of input PDFs");
        }

        $imageCounter = 1;

        // Convert each PDF page to flattened image in order of upload
        foreach ($uploadedFiles as $pdfFile) {
            try {
                $tempImagick = new Imagick();
                $tempImagick->pingImage($pdfFile);
                $numPages = $tempImagick->getNumberImages();
                $tempImagick->clear();
                $tempImagick->destroy();

                for ($i = 0; $i < $numPages; $i++) {
                    $imagick = new Imagick();
                    $imagick->setResolution(150, 150);
                    $imagick->readImage("{$pdfFile}[$i]");

                    // Flatten transparent background to white
                    $imagick->setImageBackgroundColor('white');
                    $flattened = $imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

                    $flattened->setImageFormat('jpg');
                    $imageName = 'page_' . str_pad($imageCounter, 4, '0', STR_PAD_LEFT) . '.jpg';
                    $flattened->writeImage($imagesDir . '/' . $imageName);

                    $flattened->clear();
                    $flattened->destroy();
                    $imagick->clear();
                    $imagick->destroy();

                    $imageCounter++;
                }
            } catch (\Exception $e) {
                \Log::error("PDF to image conversion failed for {$pdfFile}: " . $e->getMessage());
                continue;
            }
        }

        // Get images in correct order
        $imageFiles = glob($imagesDir . '/*.jpg');
        natsort($imageFiles); // Ensures page_0001, page_0002, etc. in order

        if (empty($imageFiles)) {
            return redirect()->back()->with('error', 'No images generated from PDFs.');
        }

        // Convert images to a single PDF
        try {
            $pdf = new Imagick();

            foreach ($imageFiles as $image) {
                $page = new Imagick();
                $page->readImage($image);
                $page->setImageFormat('pdf');
                $pdf->addImage($page);
                $page->clear();
                $page->destroy();
            }

            $mergedFileName = $filenameWithoutExtension . '_merged.pdf';
            $outputPath = $outputDir . '/' . $mergedFileName;

            $pdf->writeImages($outputPath, true);
            $pdf->clear();
            $pdf->destroy();

            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);
                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => implode(', ', $originalFilenames),
                    'input_file' => 'input_pdfs/' . $zipFileName, // Store the zip file path
                    'operation' => 'Merge Pdf',
                    'output_file_name' => $mergedFileName,
                    'file' => base64_encode($pdfBinary), // Encode if needed
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            if (file_exists($outputPath)) {
                $downloadLink = url('output_generated/' . $mergedFileName);
                return redirect()->route('success_merge_pdf')->with([
                    'success' => 'PDFs merged successfully!',
                    'downloadLink' => $downloadLink,
                    'download' => $mergedFileName
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Image to PDF merge failed: " . $e->getMessage());
        }

        return redirect()->back()->with('error', 'Failed to generate merged PDF.');
    }

    public function Successful_Merge_PDF()
    {
        return view('pdf_functions_without_login.Merge_pdf.success_merge_pdf');
    }



}
