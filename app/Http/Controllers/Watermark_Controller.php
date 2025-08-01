<?php

namespace App\Http\Controllers;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Output\Destination;
use Mpdf\Watermark;
use setasign\Fpdi\PdfReader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Watermark_Controller extends Controller
{

    public function watermark_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Watermark.watermark');
    }

    public function watermark_pdf(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'required|mimes:pdf|max:20480',
            'watermark_position' => 'required|in:top-left,top-center,top-right,middle-left,middle-center,middle-right,bottom-left,bottom-center,bottom-right',
            'image_transparency' => 'required|in:low,medium,high,full',
        ], [
            'watermark_position.in' => 'Invalid watermark position selected.',
            'image_transparency.in' => 'Invalid transparency level selected.',
        ]);

        // Handle uploaded PDF
        $pdfFile = $request->file('pdf');
        $pdfOriginalName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
        $pdfExtension = $pdfFile->getClientOriginalExtension();
        $pdfUniqueName = uniqid() . '_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $pdfOriginalName) . '.' . $pdfExtension;

        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $pdfFile->move($uploadPath, $pdfUniqueName);
        $storedPdfPath = 'uploads/' . $pdfUniqueName;
        $fullPdfPath = public_path($storedPdfPath);

        // Handle uploaded image
        $imageFile = $request->file('image_file');
        $imageOriginalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $imageExtension = $imageFile->getClientOriginalExtension();
        $imageUniqueName = uniqid() . '_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $imageOriginalName) . '.' . $imageExtension;

        $imageFile->move($uploadPath, $imageUniqueName);
        $storedImagePath = 'uploads/' . $imageUniqueName;
        $fullImagePath = public_path($storedImagePath);

        $position = $request->input('watermark_position', 'middle-center');
        $transparencyLevel = $request->input('image_transparency', 'medium');

        // Transparency mapping
        $transparencyMap = [
            'low' => 0.4,
            'medium' => 0.6,
            'high' => 0.8,
            'full' => 1.0
        ];
        $transparency = $transparencyMap[$transparencyLevel] ?? 0.6;

        // Position mapping (in mm)
        $positionMap = [
            'top-left' => [20, 20],
            'top-center' => [85, 20],
            'top-right' => [140, 20],
            'middle-left' => [20, 108],
            'middle-center' => [85, 108],
            'middle-right' => [140, 108],
            'bottom-left' => [20, 220],
            'bottom-center' => [85, 220],
            'bottom-right' => [140, 220],
        ];

        $positionCoords = $positionMap[$position] ?? [85, 108];

        try {
            $mpdf = new \Mpdf\Mpdf([
                'margin_left'   => 20,
                'margin_right'  => 20,
                'margin_top'    => 30,
                'margin_bottom' => 20,
            ]);

            // Apply watermark
            $mpdf->SetWatermarkImage($fullImagePath, $transparency, [50, 50], $positionCoords);
            $mpdf->showWatermarkImage = true;

            $pageCount = $mpdf->SetSourceFile($fullPdfPath);
            for ($i = 1; $i <= $pageCount; $i++) {
                $mpdf->AddPage();
                $templateId = $mpdf->ImportPage($i);
                $mpdf->UseTemplate($templateId);
            }

            // Save watermarked PDF
            $outputFileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $pdfOriginalName) . '_watermarked.pdf';
            $outputPath = public_path('output/' . $outputFileName);

            if (!file_exists(public_path('output'))) {
                mkdir(public_path('output'), 0755, true);
            }

            $mpdf->Output($outputPath, 'F');

            // Save to DB if user is logged in
            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);

                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $pdfOriginalName,
                    'input_file' => $storedPdfPath,
                    'operation' => 'Watermark Pdf (Image)',
                    'output_file_name' => $outputFileName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            return redirect()->route('success_watermark_pdf')->with([
                'success' => 'Watermark added successfully.',
                'download_url' => asset('output/' . $outputFileName),
                'download_name' => $outputFileName,
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success_watermark_pdf()
    {
        return view('pdf_functions_without_login.Watermark.success_watermark');
    }

    public function watermark_text_LandPage()
    {
        return view('pdf_functions_without_login.Watermark.watermark_text');
    }

    public function watermark_text(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:20480',
            'watermark_text' => 'required|string|max:255',
            'font_family' => 'required|string',
            'font_size' => 'required|integer|min:8|max:100',
            'text_color' => 'required|string',
            'watermark_position' => 'required|in:top-left,top-center,top-right,middle-left,middle-center,middle-right,bottom-left,bottom-center,bottom-right',
            'image_transparency' => 'required|in:low,medium,high,full',
        ]);

        $pdf = $request->file('pdf');
        $originalName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $pdf->getClientOriginalExtension();

        // Sanitize and store uploaded file in public/uploads
        $uniqueId = uniqid();
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $storedFileName = $uniqueId . '_' . $sanitizedName . '.' . $extension;

        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $pdf->move($uploadPath, $storedFileName);
        $storedPdfPath = 'uploads/' . $storedFileName;
        $fullPdfPath = public_path($storedPdfPath);

        // Transparency alpha mapping
        $alphaMap = [
            'low' => 0.3,
            'medium' => 0.5,
            'high' => 0.7,
            'full' => 1.0,
        ];
        $alpha = $alphaMap[$request->input('image_transparency')] ?? 0.5;

        // Position mapping
        $positionMap = [
            'top-left' => [20, 20],
            'top-center' => [105, 20],
            'top-right' => [190, 20],
            'middle-left' => [20, 148],
            'middle-center' => [105, 148],
            'middle-right' => [190, 148],
            'bottom-left' => [20, 275],
            'bottom-center' => [105, 275],
            'bottom-right' => [190, 275],
        ];
        [$x, $y] = $positionMap[$request->input('watermark_position')] ?? [105, 148];

        // Watermark text styles
        $text = $request->input('watermark_text');
        $fontFamily = $request->input('font_family', 'Arial');
        $fontSize = (int)$request->input('font_size', 24);
        $textColor = $request->input('text_color', '#000000');
        $isBold = $request->has('bold');
        $isItalic = $request->has('italic');
        $isUnderline = $request->has('underline');

        $style = "font-family: {$fontFamily}; font-size: {$fontSize}pt; color: {$textColor};";
        if ($isBold) $style .= " font-weight: bold;";
        if ($isItalic) $style .= " font-style: italic;";

        $html = '<span style="' . $style . '">';
        $html .= $isUnderline ? '<u>' . htmlspecialchars($text) . '</u>' : htmlspecialchars($text);
        $html .= '</span>';

        try {
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
            ]);

            $pageCount = $mpdf->SetSourceFile($fullPdfPath);

            for ($i = 1; $i <= $pageCount; $i++) {
                $tplId = $mpdf->ImportPage($i);
                $mpdf->UseTemplate($tplId);

                $mpdf->SetAlpha($alpha);
                $mpdf->WriteFixedPosHTML($html, $x, $y, 100, 15, 'auto');
                $mpdf->SetAlpha(1);

                if ($i < $pageCount) {
                    $mpdf->AddPage();
                }
            }

            $outputFolder = public_path('output');
            if (!file_exists($outputFolder)) {
                mkdir($outputFolder, 0755, true);
            }

            $outputFileName = $sanitizedName . '_watermarked.pdf';
            $outputPath = $outputFolder . '/' . $outputFileName;

            $mpdf->Output($outputPath, 'F');

            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);
                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $originalName,
                    'input_file' => $storedPdfPath,
                    'operation' => 'Watermark Pdf',
                    'output_file_name' => $outputFileName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            return redirect()->route('success_watermark_pdf')->with([
                'success' => 'PDF watermarked successfully.',
                'download_url' => asset('output/' . $outputFileName),
                'download_name' => $outputFileName,
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'success' => false,
                'message' => 'Error generating PDF: ' . $e->getMessage(),
            ]);
        }
    }


}

    

