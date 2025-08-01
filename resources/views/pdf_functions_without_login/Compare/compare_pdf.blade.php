@extends('layouts.app')

@section('content')

<main class="h-full bg-gray-50 dark:bg-gray-900 py-4 px-2 sm:px-4 lg:px-6">
    <div class="max-w-4xl mx-auto">

        <div class="text-center mb-4 mt-0">
            <div class="flex justify-center text-primary-500 text-4xl mb-2">
                <i class="bi bi-layout-split"></i>
            </div>
            <h4 class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">Compare PDF</h1>
            <p class="text-base text-gray-600 dark:text-gray-300">
                Upload two PDFs to check differences side by side.
            </p>

        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-4 mt-4">

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-3 rounded-lg shadow-sm m-4 text-sm">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" enctype="multipart/form-data" class="space-y-6 p-5 sm:p-6" action="{{ route('compare_pdf_download') }}" onsubmit="handleSubmit()">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- PDF 1 Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">First PDF</label>
                        <div class="relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                            <input type="file" name="pdf1" accept=".pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="pdf1-upload">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <i class="bi bi-file-earmark-pdf text-primary-500 text-3xl"></i>
                                <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF file only</p>
                                <p id="file-name-1" class="text-sm text-primary-500 mt-2 hidden"></p>
                            </div>
                        </div>
                    </div>

                    <!-- PDF 2 Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Second PDF</label>
                        <div class="relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                            <input type="file" name="pdf2" accept=".pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="pdf2-upload">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <i class="bi bi-file-earmark-pdf text-primary-500 text-3xl"></i>
                                <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF file only</p>
                                <p id="file-name-2" class="text-sm text-primary-500 mt-2 hidden"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex items-center justify-center p-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300 text-sm" id="compareBtn">
                    Compare PDFs
                </button>

                <!-- PDF Previews -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 hidden">

                    <!-- First PDF Preview -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 transform hover:scale-[1.01]">
                        <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600 flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">First PDF Preview</h3>
                            <div class="flex items-center gap-2">
                                <label class="cursor-pointer text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    Upload
                                    <input type="file" accept="application/pdf" id="pdf1-upload" class="hidden">
                                </label>
                                <span id="file-name-1" class="text-xs text-gray-500 dark:text-gray-400 hidden"></span>
                            </div>
                        </div>
                        <div id="preview-pdf1" class="hidden p-4 h-96 overflow-hidden">
                            <iframe class="w-full h-full rounded border border-gray-300" id="iframe-pdf1"></iframe>
                        </div>
                        <div id="no-preview-1" class="flex flex-col items-center justify-center p-8 text-center h-96">
                            <i class="bi bi-file-earmark text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No PDF selected</p>
                            <p class="text-xs text-gray-400 mt-1">Preview will appear here</p>
                        </div>
                    </div>

                    <!-- Second PDF Preview -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 transform hover:scale-[1.01]">
                        <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600 flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Second PDF Preview</h3>
                            <div class="flex items-center gap-2">
                                <label class="cursor-pointer text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    Upload
                                    <input type="file" accept="application/pdf" id="pdf2-upload" class="hidden">
                                </label>
                                <span id="file-name-2" class="text-xs text-gray-500 dark:text-gray-400 hidden"></span>
                            </div>
                        </div>
                        <div id="preview-pdf2" class="hidden p-4 h-96 overflow-hidden">
                            <iframe class="w-full h-full rounded border border-gray-300" id="iframe-pdf2"></iframe>
                        </div>
                        <div id="no-preview-2" class="flex flex-col items-center justify-center p-8 text-center h-96">
                            <i class="bi bi-file-earmark text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No PDF selected</p>
                            <p class="text-xs text-gray-400 mt-1">Preview will appear here</p>
                        </div>
                    </div>

                </div>
                
            </form>
        </div>
    </div>
</main>

