<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/Google_Auth', [App\Http\Controllers\GoogleAuthController::class, 'GoogleAuth'])->name('Google_Auth');
Route::get('/Google_CallBack', [App\Http\Controllers\GoogleAuthController::class, 'Google_CallBack'])->name('Google_CallBack');

// GUEST USERS

Route::get('/tools', [App\Http\Controllers\guest_PDFController::class, 'tools_LandPage'])->name('tools');
Route::get('/history_page', [App\Http\Controllers\guest_PDFController::class, 'History_LandPage']);
Route::get('/download-file/{file_id}', [App\Http\Controllers\guest_PDFController::class, 'downloadFile'])->name('download.file');
Route::get('/file/download/{file_id}', [App\Http\Controllers\guest_PDFController::class, 'downloadInput'])->name('file.download');



Route::get('/merge_pdf', [App\Http\Controllers\Merge_PDF_Controller::class, 'Merge_PDF_LandPage'])->name('guest_merge_pdf');
Route::post('/merge_pdf', [App\Http\Controllers\Merge_PDF_Controller::class, 'Merge_PDF'])->name('guest_merge_pdf_functionality');
Route::get('/Success_merge_pdf', [App\Http\Controllers\Merge_PDF_Controller::class, 'Successful_Merge_PDF'])->name('success_merge_pdf');



Route::get('/protect_pdf', [App\Http\Controllers\Protect_PDFController::class, 'protect_pdf_LandPage'])->name('guest_protect_pdf');
Route::post('/protect_pdf', [App\Http\Controllers\Protect_PDFController::class, 'protect_pdf'])->name('guest_protect_pdf_functionality');
Route::get('/success_protect_pdf', [App\Http\Controllers\Protect_PDFController::class, 'Successful_protect_pdf'])->name('success_protect_pdf');



Route::get('/pdf_to_jpg', [App\Http\Controllers\PDF_to_JPG_Controller::class, 'pdf_to_jpg_LandPage'])->name('guest_pdf_to_jpg');
Route::post('/pdf_to_jpg', [App\Http\Controllers\PDF_to_JPG_Controller::class, 'pdf_to_jpg'])->name('guest_pdf_to_jpg_functionality');
Route::get('/success_pdf_to_jpg', [App\Http\Controllers\PDF_to_JPG_Controller::class, 'successful_protect_pdf'])->name('success_pdf_to_jpg');



Route::get('/jpg_to_pdf', [App\Http\Controllers\JPG_to_PDF_Controller::class, 'jpg_to_pdf_LandPage'])->name('guest_jpg_to_pdf');
Route::post('/jpg_to_pdf', [App\Http\Controllers\JPG_to_PDF_Controller::class, 'jpg_to_pdf'])->name('guest_jpg_to_pdf_functionality');
Route::get('/Success_jpg_to_pdf', [App\Http\Controllers\JPG_to_PDF_Controller::class, 'success_jpg_to_pdf'])->name('sucess_jpg_to_pdf');



Route::get('/excel_to_pdf', [App\Http\Controllers\Excel_to_PDF_Controller::class, 'excel_to_pdf_LandPage'])->name('excel_to_pdf');
Route::post('/excel_to_pdf', [App\Http\Controllers\Excel_to_PDF_Controller::class, 'excel_to_pdf'])->name('guest_excel_to_pdf_functionality');
Route::get('/success_excel_to_pdf', [App\Http\Controllers\Excel_to_PDF_Controller::class, 'Success_excel_to_pdf'])->name('success_excel_to_pdf');




Route::get('/redact_pdf', [App\Http\Controllers\Redact_PDF_Controller ::class, 'redact_pdf_LandPage'])->name('guest_redact_pdf');
Route::get('/success_redact_pdf', [App\Http\Controllers\Redact_PDF_Controller ::class, 'success_redact_pdf']);
Route::post('/store-redacted-pdf', [App\Http\Controllers\Redact_PDF_Controller::class, 'store'])->name('store.redacted.pdf');



