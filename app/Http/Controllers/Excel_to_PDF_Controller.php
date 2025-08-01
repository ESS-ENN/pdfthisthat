<?php

namespace App\Http\Controllers;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Excel_to_PDF_Controller extends Controller
{
    public function excel_to_pdf_LandPage()
    {
         return view('pdf_functions_without_login.Excel_to_pdf.excel_to_pdf');
    }

    public function excel_to_pdf(Request $request)
    {
        $request->validate([
            'excel' => 'required|file|mimes:xlsx,xls,csv,ods|max:10240'
        ]);

        try {
            $file = $request->file('excel');
            $extension = strtolower($file->getClientOriginalExtension());
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

            // ✨ Generate file name: uniqueid_originalfilename.extension
            $uniqueId = uniqid();
            $uniqueName = $uniqueId . '_' . $sanitizedName . '.' . $extension;

            // Setup folders
            $uploadDir = public_path('uploads');
            $outputDir = public_path('excel_converted');

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0775, true);
            }

            // Move uploaded file to public/uploads
            $storedInputPath = 'uploads/' . $uniqueName;
            $fullInputPath = $uploadDir . '/' . $uniqueName;
            $file->move($uploadDir, $uniqueName);

            // Load spreadsheet
            try {
                $reader = match ($extension) {
                    'xlsx' => IOFactory::createReader('Xlsx'),
                    'xls' => IOFactory::createReader('Xls'),
                    'csv' => IOFactory::createReader('Csv'),
                    'ods' => IOFactory::createReader('Ods'),
                    default => throw new \Exception('Unsupported file type.')
                };
                $spreadsheet = $reader->load($fullInputPath);
            } catch (\Exception $e) {
                $spreadsheet = IOFactory::load($fullInputPath);
            }

            // Prepare mPDF
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_top' => 15,
                'margin_right' => 15,
                'margin_bottom' => 15,
                'margin_left' => 15
            ]);

            $mpdf->WriteHTML('
                <style>
                    table {border-collapse: collapse; width: 100%; margin-bottom: 20px;} 
                    td, th {border: 1px solid #ddd; padding: 8px;}
                    .sheet-container {page-break-after: always;}
                    .last-sheet {page-break-after: auto;}
                </style>
            ');

            $sheets = $spreadsheet->getAllSheets();
            $sheetCount = count($sheets);

            foreach ($sheets as $index => $sheet) {
                $html = '<div class="' . ($index < $sheetCount - 1 ? 'sheet-container' : 'last-sheet') . '">';
                $html .= '<h3 style="text-align:center;">' . htmlspecialchars($sheet->getTitle()) . '</h3>';
                $html .= '<table><tbody>';

                $hasData = false;
                foreach ($sheet->getRowIterator() as $row) {
                    $rowHtml = '';
                    $rowHasData = false;
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    foreach ($cellIterator as $cell) {
                        $value = $cell->getFormattedValue();
                        if (!empty(trim($value))) {
                            $rowHasData = true;
                        }
                        $rowHtml .= '<td>' . htmlspecialchars($value) . '</td>';
                    }

                    if ($rowHasData) {
                        $html .= '<tr>' . $rowHtml . '</tr>';
                        $hasData = true;
                    }
                }

                $html .= '</tbody></table></div>';

                if ($hasData) {
                    $mpdf->WriteHTML($html);
                }
            }

            // Output PDF
            $outputName = $sanitizedName . '_converted_from_excel.pdf';
            $outputPath = $outputDir . '/' . $outputName;
            $mpdf->Output($outputPath, \Mpdf\Output\Destination::FILE);

            
            // Save to DB
            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputPath);
                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $file->getClientOriginalName(),
                    'input_file' => $storedInputPath,
                    'operation' => 'Excel to Pdf',
                    'output_file_name' => $outputName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            return redirect()->route('success_excel_to_pdf')->with([
                'success' => 'Conversion successful!',
                'download_url' => asset('excel_converted/' . $outputName),
                'download_name' => $outputName,
            ]);

        } catch (\Exception $e) {
            \Log::error('Excel to PDF Conversion Failed: ' . $e->getMessage());

            if (isset($fullInputPath) && file_exists($fullInputPath)) {
                unlink($fullInputPath);
            }

            return back()->with('error', 'Conversion failed: ' . $e->getMessage());
        }
    }

    public function Success_excel_to_pdf()
    {
        return view('pdf_functions_without_login.Excel_to_pdf.success_excel_to_pdf');
    }

}
