@extends('pdf_functions_after_login.dashboard_layout')

@section('content')

    <section id="" class="max-w-7xl mx-auto px-4 sm:px-6 py-6 mb-14">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4 dark:text-white"> Tools</h2>
            <p class="text-black-500 dark:text-gray-400 max-w-2xl mx-auto text-xl">PDFThisThat toolkit. Merge, split, compress, convert, and more — free, fast, and hassle-free.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- PDF Tools Group -->
            <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Tool Block -->
                    <a href="{{ route('guest_merge_pdf')}}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-filetype-pdf"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Merge PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Combine multiple PDF documents into one unified pdf.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_protect_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-lock"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Protect PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload a PDF file and set a password to encrypt it securely.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_redact_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-card-heading"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Redact PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Redact sensitive PDF informations or data, and keep your content safe.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_pdf_to_jpg') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-filetype-jpg"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">PDF to JPG</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload a PDF to convert each page into a high-quality image.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_jpg_to_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">JPG to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">CCombine single or multiple images into a single PDF document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="/excel_to_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-excel"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Excel to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Convert an Excel spreadsheet to a PDF file.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="/page_numbers" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-123"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Page Numbers</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Add page numbers to the PDF document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('organize_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-layout-text-sidebar-reverse"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Organize PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Rearrange or remove pages from your PDF.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>              

                    <a href="/split_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-pdf"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Split PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Extract specific pages from your PDF document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="/remove_page" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-trash3"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Remove Pages</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Remove not required page while preserving rest of the pdf.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('rotate_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-arrow-clockwise"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Rotate PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload a PDF and choose the direction to rotate its pages.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                     <a href="{{ route('word_to_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-word"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Word to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Convert your DOCX file into a downloadable PDF.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('compress_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-arrows-angle-contract"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Compress PDFs</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Minimize file size while maintaining the highest PDF quality.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>    

                    <a href="{{ route('guest_sign_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-pencil-square"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Sign PDFs</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Add your signature to the document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>  

                    <a href="/edit_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-brush"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Edit PDFs</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload your PDF to start editing with various tools.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                     <a href="{{ route('watermark_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-droplet"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Watermark</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Embed the watermark in your pdf document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('html_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-filetype-html"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">HTML to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Paste HTML or provide a URL to generate a downloadable PDF.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                     <a href="/unlock_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-unlock"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Unlock PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload a password-protected PDF, enter the password, and decrypt the file for download.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_ocr_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-book"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">OCR PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Recognize text in scanned documents and images.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="/compare_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-layout-split"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Compare PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload two PDFs to check differences side by side.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_crop_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-crop"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Crop PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Crop and adjust your PDF document dimensions.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                </div>
            </div>
    
    </section>

@endsection