Route::get('/page_numbers', [App\Http\Controllers\PageNo_PDF_Controller::class, 'page_numbers_LandPage'])->name('page_numbers');
Route::post('/page_numbers', [App\Http\Controllers\PageNo_PDF_Controller::class, 'page_numbers'])->name('page_numbers_functionality');
Route::get('/success_page_numbers', [App\Http\Controllers\PageNo_PDF_Controller::class, 'success_page_numbers'])->name('success_page_numbers');



Route::get('/compress_pdf', [App\Http\Controllers\Compress_PDF_Controller::class, 'compress_pdf_LandPage'])->name('compress_pdf');
Route::post('/compress_pdf', [App\Http\Controllers\Compress_PDF_Controller::class, 'compress_pdf'])->name('compress_pdf_functionality');
Route::get('/success_compress_pdf', [App\Http\Controllers\Compress_PDF_Controller::class, 'success_compress_pdf'])->name('success_compress_pdf');



Route::get('/organize_pdf', [App\Http\Controllers\Organize_PDF_Controller::class, 'organize_pdf_LandPage'])->name('organize_pdf');
Route::post('/organize_pdf', [App\Http\Controllers\Organize_PDF_Controller::class, 'organize_pdf'])->name('organize_pdf_functionality');
Route::get('/success_organize_pdf', [App\Http\Controllers\Organize_PDF_Controller::class, 'success_organize_pdf'])->name('success_organize_pdf');



Route::get('/split_pdf', [App\Http\Controllers\Split_PDF_Controller::class, 'split_pdf_LandPage'])->name('split_pdf');
Route::post('/split_pdf', [App\Http\Controllers\Split_PDF_Controller::class, 'split_pdf'])->name('split_pdf_functionality');
Route::get('/success_split_pdf', [App\Http\Controllers\Split_PDF_Controller::class, 'success_split_pdf'])->name('success_split_pdf');



Route::get('/unlock_pdf', [App\Http\Controllers\Unlock_PDF_Controller::class, 'unlock_pdf_LandPage'])->name('unlock_pdf');
Route::post('/unlock_pdf', [App\Http\Controllers\Unlock_PDF_Controller::class, 'unlock_pdf'])->name('unlock_pdf');
Route::get('/success_unlock_pdf', [App\Http\Controllers\Unlock_PDF_Controller::class, 'success_unlock_pdf'])->name('success_unlock_pdf');



Route::get('/word_to_pdf', [App\Http\Controllers\Word_PDF_Controller::class, 'word_to_pdf_LandPage'])->name('word_to_pdf');
Route::post('/word_to_pdf', [App\Http\Controllers\Word_PDF_Controller::class, 'word_to_pdf'])->name('word_to_pdf_functionality');
Route::get('/success_word_to_pdf', [App\Http\Controllers\Word_PDF_Controller::class, 'success_word_to_pdf'])->name('success_word_to_pdf');



Route::get('/remove_page', [App\Http\Controllers\RemovePage_Controller::class, 'remove_page_LandPage'])->name('remove_page');
Route::post('/remove_page', [App\Http\Controllers\RemovePage_Controller::class, 'remove_page'])->name('remove_page_functionality');
Route::get('/success_remove_page', [App\Http\Controllers\RemovePage_Controller::class, 'success_remove_page'])->name('success_remove_page');



Route::get('/watermark_pdf', [App\Http\Controllers\Watermark_Controller::class, 'watermark_pdf_LandPage'])->name('watermark_pdf');
Route::post('/watermark_pdf', [App\Http\Controllers\Watermark_Controller::class, 'watermark_pdf'])->name('watermark_pdf_functionality');
Route::get('/success_watermark_pdf', [App\Http\Controllers\Watermark_Controller::class, 'success_watermark_pdf'])->name('success_watermark_pdf');



Route::get('/watermark_text', [App\Http\Controllers\Watermark_Controller::class, 'watermark_text_LandPage']);
Route::post('/watermark_text', [App\Http\Controllers\Watermark_Controller::class, 'watermark_text'])->name('watermark_text');



