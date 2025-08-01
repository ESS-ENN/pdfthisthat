@extends('layouts.app')

@section('content')

    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .line { margin-bottom: 2px; }
        .red { color: red; }
        .green { color: green; }
        .black { color: black; }
        .container { display: flex; gap: 20px; }
        .column { width: 50%; }
    </style>


<main class="flex-grow bg-gray-50 dark:bg-gray-900 py-4 px-2 sm:px-4 lg:px-6">
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

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-hidden mb-8 mt-8 p-8 border border-gray-100 dark:border-gray-700">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-5 mb-8 shadow-sm transition-all duration-300 hover:shadow-md">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 p-2 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-medium text-green-800 dark:text-green-100">Comparison Complete</h3>
                                <p class="text-sm text-green-600 dark:text-green-300">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-10 text-center">
                <h4 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">PDF Comparison Result</h1>
                <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">Side-by-side comparison of your uploaded documents</p>
            </div>

            <div class="pdf-container grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                <!-- PDF 1 Container -->
            <div class="pdf-box bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-auto max-h-[700px]">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center space-x-3">
                        <span class="w-3 h-3 rounded-full bg-blue-500 flex-shrink-0"></span>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Output 1</h2>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 bg-blue-100/70 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 text-xs font-medium rounded-full border border-blue-200 dark:border-blue-800/50">PDF 1</span>
                        <a href="{{ session('pdf1_url') }}" download="output1.pdf" target="_blank" 
                        class="inline-flex items-center justify-center w-9 h-9 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 rounded-lg text-white transition-all
                                shadow-sm hover:shadow-md transform hover:-translate-y-0.5 active:translate-y-0
                                focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-900"
                        title="Download PDF">
                        <i class="bi bi-file-earmark-arrow-down text-md"></i>
                        </a>
                    </div>
                </div>
                <div class="prose dark:prose-invert max-w-none prose-p:my-3 prose-li:my-1 prose-headings:font-medium prose-headings:text-gray-800 dark:prose-headings:text-gray-200 prose-code:px-2 prose-code:py-1 prose-code:bg-gray-100 dark:prose-code:bg-gray-700 prose-code:rounded">
                    {!! session('pdf1_compare') !!}
                </div>
            </div>

            <!-- PDF 2 Container -->
            <div class="pdf-box bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-auto max-h-[700px]">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center space-x-3">
                        <span class="w-3 h-3 rounded-full bg-purple-500 flex-shrink-0"></span>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Output 2</h2>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 bg-purple-100/70 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200 text-xs font-medium rounded-full border border-purple-200 dark:border-purple-800/50">PDF 2</span>
                        <a href="{{ session('pdf2_url') }}" download="{{ session('pdf2_name') }}" target="_blank" 
                        class="inline-flex items-center justify-center w-9 h-9 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 rounded-lg text-white transition-all
                                shadow-sm hover:shadow-md transform hover:-translate-y-0.5 active:translate-y-0
                                focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-900"
                        title="Download PDF">
                        <i class="bi bi-file-earmark-arrow-down text-md"></i>
                        </a>
                    </div>
                </div>
                <div class="prose dark:prose-invert max-w-none prose-p:my-3 prose-li:my-1 prose-headings:font-medium prose-headings:text-gray-800 dark:prose-headings:text-gray-200 prose-code:px-2 prose-code:py-1 prose-code:bg-gray-100 dark:prose-code:bg-gray-700 prose-code:rounded">
                    {!! session('pdf2_compare') !!}
                </div>
            </div>

            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-12">
                <div class="flex justify-center mb-8">
                    <a href="/compare_pdf"  class="inline-flex items-center justify-center bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-md text-sm font-semibold transition shadow-md hover:shadow-lg
                    transform hover:-translate-y-0.5 active:translate-y-0 active:scale-95
                    ring-2 ring-transparent hover:ring-primary-300 focus:outline-none focus:ring-primary-400
                    focus:ring-offset-2 focus:ring-offset-white">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Compare More PDFs
                    </a>
            </div>
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

@endsection