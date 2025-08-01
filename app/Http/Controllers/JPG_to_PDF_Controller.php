<?php

namespace App\Http\Controllers;
use Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

    class JPG_to_PDF_Controller extends Controller
    {
    
        public function jpg_to_pdf_LandPage()
        {
            return view('pdf_functions_without_login.jpg_to_pdf.img_to_pdf');
        }

        public function jpg_to_pdf(Request $request)
        {
            try {
                // Validate the request
                $request->validate([
                    'images' => 'required|array|min:1|max:20',
                    'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
                ]);

                $orientation = $request->input('orientation', 'portrait');
                $margin = (int) $request->input('margin', 5);

                if (!in_array($orientation, ['portrait', 'landscape', 'auto'])) {
                    $orientation = 'portrait';
                }

                // Setup directories
                $uploadDir = public_path('uploads');
                $outputDir = public_path('output_generated');

                // Create directories if they don't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                if (!file_exists($outputDir)) {
                    mkdir($outputDir, 0755, true);
                }

                // Process uploaded files
                $validFiles = [];
                $uploadedFiles = $request->file('images');
                $firstFilenameWithoutExtension = '';
                
                foreach ($uploadedFiles as $file) {
                    if ($file->isValid()) {
                        $filename = $file->getClientOriginalName();
                        $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
                        
                        if (empty($firstFilenameWithoutExtension)) {
                            $firstFilenameWithoutExtension = $filenameWithoutExtension;
                        }
                        
                        $path = $file->move($uploadDir, $filename);
                        
                        if (!getimagesize($path->getPathname())) {
                            unlink($path->getPathname());
                            continue;
                        }
                        
                        $validFiles[] = [
                            'path' => $path->getPathname(),
                            'name' => $filename
                        ];
                    }
                }

                if (empty($validFiles)) {
                    return back()->with('error', 'No valid images were uploaded.');
                }

                // Create ZIP archive
                $zipFilename = $firstFilenameWithoutExtension . '_images_' . time() . '.zip';
                $zipPath = $uploadDir . '/' . $zipFilename;
                $zipPublicPath = 'uploads/' . $zipFilename; // Path to store in DB
                
                $zip = new \ZipArchive();
                if ($zip->open($zipPath, \ZipArchive::CREATE) !== TRUE) {
                    throw new \Exception("Cannot create ZIP archive");
                }

                foreach ($validFiles as $file) {
                    $zip->addFile($file['path'], $file['name']);
                }
                $zip->close();

                // Generate PDF
                $pdf = new FPDF('P', 'mm', 'A4');
                
                try {
                    if (file_exists(public_path('fonts/times.php'))) {
                        $pdf->AddFont('times', '', 'times.php');
                    }
                    
                    $pdf->SetAutoPageBreak(true, 15);
                    $pdf->AliasNbPages();

                    foreach ($validFiles as $file) {
                        $imagePath = $file['path'];
                        list($width, $height) = getimagesize($imagePath);

                        $pdfOrientation = $orientation === 'auto' 
                            ? ($width > $height ? 'L' : 'P')
                            : ($orientation === 'landscape' ? 'L' : 'P');

                        $pdf->AddPage($pdfOrientation);
                        $pdf->SetAutoPageBreak(true, $margin);

                        $pageWidth = $pdf->GetPageWidth() - 2 * $margin;
                        $pageHeight = $pdf->GetPageHeight() - 2 * $margin;
                        $ratio = $width / $height;

                        if ($ratio > ($pageWidth / $pageHeight)) {
                            $displayWidth = $pageWidth;
                            $displayHeight = $pageWidth / $ratio;
                        } else {
                            $displayHeight = $pageHeight;
                            $displayWidth = $pageHeight * $ratio;
                        }

                        $x = ($pdf->GetPageWidth() - $displayWidth) / 2;
                        $y = $margin;
                        $pdf->Image($imagePath, $x, $y, $displayWidth, $displayHeight);
                    }

                    $outputFilename = $firstFilenameWithoutExtension . '_pdf.pdf';
                    $outputPath = $outputDir . '/' . $outputFilename;
                    $pdf->Output('F', $outputPath);

                    if (!file_exists($outputPath)) {
                        throw new \Exception("PDF file was not created");
                    }
                    
                    // Store in database
                    if (Auth::check()) {
                        $pdfBinary = file_get_contents($outputPath);
                        
                        DB::table('files')->insert([
                            'user_id' => Auth::id(),
                            'original_file_name' => $zipFilename, // Store the path
                            'operation' => 'jpg to pdf',
                            'output_file_name' => $outputFilename,
                            'file' => base64_encode($pdfBinary),
                            'input_file' => $zipPublicPath, // Store just the path string
                            'date' => now(),
                            'status' => 'success',
                        ]);
                    }
                    
                    // Clean up
                    foreach ($validFiles as $file) {
                        if (file_exists($file['path'])) {
                            unlink($file['path']);
                        }
                    }

                    $downloadLink = asset('output_generated/' . $outputFilename);
                    return redirect()->route('sucess_jpg_to_pdf')
                        ->with('success', 'PDF created with ' . count($validFiles) . ' images!')
                        ->with('downloadLink', $downloadLink)
                        ->with('download_name', $outputFilename);
                        
                } catch (\Exception $e) {
                    // Clean up on error
                    foreach ($validFiles as $file) {
                        if (file_exists($file['path'])) {
                            unlink($file['path']);
                        }
                    }
                    if (file_exists($zipPath)) {
                        unlink($zipPath);
                    }
                    \Log::error('PDF Generation Error: ' . $e->getMessage());
                    return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
                }
                
            } catch (\Exception $e) {
                \Log::error('Image to PDF Conversion Error: ' . $e->getMessage());
                return back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }

        public function success_jpg_to_pdf()
        {
            return view('pdf_functions_without_login.jpg_to_pdf.success_img_to_pdf');
        }

    }
