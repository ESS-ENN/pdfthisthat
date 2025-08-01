@extends('layouts.app')

@section('content')

<main class="flex-grow bg-gray-50 dark:bg-gray-900 py-4 px-2 sm:px-4 lg:px-6">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mt-6">
            <div class="flex justify-center text-primary-500 text-4xl mb-2">
                <i class="bi bi-droplet"></i>
            </div>
            <h4 class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">Watermark to PDF</h1>
            <p class="text-base text-gray-600 dark:text-gray-300">
                Embed the watermark in your pdf document.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mt-6 p-12">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-4 rounded-lg shadow-sm m-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                        <a href="{{ session('download_url') }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-800/50 hover:bg-green-200 dark:hover:bg-green-700 rounded-full text-sm font-medium transition-colors"  download="{{ session('download_name') }}">
                            Download PDF
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            <div class="flex justify-center">
                    <a href="/watermark_pdf"  class="inline-flex items-center justify-center bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-md text-sm font-semibold transition shadow-md hover:shadow-lg
                    transform hover:-translate-y-0.5 active:translate-y-0 active:scale-95
                    ring-2 ring-transparent hover:ring-primary-300 focus:outline-none focus:ring-primary-400
                    focus:ring-offset-2 focus:ring-offset-white">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Add watermark to more PDFs 
                    </a>
            </div>
           
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
    // Handle PDF file input and preview
        document.getElementById('pdf_file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const pdfData = new Uint8Array(e.target.result);
                    pdfjsLib.getDocument(pdfData).promise.then(function(pdf) {
                        const numPages = pdf.numPages;
                        document.getElementById('pdf_preview').classList.remove('hidden');
                        document.getElementById('pdf_preview_container').innerHTML = '';

                        // Render each page for preview
                        for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                            pdf.getPage(pageNum).then(function(page) {
                                const scale = 0.5;  // Adjust scale if necessary
                                const viewport = page.getViewport({ scale: scale });

                                // Fixed width and height for 4cm (151px by 151px)
                                const maxWidth = 151;  // 4 cm in pixels
                                const maxHeight = 151; // 4 cm in pixels

                                // Create a canvas element to draw the PDF page
                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');

                                // Set canvas dimensions to 4cm by 4cm
                                canvas.width = maxWidth;
                                canvas.height = maxHeight;

                                // Calculate scale factor to fit content inside the 4cm by 4cm box
                                const scaleFactor = Math.min(maxWidth / viewport.width, maxHeight / viewport.height);

                                // Scale the PDF content to fit the box
                                const scaledWidth = viewport.width * scaleFactor;
                                const scaledHeight = viewport.height * scaleFactor;

                                // Clear canvas before rendering
                                context.clearRect(0, 0, canvas.width, canvas.height);

                                // Render the page onto the canvas at the scaled size
                                page.render({
                                    canvasContext: context,
                                    viewport: page.getViewport({ scale: scaleFactor })
                                }).promise.then(function() {
                                    const pageContainer = document.createElement('div');
                                    pageContainer.classList.add('flex', 'justify-center', 'items-center', 'border', 'p-2');
                                    pageContainer.appendChild(canvas);
                                    document.getElementById('pdf_preview_container').appendChild(pageContainer);
                                });
                            });
                        }
                    });
                };
                reader.readAsArrayBuffer(file);
            } else {
                alert('Please select a valid PDF file.');
            }
        });
</script>

@endsection