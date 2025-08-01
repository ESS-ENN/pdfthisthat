<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class guest_PDFController extends Controller
{

    public function tools_LandPage()
    {
        return view('pdf_functions_without_login.tools_page');
    }

    public function History_LandPage()
    {
        $files = File::where('user_id', Auth::id())
                    ->orderBy('date', 'desc')
                    ->get();

        return view('pdf_functions_after_login.history_page', compact('files'));
    }   
    
    public function downloadFile($file_id)
    {
        // Get the file record from the database
        $file = DB::table('files')->where('file_id', $file_id)->first();

        if (!$file || !$file->file) {
            abort(404, 'File not found');
        }

        // Decode the base64-encoded file
        $pdfBinary = base64_decode($file->file);

        // Generate a proper filename
        $filename = $file->output_file_name ?? $file->original_file_name ?? 'document.pdf';

        // Return the file as a response with headers
        return response($pdfBinary)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function downloadInput($file_id)
    {
        // Fetch file record
        $file = DB::table('files')->where('file_id', $file_id)->first();

        if (!$file || !$file->input_file) {
            abort(404, 'Input file not found');
        }

        // Extract and clean base64
        $base64 = $file->input_file;

        // Strip data URI prefix if present
        if (preg_match('/^data:.*?;base64,/', $base64, $matches)) {
            $base64 = substr($base64, strlen($matches[0]));
        }

        // Remove any whitespaces
        $base64 = preg_replace('/\s+/', '', $base64);

        // Decode base64
        $binary = base64_decode($base64, true);

        if ($binary === false) {
            abort(500, 'Failed to decode input file');
        }

        // Determine filename and mime type
        $filename = $file->input_file_name ?? $file->original_file_name ?? 'input_file';
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $mimeType = match ($extension) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };

        // Return as download response
        return response($binary)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Length', strlen($binary));
    }
    
    

}






