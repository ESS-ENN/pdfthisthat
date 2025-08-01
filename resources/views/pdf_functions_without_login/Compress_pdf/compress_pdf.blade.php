@extends('layouts.app')

@section('content')

<section>
    <div class="text-center mb-4 mt-6">
        <div class="flex justify-center text-primary-500 text-4xl mb-2">
            <i class="bi bi-arrows-angle-contract"></i>
        </div>
        <h4 class="text-3xl font-extrabold text-primary-600 dark:text-primary-400 mb-2">Compress PDF File</h1>
        <p class="text-base text-gray-600 dark:text-gray-300">Minimize file size while maintaining high quality.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden max-w-3xl mx-auto mt-6 mb-6">
        <form action="{{ route('compress_pdf_functionality') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6 sm:p-8" onsubmit="handleSubmit()">
            @csrf

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-md shadow-sm mb-4">
                    <div class="flex items-center mb-1">
                        <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-semibold text-sm">Error</p>
                    </div>
                    <div class="text-xs ml-6">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload PDF File</label>
                <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                    <input 
                        type="file" 
                        name="pdf_file" 
                        id="pdf_file" 
                        accept=".pdf" 
                        required 
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="flex flex-col items-center justify-center space-y-2">
                        <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <div class="text-xs text-gray-600 dark:text-gray-400">
                            <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                            <p>or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF only (max ~20MB)</p>
                        <p id="file-name" class="text-sm text-primary-500 mt-1 hidden"></p>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label for="compression_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Compression Level</label>
                <select name="compression_level" id="compression_level"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="low">Low (Larger file)</option>
                    <option value="medium" selected>Medium (balanced)</option>
                    <option value="high">High (Smaller file)</option>
                </select>
            </div>

            <button type="submit" name="compress" id="compressBtn"
                class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-md text-sm transition duration-300">
                <i class="bi bi-arrows-angle-contract font-bold mr-2"></i>
                Compress PDF Now
            </button>
        </form>
    </div>
</section>

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

<script>

    function handleSubmit() {
        const btn = document.getElementById("compressBtn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }

    const pdfInput = document.getElementById('pdf_file');
    const fileNameDisplay = document.getElementById('file-name');

    pdfInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            fileNameDisplay.textContent = `Selected file: ${file.name}`;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameDisplay.textContent = '';
            fileNameDisplay.classList.add('hidden');
        }
    });

    document.getElementById('compressionForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('pdf_file');
            const maxSize = 5 * 1024 * 1024;

            if (fileInput.files.length > 0 && fileInput.files[0].size > maxSize) {
                alert('File size exceeds 5MB limit. Please choose a smaller file.');
                e.preventDefault();
            }
    });

</script>

@endsection