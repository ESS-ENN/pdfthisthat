@extends('layouts.app')

@section('content')

<main class="flex-grow bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8 font-sans mb-8">

        <div class="text-center mb-4 mt-8">
            <div class="flex justify-center text-primary-500 text-5xl mb-3">
                <i class="bi bi-filetype-html"></i>
                </div>
                <h4 class="text-3xl font-extrabold text-primary-600 dark:text-primary-400">HTML to PDF Converter</h1>
            <p class="text-md text-gray-600 dark:text-gray-300 mt-2">Paste HTML or provide a URL to generate a downloadable PDF.</p>
        </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden p-6 w-full max-w-3xl mx-auto mt-6">
                
                <form action="{{ route('html_pdf_download') }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="handleSubmit()">
                    @csrf
                    @if ($errors->any())
                        <div class="text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Upload Section -->
                    <div class="mb-4">
                        <label for="html" class="block text-gray-700 dark:text-gray-300 mb-2 font-medium text-sm">Website URL:</label>
                        <input 
                            type="url" 
                            name="html" 
                            id="html" 
                            placeholder="https://example.com"
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                            pattern="https?://.+">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter the full URL (including http:// or https://)</p>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                            id="htmlBtn"
                            class="w-full flex items-center justify-center px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300 text-sm">
                            Convert PDF
                        </button>
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

<script>
    function handleSubmit() {
        const btn = document.getElementById("htmlBtn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }
</script>

@endsection