<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>PDFThisThat - Online Utility Hub</title>
    
    <!-- PDF favicon for browser tab -->
    <link rel="icon" type="image/png" href="/images/favicons/pdf_favicon.png" alt="PDF icon">

    <!-- Basic Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="PDFThisThat offers a full suite of free, fast, and secure online PDF tools—merge, compress, convert, edit, redact, protect, and more, all in your browser.">
    <meta name="keywords" content="PDF, merge PDF, compress PDF, edit PDF, convert PDF, redact PDF, protect PDF, online PDF tools">
    <meta name="author" content="PDFThisThat">
    <meta name="robots" content="index, follow">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://pdfthisthat.dilonline.in/">

    <!-- Open Graph Tags for Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="PDFThisThat – Free Online PDF Toolkit">
    <meta property="og:description" content="Your complete online PDF toolkit: merge, compress, convert, edit, protect, redact, and more—fast, secure, and free.">
    <meta property="og:url" content="https://pdfthisthat.dilonline.in/">
    <meta property="og:image" content="https://pdfthisthat.dilonline.in/images/favicons/pdf_favicon.png">
    <meta property="og:site_name" content="PDFThisThat">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="PDFThisThat – Free Online PDF Toolkit">
    <meta name="twitter:description" content="Fast, secure, and free online tools to merge, compress, convert, edit, redact, protect PDFs in your browser.">
    <meta name="twitter:image" content="https://pdfthisthat.dilonline.in/assets/twitter-card.jpg">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        primary: {
                            500: '#2563eb',
                            600: '#1d4ed8'
                        },
                        darkbg: '#0f172a',
                        lightbg: '#f8fafc'
                    },
                    boxShadow: {
                        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02)',
                        'card-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    </script>
    <script>
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "PDFThisThat",
            "url": "https://pdfthisthat.dilonline.in/",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "https://pdfthisthat.dilonline.in/tools?query={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
     
     <!-- bootstrap Icons  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .tool-card {
            transition: all 0.3s ease;
        }
        .tool-card:hover {
            transform: translateY(-5px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(37,99,235,0.05) 100%);
        }
        .dark .gradient-bg {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.8) 100%);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-lightbg text-gray-800 dark:bg-darkbg dark:text-gray-200">

    <!-- 🔝 Navbar -->
    <header class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
            <h4 class="text-2xl font-extrabold text-primary-500">PDFThisThat</h1>
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-4 text-sm font-medium">
            @if (Route::has('login'))
            <a href="{{ route('login') }}"
                class="bg-primary-500 hover:bg-primary-600 text-white px-1.2 py-1 md:px-4 md:py-2 text-xs md:text-base rounded-md font-semibold shadow-md w-full md:w-auto text-center">
                Login
            </a>
            @endif

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="bg-primary-500 hover:bg-primary-600 text-white px-1.5 py-1 md:px-4 md:py-2 text-xs md:text-base rounded-md font-semibold shadow-md w-full md:w-auto text-center">
                Register
            </a>
            @endif
            </div>
        </div>
    </header>

        <!-- 🔧 Tool Grid -->
    <section id="" class="max-w-7xl mx-auto px-4 sm:px-6 py-6 mb-14">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4 dark:text-white"> Tools</h2>
            <p class="text-black-500 dark:text-gray-400 max-w-2xl mx-auto text-xl">PDFThisThat toolkit. Merge, split, compress, convert, and more — free, fast, and hassle-free.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- PDF Tools Group -->
            <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Tool Block -->
                    <a href="{{ route('guest_merge_pdf')}}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-filetype-pdf"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Merge PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Combine multiple PDF documents into one unified pdf.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_protect_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-lock"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Protect PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload a PDF file and set a password to encrypt it securely.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_redact_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-card-heading"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Redact PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Redact sensitive PDF informations or data, and keep your content safe.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_pdf_to_jpg') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-filetype-jpg"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">PDF to JPG</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload a PDF to convert each page into a high-quality image.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_jpg_to_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">JPG to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">CCombine single or multiple images into a single PDF document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="/excel_to_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-excel"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Excel to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Convert an Excel spreadsheet to a PDF file.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="/page_numbers" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-123"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Page Numbers</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Add page numbers to the PDF document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('organize_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-layout-text-sidebar-reverse"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Organize PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Rearrange or remove pages from your PDF.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>              

                    <a href="/split_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-pdf"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Split PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Extract specific pages from your PDF document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="/remove_page" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-trash3"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Remove Pages</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Remove not required page while preserving rest of the pdf.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('rotate_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-arrow-clockwise"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Rotate PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload a PDF and choose the direction to rotate its pages.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                     <a href="{{ route('word_to_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-word"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Word to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Convert your DOCX file into a downloadable PDF.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('compress_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-arrows-angle-contract"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Compress PDFs</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Minimize file size while maintaining the highest PDF quality.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>    

                    <a href="{{ route('guest_sign_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-pencil-square"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Sign PDFs</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Add your signature to the document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>  

                    <a href="/edit_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-brush"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Edit PDFs</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload your PDF to start editing with various tools.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                     <a href="{{ route('watermark_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-droplet"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Watermark</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Embed the watermark in your pdf document.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('html_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                           <i class="bi bi-filetype-html"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">HTML to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Paste HTML or provide a URL to generate a downloadable PDF.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                     <a href="/unlock_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-unlock"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Unlock PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload a password-protected PDF, enter the password, and decrypt the file for download.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_ocr_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-book"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">OCR PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Recognize text in scanned documents and images.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="/compare_pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-layout-split"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Compare PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Upload two PDFs to check differences side by side.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_crop_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-crop"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Crop PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Crop and adjust your PDF document dimensions.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                </div>
            </div>
    
    </section>

    <!-- Footer Section -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 mt-4">
            <!-- Bottom Bar -->
        <div class="mb-2 border-t border-gray-200 dark:border-gray-800 text-center">
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                    &copy; 2025 PDFThisThat. All rights reserved.
                </div>
        </div>
    </footer>

</body>

<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-RLMKP78X4K"></script> 
<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-RLMKP78X4K'); </script>
</html>