Route::get('/ocr_pdf', [App\Http\Controllers\OCR_Controller::class, 'ocr_pdf_LandPage'])->name('guest_ocr_pdf');
Route::post('/ocr_pdf', [App\Http\Controllers\OCR_Controller::class, 'ocr_pdf'])->name('guest_ocr_pdf_functionality');
Route::get('/success_ocr_pdf', [App\Http\Controllers\OCR_Controller::class, 'success_ocr_pdf'])->name('success_ocr_pdf');



Route::get('/rotate_pdf', [App\Http\Controllers\Rotate_Controller::class, 'rotate_pdf_LandPage'])->name('rotate_pdf');
Route::post('/rotate_pdf', [App\Http\Controllers\Rotate_Controller::class, 'rotate_pdf'])->name('rotate_pdf_functionality');
Route::get('/success_rotate_pdf', [App\Http\Controllers\Rotate_Controller::class, 'success_rotate_pdf'])->name('success_rotate_pdf');



Route::get('/html_pdf', [App\Http\Controllers\Html_Controller::class, 'html_LandPage'])->name('html_pdf');
Route::post('/html_pdf', [App\Http\Controllers\Html_Controller::class, 'html_download'])->name('html_pdf_download');
Route::get('/success_html_pdf', [App\Http\Controllers\Html_Controller::class, 'success_html'])->name('success_html');


Route::get('/crop_pdf', [App\Http\Controllers\Crop_Controller::class, 'crop_pdf_LandPage'])->name('guest_crop_pdf');
// Route::post('/upload_cropped_pdf', [App\Http\Controllers\Crop_Controller::class, 'uploadCroppedPdf']);
// Route::get('/success_crop_pdf', [App\Http\Controllers\Crop_Controller::class, 'successPage']);
Route::post('/upload_cropped_pdf', [App\Http\Controllers\Crop_Controller::class, 'uploadCroppedPdf']);
Route::get('/success_crop_pdf', [App\Http\Controllers\Crop_Controller::class, 'successPage']);


Route::get('/sign_pdf', [App\Http\Controllers\Sign_PDF_Controller::class, 'sign_pdf_LandPage'])->name('guest_sign_pdf');
Route::get('/success_sign_pdf', [App\Http\Controllers\Sign_PDF_Controller::class, 'success_sign_pdf']);
Route::post('/store-signed-pdf', [App\Http\Controllers\Sign_PDF_Controller::class, 'storeSignedPdf']);


Route::get('/edit_pdf', [App\Http\Controllers\Edit_Controller::class, 'Edit_LandPage'])->name('edit_pdf');
Route::post('/pdf_editor', [App\Http\Controllers\Edit_Controller::class, 'pdf_Editor'])->name('pdf_editor');
Route::post('/pdf-editor', [App\Http\Controllers\Edit_Controller::class, 'generatePdf']);
Route::post('/upload_edited_pdf', [App\Http\Controllers\Edit_Controller::class, 'uploadEditedPdf']);
Route::get('/success_edit_pdf', [App\Http\Controllers\Edit_Controller::class, 'success_pdf_Editor']);


Route::get('/compare_pdf', [App\Http\Controllers\Compare_Controller::class, 'Compare_LandPage'])->name('compare_pdf');
Route::post('/compare_pdf', [App\Http\Controllers\Compare_Controller::class, 'Compare_download'])->name('compare_pdf_download');
Route::get('/success_compare_pdf', [App\Http\Controllers\Compare_Controller::class, 'success_Compare_pdf'])->name('sucess_compare_pdf');
Route::get('/compare/success', function () {
    $pdf1Html = session('pdf1_compare', '');
    $pdf2Html = session('pdf2_compare', '');
    
    if (!$pdf1Html || !$pdf2Html) {
        abort(404, 'No comparison data found.');
    }

    return view('pdf_functions_without_login.Compare.success_compare_pdf', compact('pdf1Html', 'pdf2Html'));
})->name('success_compare_pdf');



