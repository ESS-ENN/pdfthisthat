@extends('layouts.app')

@section('content')

<main class="h-full bg-gray-50 dark:bg-gray-900 py-6 px-2 sm:px-4 lg:px-6">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-4">
            <div class="flex justify-center text-primary-500 text-4xl mb-2">
               <i class="bi bi-trash3"></i>
            </div>
            <h4 class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">Remove Pages</h1>
            <p class="text-base text-gray-600 dark:text-gray-300">Remove not required page while preserving rest of the pdf.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden mb-3">
            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-3 rounded-lg shadow-sm m-4 text-sm">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('remove_page_functionality') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6 sm:p-8" onsubmit="handleSubmit()">
                @csrf

                <!-- PDF Upload -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload PDF File</label>
                    <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                        <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF only, max 20MB</p>
                        </div>
                    </div>
                </div>

                <!-- Preview of PDF -->
                <div id="pdf_preview" class="hidden mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PDF Preview</label>
                    <div id="pdf_preview_container" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md shadow p-2">
                            <img src="thumbnail.jpg" alt="Page 1" class="w-full h-auto rounded mb-1">
                            <p class="text-xs text-center text-gray-800 dark:text-gray-100">Page 1</p>
                        </div>
                    </div>
                </div>

                <!-- Remove Pages -->
                <div class="space-y-1">
                            <label for="remove_pages" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pages to Remove</label>
                            <input type="text" name="remove_pages" id="remove_pages" placeholder="e.g., 2,4" class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pages to delete (comma-separated)</p>
                </div>
              

                <!-- Submit -->
                <button type="submit" id="removeBtn" class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-all duration-300">
                   Remove Page
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
        const btn = document.getElementById("removeBtn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }
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