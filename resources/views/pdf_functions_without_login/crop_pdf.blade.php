@extends('layouts.app')

@section('content')

<main class="h-full dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8 mt-0">
            <div class="flex justify-center text-primary-500 text-5xl mb-4">
                <i class="bi bi-crop"></i>
            </div>
            <h4 class="text-4xl font-extrabold text-primary-600 dark:text-primary-400 mb-3">Crop PDF Tool</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Crop and adjust your PDF document dimensions.
            </p>
        </div>

        {{-- Crop PDF Form --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-4">
            <!-- Flash Messages  -->
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-4 rounded-lg shadow-sm m-8">
                    <div class="flex items-center justify-between  text-sm">
                        <div>
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                        @if(session('downloadLink'))
                            <a href="{{ session('downloadLink') }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-800/50 hover:bg-green-200 dark:hover:bg-green-700 rounded-full text-sm font-medium transition-colors">
                                Download Cropped PDF
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            @elseif (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-lg shadow-sm m-8  text-sm">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/tools_crop_pdf" enctype="multipart/form-data" class="space-y-8 p-8 sm:p-10">
                @csrf

                {{-- File Upload Area --}}
                <div class="space-y-2">
                    <label class="block text-md font-medium text-gray-700 dark:text-gray-300">Choose PDF File</label>
                    <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-2xl p-12 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                        <input 
                            type="file" 
                            name="pdf" 
                            id="pdf" 
                            accept=".pdf" 
                            required 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        >
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <svg class="w-12 h-12 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div class="text-sm text-gray-600 dark:text-gray-400 text-sm">
                                <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                                <p>or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF (max 20MB)</p>
                            <!-- preview  -->
                            <p id="file-name" class="text-md text-primary-500 mt-2 hidden"></p>
                        </div>
                    </div>
                </div>

                {{-- Crop Size Options --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Crop Size</label>
                        <div class="grid grid-cols-2 gap-4">
                            @php
                                $cropSizes = [
                                    'a4' => ['name' => 'A4', 'width' => 210, 'height' => 297],
                                    'a5' => ['name' => 'A5', 'width' => 148, 'height' => 210],
                                    'letter' => ['name' => 'Letter', 'width' => 216, 'height' => 279],
                                    'custom' => ['name' => 'Custom', 'width' => null, 'height' => null],
                                ];
                            @endphp
                            @foreach ($cropSizes as $key => $size)
                                <div class="flex items-center font-medium">
                                    <input 
                                        type="radio" 
                                        id="size_{{ $key }}" 
                                        name="size" 
                                        value="{{ $key }}" 
                                        class="h-5 w-5 text-primary-500 focus:ring-primary-500 border-gray-300" 
                                        {{ old('size', 'a4') === $key ? 'checked' : '' }}
                                    >
                                    <label for="size_{{ $key }}" class="ml-3 text-lg text-gray-700 dark:text-gray-300 font-medium">
                                        {{ $size['name'] }} 
                                        @if($key !== 'custom')
                                            ({{ $size['width'] }}mm × {{ $size['height'] }}mm)
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Custom Size Fields --}}
                    <div id="customSizeFields" class="hidden space-y-6">
                        <div>
                            <label for="custom_width" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custom Width (mm)</label>
                            <input type="number" id="custom_width" name="custom_width" value="{{ old('custom_width') }}"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label for="custom_height" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custom Height (mm)</label>
                            <input type="number" id="custom_height" name="custom_height" value="{{ old('custom_height') }}"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit" 
                    class="w-full flex items-center justify-center px-5 py-3 bg-gradient-to-r bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300 text-lg"
                >
                    <i class="bi bi-crop mr-2"></i>
                    Crop PDF
                </button>
            </form>
        </div>
    </div>
</main>

<!-- PDF Tools Group -->
<div class="max-w-7xl mx-auto px-2 sm:px-6 py-6 text-center">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold mb-4 dark:text-white">Try Other Tools Also</h2>
        <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
            Quickly access your favorite utilities with our comprehensive toolkit
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- PDF Tools Group -->
        <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tool Card Example -->
                <a href="/merge-pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                    <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                        <i class="bi bi-filetype-pdf"></i>
                    </div>
                    <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Merge PDF</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Combine multiple PDFs into one document.</p>
                    <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                        Try now <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </a>

                <a href="/merge-pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-arrows-angle-contract"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Compress PDFs</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Minimize file size while maintaining the highest PDF quality.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                </a>

                <a href="/split-pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                    <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                        <i class="bi bi-scissors"></i>
                    </div>
                    <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Split PDF</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Extract pages or split by sections.</p>
                    <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                        Try now <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Centered Button -->
    <div class="flex justify-center mb-8">
        <a href="{{ route('tools')}}" class="inline-flex items-center justify-center bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-md text-sm font-semibold transition shadow-md hover:shadow-lg">
            Explore All Tools <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>

<script>
    // Toggle custom size fields
    function toggleCustomFields() {
        const selected = document.querySelector('input[name="size"]:checked').value;
        document.getElementById('customSizeFields').classList.toggle('hidden', selected !== 'custom');
    }

    document.querySelectorAll('input[name="size"]').forEach(input => {
        input.addEventListener('change', toggleCustomFields);
    });

    window.addEventListener('DOMContentLoaded', toggleCustomFields);

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
    
</script>


@endsection