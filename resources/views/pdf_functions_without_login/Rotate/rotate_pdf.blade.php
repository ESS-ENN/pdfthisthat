@extends('layouts.app')

@section('content')

<section class="py-8 px-3 sm:px-4 lg:px-6 bg-gray-50">
  <div class="max-w-3xl mx-auto">
    <!-- Section Header -->
    <div class="text-center mb-8">
      <div class="flex justify-center text-blue-600 text-3xl mb-2">
        <i class="bi bi-arrow-clockwise"></i>
      </div>
      <h4 class="text-2xl font-bold text-gray-800 dark:text-white mb-1">Rotate PDF</h1>
      <p class="text-sm text-gray-600 dark:text-gray-300">
        Upload a PDF and choose the rotation angle.
      </p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 space-y-6">
      <form action="{{ route('rotate_pdf_functionality') }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="handleSubmit()">
        @csrf
        @if (session('error'))
          <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-md shadow-sm text-sm">
            <div class="flex items-center mb-1">
              <svg class="w-4 h-4 mr-1 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <strong>Error</strong>
            </div>
            <p class="ml-5">{{ session('error') }}</p>
          </div>
        @endif

        <!-- File Upload -->
        <div class="space-y-1">
          <label for="pdfs" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Select PDF File(s)</label>
          <div class="relative border-2 border-dashed border-blue-400 rounded-xl p-6 text-center bg-gray-50/50 dark:bg-gray-700/30 hover:border-blue-500">
            <input 
              type="file" 
              name="pdfs[]" 
              id="pdfs" 
              accept="application/pdf" 
              multiple 
              required 
              class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
            <div class="text-xs text-gray-600 dark:text-gray-400">
              <i class="bi bi-file-earmark-arrow-up text-blue-500 text-2xl"></i>
              <p class="text-blue-600 dark:text-blue-300 font-medium">Click or drag to upload</p>
            </div>
            <p id="file-name" class="text-xs text-blue-500 mt-1 hidden"></p>
          </div>
        </div>

        <!-- Rotation Options -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Rotation Angle:</label>
          <div class="grid grid-cols-4 gap-3 text-sm">
            @foreach ([90, 180, 270, 360] as $angle)
              <label class="flex items-center space-x-2">
                <input type="radio" name="rotation" value="{{ $angle }}" class="h-4 w-4 text-blue-600">
                <span class="text-gray-700 dark:text-gray-300">{{ $angle }}&deg;</span>
              </label>
            @endforeach
          </div>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" id="rotateBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            Rotate PDF
          </button>
        </div>
      </form>
    </div>
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
        const btn = document.getElementById("rotateBtn");
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