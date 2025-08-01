@extends('layouts.app')

@section('content')

<main class="h-full py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <div class="flex justify-center text-primary-500 text-5xl mb-4">
                <i class="bi bi-filetype-jpg"></i>
            </div>
            <h4 class="text-4xl font-extrabold text-primary-600 dark:text-primary-400 mb-3">Convert PDF to Images</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Upload a PDF to convert each page into a high-quality image.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-4">

                {{-- Error handling --}}
                @if ($errors->has('conversion'))
                    <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-6 text-red-700 rounded-md shadow-sm mt-8">
                        <strong>Error:</strong> {{ $errors->first('conversion') }}
                    </div>
                @endif

            <form action="{{ route('guest_pdf_to_jpg_functionality') }}" method="POST" enctype="multipart/form-data" class="space-y-8 ml-4 mr-8 mb-8 mt-0 sm:m-10"    onsubmit="handleSubmit()">
             @csrf
                <!-- File Upload -->
                <div class="space-y-2">
                    <label for="pdf" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Upload PDF File</label>
                    <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-2xl p-12 text-center hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                        <input type="file" name="pdf" id="pdf" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="bi bi-file-earmark-arrow-up text-primary-500 text-4xl"></i>
                            <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload PDF</p>
                            <p>or drag and drop</p>
                        </div>
                        <!-- Optional preview text -->
                        <p id="file-name" class="text-sm text-primary-500 mt-2 hidden"></p>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" name="convert" class="w-full flex items-center justify-center px-5 py-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300 text-lg" id="pdfjpgBtn">
                    Convert PDF to Images
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
        const btn = document.getElementById("pdfjpgBtn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }

    const pdfInput = document.getElementById('pdf');
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