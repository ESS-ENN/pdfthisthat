@extends('layouts.app')

@section('content')

<!-- Form -->
<main class="h-full bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8 mt-0">
            <div class="flex justify-center text-primary-500 text-5xl mb-4">
                <i class="bi bi-filetype-pdf"></i>
            </div>
            <h4 class="text-4xl font-extrabold text-primary-600 dark:text-primary-400 mb-3">Merge PDF Files</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Combine multiple PDF documents into one unified file
            </p>
        </div>

        {{-- Merge Form --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-4">
                 <!-- Flash Messages  -->
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-4 rounded-lg shadow-sm m-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                        <a href="{{ session('downloadLink') }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-800/50 hover:bg-green-200 dark:hover:bg-green-700 rounded-full text-sm font-medium transition-colors">
                            Download PDF
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @elseif (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-lg shadow-sm m-8">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('guest_merge_pdf_functionality') }}" method="POST" enctype="multipart/form-data" class="space-y-8 p-8 sm:p-10">
                @csrf

                {{-- File Upload Area --}}
                <div class="space-y-2">
                    <label class="block text-md font-medium text-gray-700 dark:text-gray-300">Select PDF files</label>
                    <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-2xl p-12 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                        <input 
                            type="file" 
                            name="pdfs[]" 
                            id="pdfs" 
                            accept="application/pdf" 
                            multiple 
                            required 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        >
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <svg class="w-12 h-12 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                                <p>or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF files only (max 20MB each)</p>
                            
                        </div>
                    </div>
                </div>

                {{-- Selected Files Preview --}}
                <div id="file-preview" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selected files</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" id="selected-files">
                        <!-- Files will be shown here -->
                    </div>
                </div>

                <button 
                    type="submit" 
                    name="merge" 
                    class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    Merge PDFs Now
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
    // Add file preview functionality
    document.getElementById('pdfs').addEventListener('change', function(e) {
        const filePreview = document.getElementById('file-preview');
        const selectedFilesContainer = document.getElementById('selected-files');
        
        if (this.files.length > 0) {
            selectedFilesContainer.innerHTML = '';
            
            Array.from(this.files).forEach((file, index) => {
                const fileElement = document.createElement('div');
                fileElement.className = 'flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg';
                fileElement.innerHTML = `
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex-1 truncate">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">${file.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-red-500" onclick="removeFile(${index})">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                `;
                selectedFilesContainer.appendChild(fileElement);
            });
            
            filePreview.classList.remove('hidden');
        } else {
            filePreview.classList.add('hidden');
        }
    });

    function removeFile(index) {
        const input = document.getElementById('pdfs');
        const files = Array.from(input.files);
        files.splice(index, 1);
        
        // Create new DataTransfer to set files
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
        
        // Trigger change event to update preview
        const event = new Event('change');
        input.dispatchEvent(event);
    }
</script>

@endsection