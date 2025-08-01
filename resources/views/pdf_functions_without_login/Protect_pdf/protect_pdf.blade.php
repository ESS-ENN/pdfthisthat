@extends('layouts.app')

@section('content')

<main class="h-full bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <div class="flex justify-center text-primary-500 text-4xl mb-4">
                <i class="bi bi-lock-fill"></i>
            </div>
            <h4 class="text-3xl font-extrabold text-primary-600 dark:text-primary-400 mb-3">Encrypt PDF</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Upload a PDF file and set a password to encrypt it securely.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-4">
            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-lg shadow-sm m-8">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" enctype="multipart/form-data" class="space-y-8 p-8 sm:p-10" action="{{ route('guest_protect_pdf_functionality') }}" onsubmit="handleSubmit()">
                @csrf

                <!-- PDF Upload -->
                <div class="space-y-2">
                    <label for="pdf" class="block text-md font-medium text-gray-700 dark:text-gray-300">Upload PDF</label>
                    <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-2xl p-12 text-center bg-gray-50/50 dark:bg-gray-700/30 hover:border-primary-500 dark:hover:border-primary-500">
                        <input type="file" accept=".pdf" name="pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="pdf">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                            <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                            <p>or drag and drop</p>
                        </div>
                        <!-- preview  -->
                        <p id="file-name" class="text-md text-primary-500 mt-2 hidden"></p>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2 relative">
                    <label for="pdf_password" class="block text-md font-medium text-gray-700 dark:text-gray-300">Set Password</label>
                    <input
                        type="password"
                        name="pdf_password"
                        id="pdf_password"
                        pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}" 
                        title="Password must be at least 6 characters and include 1 uppercase letter, 1 digit, and 1 special character"
                        required
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500"/>
                    <span
                        onclick="togglePassword()"
                        class="absolute right-3 top-[48px] transform -translate-y-1/2 cursor-pointer text-sm text-primary-600 dark:text-primary-400 hover:underline"
                    >
                        Show
                    </span>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="protectBtn" class="w-full flex items-center justify-center px-6 py-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300">
                    Encrypt PDF
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
        const btn = document.getElementById("protectBtn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }

    function togglePassword() {
        const input = document.getElementById("pdf_password");
        const toggle = event.target;
        if (input.type === "password") {
            input.type = "text";
            toggle.innerText = "Hide";
        } else {
            input.type = "password";
            toggle.innerText = "Show";
        }
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
</script>

@endsection