<?php

namespace App\Http\Controllers;
use setasign\Fpdi\Fpdi;
use Fpdf\Fpdf;
use Imagick;
use ImagickPixel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Split_PDF_Controller extends Controller
{
    
    public function split_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Split_pdf.split_pdf');
    }

    public function split_pdf(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:20480', // Max 20MB
            'page_range' => 'required|string',
        ]);

        $pdfFile = $request->file('pdf_file');
        $pageRange = str_replace(' ', '', $request->input('page_range'));
        $originalName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $pdfFile->getClientOriginalExtension();
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $uniqueName = uniqid() . '_' . $sanitizedName . '.' . $extension;

        // Validate page range format: 1,3,5-6 etc.
        if (!preg_match('/^(\d+(-\d+)?)(,(\d+(-\d+)?))*$/', $pageRange)) {
            return back()->with('error', 'Invalid page range format. Use formats like 1,3,5-7.');
        }

        // Ensure folders exist
        $uploadDir = public_path('uploads');
        $imageDir = public_path('split_images');
        $outputDir = public_path('split_pdfs');

        foreach ([$uploadDir, $imageDir, $outputDir] as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0775, true);
            }
        }

        // Save uploaded file to uploads with unique name
        $pdfFile->move($uploadDir, $uniqueName);
        $inputPath = $uploadDir . '/' . $uniqueName;
        $storedInputPath = 'uploads/' . $uniqueName;

        try {
            // Convert all pages to images
            $imagick = new \Imagick();
            $dpi = 150;
            $imagick->setResolution($dpi, $dpi);
            $imagick->readImage($inputPath);
            $imagick->setImageColorspace(\Imagick::COLORSPACE_RGB);
            $pageCount = $imagick->getNumberImages();

            // Extract user-specified pages
            $pagesToExtract = [];
            foreach (explode(',', $pageRange) as $part) {
                if (strpos($part, '-') !== false) {
                    [$start, $end] = explode('-', $part);
                    $start = (int)$start;
                    $end = (int)$end;
                    if ($start < 1 || $end > $pageCount || $start > $end) {
                        return back()->with('error', "Invalid range: $part exceeds PDF page count ($pageCount).");
                    }
                    $pagesToExtract = array_merge($pagesToExtract, range($start, $end));
                } else {
                    $page = (int)$part;
                    if ($page < 1 || $page > $pageCount) {
                        return back()->with('error', "Page $page is out of bounds. PDF has $pageCount pages.");
                    }
                    $pagesToExtract[] = $page;
                }
            }

            // Convert and save only selected pages as images
            $imagePaths = [];
            foreach ($pagesToExtract as $index) {
                $imagick->setIteratorIndex($index - 1);
                $imagick->setImageFormat('jpg');

                if ($imagick->getImageAlphaChannel()) {
                    $canvas = new \Imagick();
                    $canvas->newImage(
                        $imagick->getImageWidth(),
                        $imagick->getImageHeight(),
                        new \ImagickPixel('white')
                    );
                    $canvas->compositeImage($imagick, \Imagick::COMPOSITE_OVER, 0, 0);
                    $canvas->setImageFormat('jpg');
                    $imageData = $canvas->getImageBlob();
                    $canvas->clear();
                    $canvas->destroy();
                } else {
                    $imageData = $imagick->getImageBlob();
                }

                $imagePath = $imageDir . '/page_' . $index . '.jpg';
                file_put_contents($imagePath, $imageData);
                $imagePaths[] = $imagePath;
            }

            $imagick->clear();
            $imagick->destroy();

            // Build new PDF from selected image pages
            $pdf = new \setasign\Fpdi\Fpdi();

            foreach ($imagePaths as $imgPath) {
                $size = getimagesize($imgPath);
                $widthPx = $size[0];
                $heightPx = $size[1];

                $widthMm = ($widthPx / $dpi) * 25.4;
                $heightMm = ($heightPx / $dpi) * 25.4;
                $orientation = $widthMm > $heightMm ? 'L' : 'P';

                $pdf->AddPage($orientation, [$widthMm, $heightMm]);
                $pdf->Image($imgPath, 0, 0, $widthMm, $heightMm);
            }

            // Save final split PDF
            $fileName = $sanitizedName . '_split.pdf';
            $outputPath = $outputDir . '/' . $fileName;
            $pdf->Output('F', $outputPath);

            // Cleanup images
            array_map('unlink', glob("$imageDir/*"));

            // Record in DB
            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);
                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $originalName,
                    'input_file' => $storedInputPath,
                    'operation' => 'Split Pdf',
                    'output_file_name' => $fileName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            return redirect()->route('success_split_pdf')->with([
                'success' => "PDF split completed. Pages extracted: {$pageRange} (Total: " . count($pagesToExtract) . " pages).",
                'downloadLink' => asset('split_pdfs/' . $fileName),
                'download_name' => $fileName,
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'PDF split failed. Error: ' . $e->getMessage());
        }
    }


    public function success_split_pdf()
    {
        return view('pdf_functions_without_login.Split_pdf.success_split_pdf');
    }

}
