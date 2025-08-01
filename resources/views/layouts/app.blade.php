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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- bootstrap Icons  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md font-semibold shadow-md">
                            Login
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-2 bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md font-semibold shadow-md">
                            Register
                        </a>
                    @endif
                @else
                    <div class="relative">
                        <button id="dropdownButton" class="flex items-center text-gray-700 hover:text-primary-500 focus:outline-none px-8">
                            <i class="bi bi-person-circle text-xl mr-2"></i>
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4 ml-1 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownMenu" class="absolute right-0 hidden mt-2 w-36 bg-white shadow-md border border-gray-100 rounded-md text-sm">
                            <a href="/home" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">Dashboard</a>
                            <a href="/history_page" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">History</a>
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-600">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Form Section -->
      @yield('content')

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
<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-RLMKP78X4K"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-RLMKP78X4K'); </script>
  <script>
    // Get the button and dropdown menu elements
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        // Toggle dropdown visibility on button click
        dropdownButton.addEventListener('click', function(event) {
            event.stopPropagation();  // Prevent the click event from bubbling up to the document
            dropdownMenu.classList.toggle('hidden');
        });

        // Close the dropdown if the user clicks outside of it
        document.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>

</html>
