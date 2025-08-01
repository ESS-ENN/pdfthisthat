@extends('layouts.app')

@section('content')

<main class="h-full bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-6">
            <div class="flex justify-center text-primary-500 text-4xl mb-3">
                <i class="bi bi-123"></i>
            </div>
            <h4 class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">Add Page Numbers</h1>
            <p class="text-md text-gray-600 dark:text-gray-300">
                Upload a PDF and select where you want page numbers to appear.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden mb-4">
        
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-3 rounded-lg shadow-sm m-6">
                    @foreach ($errors->all() as $error)
                        <p>⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif
 
            <form action="{{ route('page_numbers_functionality') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6 sm:p-8" onsubmit="handleSubmit()">
                @csrf

                {{-- File Upload --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload PDF</label>
                    <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center bg-gray-50/50 dark:bg-gray-700/30 hover:border-primary-500 dark:hover:border-primary-500">
                        <input type="file" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" name="pdfs[]" id="pdfs">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="bi bi-file-earmark-arrow-up text-primary-500 text-3xl"></i>
                            <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                            <p>or drag and drop</p>
                            <!-- preview -->
                            <p id="file-name" class="text-sm text-primary-500 mt-1 hidden"></p>
                        </div>
                    </div>
                </div>

                {{-- Position Selector --}}
                <div class="space-y-2">
                    <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Page Number Position</label>
                    <select name="position" id="position" required class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="top-right">Top Right</option>
                        <option value="bottom-left">Bottom Left</option>
                        <option value="bottom-center">Bottom Center</option>
                        <option value="bottom-right">Bottom Right</option>
                    </select>
                </div>

                {{-- Submit --}}
                <button type="submit" id="pageBtn" class="w-full flex items-center justify-center px-5 py-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300">
                    Add Page Numbers
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
        const btn = document.getElementById("pageBtn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }

    const pdfInput = document.getElementById('pdfs');
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