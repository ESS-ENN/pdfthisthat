<?php

namespace App\Http\Controllers;
use Imagick;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Compress_PDF_Controller extends Controller
{

    public function compress_pdf_LandPage()
    {
        return view('pdf_functions_without_login.Compress_pdf.compress_pdf');
    }

    public function compress_pdf(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:20480', // Max 20MB
            'compression_level' => 'required|in:low,medium,high',
        ]);

        // Directories
        $uploadDir = public_path('uploads');
        $outputDir = public_path('output_generated');

        foreach ([$uploadDir, $outputDir] as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0775, true);
            }
        }

        // Input File Setup
        $file = $request->file('pdf_file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $uniqueName = uniqid() . '_' . $sanitizedName . '.' . $extension;

        // Move uploaded file
        $storedInputPath = 'uploads/' . $uniqueName;
        $inputFullPath = $uploadDir . '/' . $uniqueName;
        $file->move($uploadDir, $uniqueName);

        $originalSize = filesize($inputFullPath);

        // Output File Setup
        $outputFilename = $sanitizedName . '_compressed.pdf';
        $outputFullPath = "{$outputDir}/{$outputFilename}";
        $downloadLink = asset("output_generated/{$outputFilename}");

        // Ghostscript path
        $gsPath = PHP_OS_FAMILY === 'Windows'
            ? '"' . public_path('ghostscript/gswin64c.exe') . '"'
            : 'gs';

        // Compression Profiles
        $compressionProfiles = [
            'low' => [
                'PDFSETTINGS' => '/printer',
                'ColorResolution' => 300,
                'GrayResolution' => 300,
                'MonoResolution' => 300,
                'ImageFilter' => '/FlateEncode',
            ],
            'medium' => [
                'PDFSETTINGS' => '/ebook',
                'ColorResolution' => 150,
                'GrayResolution' => 150,
                'MonoResolution' => 150,
                'ImageFilter' => '/DCTEncode',
            ],
            'high' => [
                'PDFSETTINGS' => '/screen',
                'ColorResolution' => 72,
                'GrayResolution' => 72,
                'MonoResolution' => 72,
                'ImageFilter' => '/DCTEncode',
            ],
        ];

        $profile = $compressionProfiles[$request->input('compression_level')];

        // Ghostscript command
        $command = implode(' ', [
            $gsPath,
            '-sDEVICE=pdfwrite',
            '-dCompatibilityLevel=1.4',
            "-dPDFSETTINGS={$profile['PDFSETTINGS']}",
            "-dColorImageResolution={$profile['ColorResolution']}",
            "-dGrayImageResolution={$profile['GrayResolution']}",
            "-dMonoImageResolution={$profile['MonoResolution']}",
            "-dColorImageFilter={$profile['ImageFilter']}",
            "-dGrayImageFilter={$profile['ImageFilter']}",
            '-dDownsampleColorImages=true',
            '-dDownsampleGrayImages=true',
            '-dDownsampleMonoImages=true',
            '-dAutoFilterColorImages=false',
            '-dAutoFilterGrayImages=false',
            '-dEmbedAllFonts=true',
            '-dSubsetFonts=true',
            '-dConvertCMYKImagesToRGB=true',
            '-dNOPAUSE',
            '-dQUIET',
            '-dBATCH',
            '-sOutputFile=' . escapeshellarg($outputFullPath),
            escapeshellarg($inputFullPath),
        ]);

        exec($command, $output, $returnCode);

        // File size formatting
        $formatBytes = function ($bytes, $precision = 2) {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes, 1024) : 0));
            $pow = min($pow, count($units) - 1);
            $bytes /= pow(1024, $pow);
            return round($bytes, $precision) . ' ' . $units[$pow];
        };

        if ($returnCode === 0 && file_exists($outputFullPath)) {
            $compressedSize = filesize($outputFullPath);
            $reduction = round((($originalSize - $compressedSize) / $originalSize) * 100, 2);

            if (Auth::check()) {
                $pdfBinary = file_get_contents($outputFullPath);

                DB::table('files')->insert([
                    'user_id' => Auth::id(),
                    'original_file_name' => $file->getClientOriginalName(),
                    'input_file' => $storedInputPath,
                    'operation' => 'Compress Pdf',
                    'output_file_name' => $outputFilename,
                    'file' => base64_encode($pdfBinary),
                    'date' => now(),
                    'status' => 'success',
                ]);
            }

            return redirect()->route('success_compress_pdf')->with([
                'success' => 'Compression successful!',
                'original_size' => $formatBytes($originalSize),
                'compressed_size' => $formatBytes($compressedSize),
                'reduction' => $reduction . '%',
                'downloadLink' => $downloadLink,
                'download_name' => $outputFilename,
            ]);
        }

        return back()->with('error', 'Compression failed. ' . implode("\n", $output));
    }
    
    public function success_compress_pdf()
    {
        return view('pdf_functions_without_login.Compress_pdf.success_compress_pdf');
    }
}
