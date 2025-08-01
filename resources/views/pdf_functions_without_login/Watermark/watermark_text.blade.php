@extends('layouts.app')

@section('content')

<main class="h-full bg-gray-50 dark:bg-gray-900 py-4 px-2 sm:px-4 lg:px-6">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-4 mt-0">
            <div class="flex justify-center text-primary-500 text-4xl mb-2">
                <i class="bi bi-droplet"></i>
            </div>
            <h4 class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">Watermark to PDF</h1>
            <p class="text-base text-gray-600 dark:text-gray-300">
                Embed the watermark in your pdf document.
            </p>


            <!-- Text Watermark Button -->
            <a href="/watermark_text" class="group relative inline-flex items-center px-4 py-2 font-semibold text-primary-600 rounded-full bg-white/80 backdrop-blur-md border border-primary-300 hover:border-primary-500 transition-all duration-300 shadow hover:shadow-lg mt-6 mb-6">
                <!-- Icon Container -->
                <span class="mr-3 flex h-9 w-9 items-center justify-center rounded-full bg-primary-100 text-primary-600 group-hover:bg-primary-200 transition-all duration-300">
                    <i class="bi bi-pencil-square text-xl"></i>
                </span>

                <!-- Button Text -->
                <span class="text-base tracking-wide">Try Image Watermark</span>

                <!-- Hover Arrow -->
                <span class="ml-3 text-primary-500 opacity-0 group-hover:opacity-100 transform transition-all duration-300 group-hover:translate-x-1">
                   <i class="bi bi-arrow-right text-xl"></i>
                </span>
            </a>


        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-4">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-4 rounded-lg shadow-sm m-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                        <a href="{{ session('download_url') }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-800/50 hover:bg-green-200 dark:hover:bg-green-700 rounded-full text-sm font-medium transition-colors" download="watermaked_pdf.pdf">
                            Download PDF
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-3 rounded-lg shadow-sm m-4 text-sm">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" enctype="multipart/form-data" action="{{ route('watermark_text') }}" class="space-y-6 p-5 sm:p-6" onsubmit="handleSubmit()">
               @csrf
                
                <!-- PDF Upload -->
                <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload PDF File</label>
                        <div class="relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                            <input type="file" accept=".pdf" name="pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="pdf_file">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF file only</p>
                                 <!-- preview  -->
                                <p id="file-name" class="text-sm text-primary-500 mt-2 hidden"></p>
                            </div>
                        </div>
                </div>                   
                
                <!-- Watermark text -->
                <div class="relative mt-4 mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Watermark Text</label>
                    <input
                        type="text"
                        name="watermark_text"
                        placeholder="Enter watermark text..."
                        class="w-full px-3 py-1.5 text-black placeholder-primary-400 bg-white/80 backdrop-blur-md border border-primary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-primary-500 transition-all duration-300"/>
                </div>

                <!-- Text Styling Controls -->
                <div class="flex flex-wrap items-center gap-4 text-sm mb-5">
                    <!-- Font Styles -->
                    <div class="flex items-center gap-3">
                        <label class="text-gray-700 dark:text-gray-300 font-semibold">Style:</label>
                        <label class="inline-flex items-center gap-1">
                            <input type="checkbox" name="bold" class="accent-primary-500 w-5 h-5">
                            <span class="font-bold text-base text-gray-700 dark:text-gray-300">B</span>
                        </label>
                        <label class="inline-flex items-center gap-1">
                            <input type="checkbox" name="italic" class="accent-primary-500 w-5 h-5">
                            <span class="italic text-base text-gray-700 dark:text-gray-300">I</span>
                        </label>
                        <label class="inline-flex items-center gap-1">
                            <input type="checkbox" name="underline" class="accent-primary-500 w-5 h-5">
                            <span class="underline text-base text-gray-700 dark:text-gray-300">U</span>
                        </label>
                    </div>

                    <!-- Font Family -->
                    <div>
                        <label class="sr-only">Font</label>
                        <select name="font_family"
                            class="text-sm px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="Arial">Arial</option>
                            <option value="Times New Roman">Times</option>
                            <option value="Courier New">Courier</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Verdana">Verdana</option>
                        </select>
                    </div>

                    <!-- Font Size -->
                    <div>
                        <label class="sr-only">Size</label>
                        <input type="number" name="font_size" min="8" max="100" value="24"
                            class="w-20 text-sm px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                            placeholder="Size">
                    </div>

                    <!-- Text Color -->
                    <div>
                        <label class="sr-only">Color</label>
                        <input type="color" name="text_color" value="#000000"
                            class="w-10 h-10 p-1 border border-primary-300 rounded-md bg-white dark:bg-gray-700 cursor-pointer">
                    </div>
                </div>

                
                <!-- Position and Transparency  -->
                 <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Image Transparency -->
                    <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image Transparency:</label>
                            <select name="image_transparency" id="image_transparency"
                             class="mt-1 block w-full pl-3 pr-10 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 ring-1 ring-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300">
                                <option value="low">40%</option>
                                <option value="medium">60%</option>
                                <option value="high">80%</option>
                                <option value="full">100%</option>
                            </select>
                    </div>                    

                    <!-- Postion of the Watermark -->
                    <div class="space-y-1">
                        <label for="watermark_position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Position</label>
                        <select name="watermark_position" id="watermark_position"
                           class="mt-1 block w-full pl-3 pr-10 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 ring-1 ring-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300">
                            <option value="top-left">Top Left</option>
                            <option value="top-center">Top Center</option>
                            <option value="top-right">Top Right</option>
                            <option value="middle-left">Middle Left</option>
                            <option value="middle-center" selected>Middle Center</option>
                            <option value="middle-right">Middle Right</option>
                            <option value="bottom-left">Bottom Left</option>
                            <option value="bottom-center">Bottom Center</option>
                            <option value="bottom-right">Bottom Right</option>
                        </select>
                    </div>
                </div>

                <button type="submit" id="watermarktextBtn" class="w-full flex items-center justify-center p-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300 text-sm">
                    Generate Watermarked PDF
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
        const btn = document.getElementById("watermarktextBtn");
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


</script>

@endsection