<!-- PDF Tools Group - Compact Version -->
<div class="max-w-7xl mx-auto px-2 sm:px-4 py-4 text-center">

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold mb-2 dark:text-white">Try Other Tools Also</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm max-w-xl mx-auto">
            Quickly access your favorite utilities with our comprehensive toolkit
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <!-- Tool Card -->
                <a href="/merge_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 overflow-hidden">
                    <div class="text-2xl mb-2 text-primary-500 group-hover:text-black">
                        <i class="bi bi-filetype-pdf"></i>
                    </div>
                    <h3 class="text-lg font-semibold group-hover:text-primary-500 dark:text-white">Merge PDF</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1 text-xs">Combine multiple PDFs into one document.</p>
                    <div class="mt-3 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                        Try now <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </a>

                <a href="/compress_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 overflow-hidden">
                    <div class="text-2xl mb-2 text-primary-500 group-hover:text-black">
                        <i class="bi bi-arrows-angle-contract"></i>
                    </div>
                    <h3 class="text-lg font-semibold group-hover:text-primary-500 dark:text-white">Compress PDFs</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1 text-xs">Minimize file size while maintaining the highest PDF quality.</p>
                    <div class="mt-3 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                        Try now <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </a>

                <a href="/pdf_to_jpg" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 overflow-hidden">
                    <div class="text-2xl mb-2 text-primary-500 group-hover:text-black">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </div>
                    <h3 class="text-lg font-semibold group-hover:text-primary-500 dark:text-white">PDF to JPG</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1 text-xs">Convert JPG images to PDF in seconds.</p>
                    <div class="mt-3 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                        Try now <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </a>

            </div>
        </div>
    </div>

    <!-- Centered Button -->
    <div class="flex justify-center mt-6 mb-6">
        <a href="{{ route('tools')}}" class="inline-flex items-center justify-center bg-primary-500 hover:bg-primary-600 text-white px-5 py-2.5 rounded-md text-xs font-medium transition shadow hover:shadow-md">
            Explore All Tools <i class="fas fa-arrow-right ml-2 text-xs"></i>
        </a>
    </div>
    
</div>


<!-- Add PDF.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script>
    // Configure PDF.js worker path
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';
</script>

<script>

    function handleSubmit() {
        const btn = document.getElementById("compareBtn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }

    document.addEventListener('DOMContentLoaded', function() {
        // For PDF 1
        const pdf1Input = document.querySelector('input[name="pdf1"]');
        const pdf1FileName = document.getElementById('file-name');
        
        pdf1Input.addEventListener('change', function(e) {
            if (this.files && this.files.length > 0) {
                pdf1FileName.textContent = this.files[0].name;
                pdf1FileName.classList.remove('hidden');
            }
        });

        // For PDF 2
        const pdf2Input = document.querySelector('input[name="pdf2"]');
        const pdf2FileName = document.getElementById('image-name'); // Note: This should probably be renamed to pdf2-name for consistency
        
        pdf2Input.addEventListener('change', function(e) {
            if (this.files && this.files.length > 0) {
                pdf2FileName.textContent = this.files[0].name;
                pdf2FileName.classList.remove('hidden');
            }
        });
    });

    document.getElementById('pdf2-upload').addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
        document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.gap-6.mt-8.hidden')?.classList.remove('hidden');
        }
    });

    function handlePDFPreview(uploadId, previewId, noPreviewId, fileNameId, iframeId) {
        const uploadElement = document.getElementById(uploadId);

        uploadElement.addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (file && file.type === 'application/pdf') {
                const fileNameElement = document.getElementById(fileNameId);
                const preview = document.getElementById(previewId);
                const noPreview = document.getElementById(noPreviewId);
                const iframe = document.getElementById(iframeId);

                // Show file name
                fileNameElement.textContent = file.name;
                fileNameElement.classList.remove('hidden');

                // Hide no-preview, show preview
                noPreview.classList.add('hidden');
                preview.classList.remove('hidden');

                // Create blob URL and load into iframe
                const fileURL = URL.createObjectURL(file);
                iframe.src = fileURL;

                // Optional: revoke object URL on iframe unload to free memory
                iframe.onload = () => URL.revokeObjectURL(fileURL);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        handlePDFPreview('pdf1-upload', 'preview-pdf1', 'no-preview-1', 'file-name-1', 'iframe-pdf1');
        handlePDFPreview('pdf2-upload', 'preview-pdf2', 'no-preview-2', 'file-name-2', 'iframe-pdf2');
    });

</script>

@endsection