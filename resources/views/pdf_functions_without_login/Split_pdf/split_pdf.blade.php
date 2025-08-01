@extends('layouts.app')

@section('content')

<main class="h-full bg-gray-50 dark:bg-gray-900 py-4 px-2 sm:px-4 lg:px-6">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-4 mt-0">
            <div class="flex justify-center text-primary-500 text-4xl mb-2">
                <i class="bi bi-scissors"></i>
            </div>
            <h4 class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">Split PDF File</h1>
            <p class="text-base text-gray-600 dark:text-gray-300">
                Extract specific pages from your PDF document
            </p>
        </div>

        {{-- Split Form --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-2">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-3 rounded-lg shadow-sm m-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('success') }}
                        </div>
                        <a href="{{ session('downloadLink') }}" target="_blank" class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-800/50 hover:bg-green-200 dark:hover:bg-green-700 rounded-full text-sm font-medium transition-colors">
                            Download PDF
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            @elseif (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-3 rounded-lg shadow-sm m-4">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="/split_pdf" method="POST" enctype="multipart/form-data" class="space-y-6 p-5 sm:p-6" onsubmit="handleSubmit()">
                @csrf

                {{-- File Upload --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload PDF File</label>
                    <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                        <input 
                            type="file" 
                            name="pdf_file" 
                            id="pdf_file" 
                            accept="application/pdf" 
                            required 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                                <p>or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF file only (max 20MB)</p>
                            <p id="file-name" class="text-sm text-primary-500 mt-1 hidden"></p>
                        </div>
                    </div>
                </div>

                <!-- Preview PDF  -->
                <div id="pdf-preview-container" class="mt-4 hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">PDF Preview</label>
                    <div class="border rounded-lg overflow-hidden">
                        <iframe id="pdf-preview" class="w-full h-96" type="application/pdf"></iframe>
                    </div>
                </div>

                {{-- Page Range Input --}}
                <div class="space-y-1">
                    <label for="page_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Page range</label>
                    <input 
                        type="text" 
                        name="page_range" 
                        id="page_range" 
                        placeholder="e.g. 1,3,5-7" 
                        required 
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                    <p class="text-xs text-gray-500 dark:text-gray-400">Separate pages by commas. Use hyphens for ranges.</p>
                </div>

                <button 
                    type="submit" 
                    name="split" 
                    id="splitBtn"
                    class="w-full flex items-center justify-center p-2 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300 text-sm">
                    </svg>
                    Split PDF Now
                </button>
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

<script>

    function handleSubmit() {
        const btn = document.getElementById("splitBtn");
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

    document.getElementById('pdf_file').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('pdf-preview-container');
        const previewFrame = document.getElementById('pdf-preview');
        const fileNameDisplay = document.getElementById('file-name');

        if (file && file.type === "application/pdf") {
            const fileURL = URL.createObjectURL(file);
            previewFrame.src = fileURL;
            previewContainer.classList.remove('hidden');
            fileNameDisplay.textContent = file.name;
            fileNameDisplay.classList.remove('hidden');
        } else {
            previewFrame.src = "";
            previewContainer.classList.add('hidden');
            fileNameDisplay.classList.add('hidden');
            alert("Please upload a valid PDF file.");
        }
    });

</script>

@endsection