<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use HeadlessChromium\BrowserFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class Html_Controller extends Controller
{
   public function html_LandPage()
   {
     return view('pdf_functions_without_login.Html_pdf.html_pdf');
   }
    
    public function success_html()
    {
        return view('pdf_functions_without_login.Html_pdf.success_html_pdf');
    }



    public function html_download(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'html' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $url = $request->input('html');

        // Extract hostname from URL for filename
        $parsedUrl = parse_url($url);
        $host = isset($parsedUrl['host']) ? str_replace(['www.', '.'], '_', $parsedUrl['host']) : 'website';
        $timestamp = time();
        $outputFileName = "{$host}_{$timestamp}.pdf";

        $outputDirectory = public_path('output_generated');
        $inputDirectory = public_path('uploads');

        if (!file_exists($outputDirectory)) {
            mkdir($outputDirectory, 0755, true);
        }
        if (!file_exists($inputDirectory)) {
            mkdir($inputDirectory, 0755, true);
        }

        $pdfPath = $outputDirectory . '/' . $outputFileName;
        $inputHtmlPath = $inputDirectory . '/' . $host . "_{$timestamp}.txt";

        // Save input URL as a .txt file for reference
        file_put_contents($inputHtmlPath, $url);

        try {
            // Detect OS and set Chrome path
            $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
            $chromePath = $isWindows
                ? 'C:\Program Files\Google\Chrome\Application\chrome.exe'
                : '/usr/bin/google-chrome'; // Update if your Linux path differs

            $browserFactory = new BrowserFactory($chromePath);

            $browser = $browserFactory->createBrowser([
                'headless' => true,
                'noSandbox' => true,
                'customFlags' => [
                    '--disable-gpu',
                    '--no-sandbox',
                    '--disable-dev-shm-usage',
                    '--remote-debugging-port=9222',
                ]
            ]);

            $page = $browser->createPage();
            $page->navigate($url)->waitForNavigation();

            $pdf = $page->pdf([
                'printBackground' => true,
                'landscape' => true,
            ]);

            $pdf->saveToFile($pdfPath);

            $browser->close();

            // Save to DB if user is authenticated
            if (Auth::check()) {
                $pdfBinary = file_get_contents($pdfPath);

                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => basename($inputHtmlPath),
                    'input_file' => $url,
                    'operation' => 'HTML to Pdf',
                    'output_file_name' => $outputFileName,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            return redirect()->route('success_html')->with([
                'success' => 'PDF generated successfully.',
                'fileName' => asset('output_generated/' . $outputFileName),
                'download_name' => $outputFileName
            ]);

        } catch (\Exception $e) {
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
            return redirect()->back()->withErrors([
                'error' => 'Failed to generate PDF: ' . $e->getMessage(),
            ]);
        }
    }
  

}
