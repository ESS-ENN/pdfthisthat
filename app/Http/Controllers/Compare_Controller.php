<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Mpdf\Mpdf;
use Imagick;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use ZipArchive;

class Compare_Controller extends Controller
{
    
    public function Compare_LandPage()
    {
         return view('pdf_functions_without_login.Compare.compare_pdf');
    }

    public function Compare_download(Request $request)
    {
        $request->validate([
            'pdf1' => 'required|file|mimes:pdf',
            'pdf2' => 'required|file|mimes:pdf',
        ]);

        // Define uploads folder path
        $uploadPath = public_path('uploads');

        // Create directory if it doesn't exist
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Store uploaded PDFs in public/uploads
        $pdf1 = $request->file('pdf1');
        $pdf2 = $request->file('pdf2');

        $pdf1Name = time() . '_' . $pdf1->getClientOriginalName();
        $pdf2Name = time() . '_' . $pdf2->getClientOriginalName();

        $pdf1Path = $pdf1->move($uploadPath, $pdf1Name);
        $pdf2Path = $pdf2->move($uploadPath, $pdf2Name);

        // Create a ZIP of both PDFs
        $zipFileName = 'compare_' . time() . '.zip';
        $zipFilePath = $uploadPath . '/' . $zipFileName;

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($pdf1Path, $pdf1Name);
            $zip->addFile($pdf2Path, $pdf2Name);
            $zip->close();
        }

        // Extract text from PDFs
        $parser = new \Smalot\PdfParser\Parser();

        $pdf1Text = $parser->parseFile($pdf1Path)->getText();
        $pdf2Text = $parser->parseFile($pdf2Path)->getText();

        $lines1 = preg_split('/\r\n|\r|\n/', $pdf1Text);
        $lines2 = preg_split('/\r\n|\r|\n/', $pdf2Text);
        $maxLines = max(count($lines1), count($lines2));

        $pdf1HtmlLines = [];
        $pdf2HtmlLines = [];

        for ($i = 0; $i < $maxLines; $i++) {
            $line1 = $lines1[$i] ?? '';
            $line2 = $lines2[$i] ?? '';

            if ($line1 === '' && $line2 !== '') {
                $pdf1HtmlLines[] = "<div style='color:red;'>&nbsp;</div>";
                $pdf2HtmlLines[] = "<div style='color:green;'>" . htmlentities($line2) . "</div>";
            } elseif ($line2 === '' && $line1 !== '') {
                $pdf1HtmlLines[] = "<div style='color:red;'>" . htmlentities($line1) . "</div>";
                $pdf2HtmlLines[] = "<div style='color:green;'>&nbsp;</div>";
            } elseif ($line1 !== $line2) {
                $pdf1HtmlLines[] = "<div style='color:red;'>" . htmlentities($line1) . "</div>";
                $pdf2HtmlLines[] = "<div style='color:green;'>" . htmlentities($line2) . "</div>";
            } else {
                $safeText = htmlentities($line1);
                $pdf1HtmlLines[] = "<div style='color:black;'>$safeText</div>";
                $pdf2HtmlLines[] = "<div style='color:black;'>$safeText</div>";
            }
        }

        // Save metadata in database
        if (Auth::check()) {
           $pdfBinary = file_get_contents($zipFilePath);
            DB::table('files')->insert([
                'user_id' => Auth::id(),
                'original_file_name' => $pdf1->getClientOriginalName() . ' & ' . $pdf2->getClientOriginalName(),
                'operation' => 'Compare Pdf',
                'output_file_name' => basename($zipFileName),
                'input_file' => 'uploads/' . $zipFileName,
                'date' => now(),
                'file' => base64_encode($pdfBinary),
                'status' => 'success',
            ]);
        }

        return redirect()->route('success_compare_pdf')->with([
            'success' => 'Comparison successful!',
            'pdf1_compare' => implode('', $pdf1HtmlLines),
            'pdf2_compare' => implode('', $pdf2HtmlLines),
            'pdf1_url' => asset('uploads/' . $pdf1Name),
            'pdf2_url' => asset('uploads/' . $pdf2Name),
            'pdf1_name' => $pdf1Name,
            'pdf2_name' => $pdf2Name,
        ]);
    }

    private function convertPdfToImages($pdfPath): array
    {
        $imagick = new Imagick();
        $imagick->setResolution(150, 150);
        $imagick->readImage($pdfPath);
        $imagick->setImageFormat("png");

        $images = [];
        foreach ($imagick as $i => $page) {
            $cloned = clone $page;
            $images[] = $cloned;
        }

        return $images;
    }

    private function highlightDifferences(Imagick $img1, Imagick $img2): Imagick
    {
        $img1 = clone $img1;
        $img2 = clone $img2;

        // Resize for matching dimensions
        $img2->resizeImage($img1->getImageWidth(), $img1->getImageHeight(), Imagick::FILTER_LANCZOS, 1);

        // Compare images
       $result = $img1->compareImages($img2, Imagick::METRIC_MEANABSOLUTEERROR);


        $diffImage = $result[0];

        // Enhance differences by converting to red hue
        $diffImage->modulateImage(100, 100, 0); // 0 hue -> red

        // Composite diff on original
        $img1->compositeImage($diffImage, Imagick::COMPOSITE_ATOP, 0, 0);

        return $img1;
    }

    public function success_Compare_pdf()
    {
        return view('pdf_functions_without_login.Compare.success_compare_pdf');
    }  

}
