@extends('layouts.app')

@section('content')

<!-- Form -->
<main class="h-full bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-4 mt-0">
            <div class="flex justify-center text-primary-500 text-4xl mb-2">
                <i class="bi bi-images"></i>
            </div>
            <h4 class="text-3xl font-extrabold text-primary-600 dark:text-primary-400 mb-2">Convert Images to PDF</h1>
            <p class="text-md text-gray-600 dark:text-gray-300">
                Combine multiple images into a single PDF document.
            </p>
        </div>

        {{-- Image to PDF Form --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden mb-4">
            <!-- Flash Messages -->
            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-lg shadow-sm m-4">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Large size Image popup -->
            <div id="file-error-popup" class="hidden fixed inset-0 flex items-center justify-center z-50 bg-black/40 backdrop-blur-sm">
                <div class="relative bg-white text-red-700 border-l-4 border-red-500 px-8 py-6 rounded-2xl shadow-xl max-w-md w-full animate-fade-in">
                    <button onclick="document.getElementById('file-error-popup').classList.add('hidden')" 
                            class="absolute top-2 right-3 text-red-500 hover:text-red-700 text-2xl font-bold leading-none focus:outline-none"
                            aria-label="Close">
                        &times;
                    </button>

                    <div class="flex items-start gap-4">
                        <div class="pt-1">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 4.5a7.5 7.5 0 017.5 7.5v0a7.5 7.5 0 01-15 0v0a7.5 7.5 0 017.5-7.5z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold mb-1">Upload Error</h3>
                            <p class="text-sm leading-relaxed">
                                One or more selected images exceed the <strong>10MB</strong> size limit. Please select smaller files and try again.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 p-4 sm:p-6" onsubmit="handleSubmit()">
                @csrf

                {{-- File Upload Area --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Image files</label>
                    <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                        <input 
                            type="file" 
                            name="images[]" 
                            id="images" 
                            accept="image/*" 
                            multiple 
                            required 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        >
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <svg class="w-12 h-12 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 012-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                                <p>or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WEBP, etc. (max 10MB each)</p>
                        </div>
                    </div>
                </div>

                {{-- Options --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="orientation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Page Orientation</label>
                        <select id="orientation" name="orientation" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500">
                            <option value="portrait">Portrait</option>
                            <option value="landscape">Landscape</option>
                        </select>
                    </div>
                    <div>
                        <label for="margin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Page Margin (mm)</label>
                        <input type="number" id="margin" name="margin" min="0" max="25" value="5" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                {{-- Selected Files Preview --}}
                <div id="file-preview" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selected images</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3" id="selected-files">
                        <!-- Files will be shown here -->
                    </div>
                </div>

                <button 
                    type="submit" 
                    name="convert" 
                    id="imgBtn"
                    class="w-full flex items-center justify-center p-2 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-all duration-300">
                    Convert to PDF
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
        const btn = document.getElementById("imgBtn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }
    // Add file preview functionality with image thumbnails
    document.getElementById('images').addEventListener('change', function(e) {
        const filePreview = document.getElementById('file-preview');
        const selectedFilesContainer = document.getElementById('selected-files');

        const maxSizeMB = 10;
        const maxSizeBytes = maxSizeMB * 1024 * 1024;
        const files = e.target.files;
        let oversized = false;

        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSizeBytes) {
                oversized = true;
                break;
            }
        }

        if (oversized) {
            const popup = document.getElementById('file-error-popup');
            popup.classList.remove('hidden');
            e.target.value = ''; // Clear selected files
        }
        
        if (this.files.length > 0) {
            selectedFilesContainer.innerHTML = '';
            
            Array.from(this.files).forEach((file, index) => {
                const fileElement = document.createElement('div');
                fileElement.className = 'flex flex-col items-center p-2 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600';
                
                // Create thumbnail if it's an image
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-24 object-contain mb-2';
                        img.alt = 'Thumbnail';
                        
                        const container = fileElement.querySelector('.thumbnail-container');
                        if (container) {
                            container.appendChild(img);
                        }
                    };
                    reader.readAsDataURL(file);
                }
                
                fileElement.innerHTML = `
                    <div class="thumbnail-container w-full flex justify-center items-center h-24 mb-2"></div>
                    <div class="w-full truncate text-center">
                        <p class="text-xs font-medium text-gray-900 dark:text-white truncate">${file.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                    </div>
                    <button type="button" class="absolute top-1 right-1 text-gray-400 hover:text-red-500 bg-white dark:bg-gray-700 rounded-full p-1" onclick="removeFile(${index})">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                `;
                fileElement.style.position = 'relative';
                selectedFilesContainer.appendChild(fileElement);
            });
            
            filePreview.classList.remove('hidden');
        } else {
            filePreview.classList.add('hidden');
        }
    });

    function removeFile(index) {
        const input = document.getElementById('images');
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
