<?php

namespace App\Http\Controllers;
use Imagick;
use ImagickDraw;
use ImagickPixel;
use Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PageNo_PDF_Controller extends Controller
{
    
    public function page_numbers_LandPage()
    {
        return view('pdf_functions_without_login.Page_numbering.page_numbers');
    }

    public function page_numbers(Request $request)
    {
        $request->validate([
            'pdfs' => 'required|array',
            'pdfs.*' => 'file|mimes:pdf|max:10240',
            'position' => 'required|in:top-right,bottom-left,bottom-center,bottom-right',
        ]);

        $file = $request->file('pdfs')[0];
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $uniqueName = uniqid() . '_' . $sanitizedName . '.' . $extension;

        // Setup directories
        $uploadDir = public_path('uploads');
        $outputDir = public_path('numbered');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        // Move uploaded file to uploads directory
        $storedInputPath = 'uploads/' . $uniqueName;
        $fullInputPath = $uploadDir . '/' . $uniqueName;
        $file->move($uploadDir, $uniqueName);

        $images = [];
        try {
            // Convert PDF to images
            $imagick = new \Imagick();
            $imagick->setResolution(150, 150);
            $imagick->readImage($fullInputPath);
            $imagick->setImageColorspace(\Imagick::COLORSPACE_RGB);

            $pageCount = $imagick->getNumberImages();

            foreach ($imagick as $i => $page) {
                $page->setImageFormat('png');

                $hasTransparency = false;
                if ($page->getImageAlphaChannel()) {
                    $pixelIterator = $page->getPixelIterator();
                    foreach ($pixelIterator as $row) {
                        foreach ($row as $pixel) {
                            $alpha = $pixel->getColorValue(Imagick::COLOR_ALPHA);
                            if ($alpha > 0) {
                                $hasTransparency = true;
                                break 2;
                            }
                        }
                    }
                }

                if ($hasTransparency) {
                    $flattened = new \Imagick();
                    $flattened->newImage($page->getImageWidth(), $page->getImageHeight(), new \ImagickPixel('white'));
                    $flattened->compositeImage($page, \Imagick::COMPOSITE_OVER, 0, 0);
                    $flattened->setImageFormat('jpeg');
                    $imagePath = storage_path("app/temp_page_{$i}.jpg");
                    $flattened->writeImage($imagePath);
                    $flattened->destroy();
                } else {
                    $page->setImageFormat('jpeg');
                    $imagePath = storage_path("app/temp_page_{$i}.jpg");
                    $page->writeImage($imagePath);
                }

                $images[] = $imagePath;
            }

            $imagick->clear();
            $imagick->destroy();

            // Generate new PDF with page numbers using FPDF
            $pdf = new \FPDF();
            $pdf->AliasNbPages();

            foreach ($images as $index => $imagePath) {
                list($width, $height) = getimagesize($imagePath);
                $width_mm = $width * 0.264583;
                $height_mm = $height * 0.264583;

                $pdf->AddPage('P', [$width_mm, $height_mm]);
                $pdf->Image($imagePath, 0, 0, $width_mm, $height_mm);

                $pdf->SetFont('Arial', '', 8);
                $pdf->SetTextColor(100, 100, 100);
                $text = 'Page ' . ($index + 1) . ' of ' . $pageCount;

                switch ($request->position) {
                    case 'top-right':
                        $pdf->SetXY($width_mm - 30, 10);
                        break;
                    case 'bottom-left':
                        $pdf->SetXY(10, $height_mm - 25);
                        break;
                    case 'bottom-center':
                        $pdf->SetXY(($width_mm / 2) - 15, $height_mm - 25);
                        break;
                    case 'bottom-right':
                        $pdf->SetXY($width_mm - 30, $height_mm - 25);
                        break;
                }

                $pdf->Cell(30, 10, $text, 0, 0);
            }

            // Save final PDF
            $outputName = $sanitizedName . '_numbered.pdf';
            $outputPath = $outputDir . '/' . $outputName;
            $pdf->Output($outputPath, 'F');

            // Clean up temp image files
            foreach ($images as $img) {
                if (file_exists($img)) {
                    unlink($img);
                }
            }

            // Save to DB
            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);
                $originalBinary = file_get_contents($fullInputPath);

                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $file->getClientOriginalName(),
                    'input_file' => $storedInputPath,
                    'operation' => 'Page number',
                    'output_file_name' => $outputName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            $downloadLink = asset('numbered/' . $outputName);

            return redirect()->route('success_page_numbers')->with([
                'success' => 'Page numbers added successfully!',
                'pdf_file' => $downloadLink,
            ]);

        } catch (\Exception $e) {
            // Clean temp files on failure too
            foreach ($images as $img) {
                if (file_exists($img)) {
                    unlink($img);
                }
            }

            return back()->with('error', 'Failed to add page numbers: ' . $e->getMessage());
        }
    }
        
    public function success_page_numbers()
    {
        return view('pdf_functions_without_login.Page_numbering.success_page_numbers');
    }

}
