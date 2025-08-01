<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>PDFThisThat - All-in-One Online PDF Utility Platform</title>

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

    <!-- bootstrap Icons  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
            <h4 class="text-2xl font-extrabold text-primary-500">PDFThisThat</h4>
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

    <!-- ✨ Hero Section -->
    <section class="gradient-bg py-24 text-center">
        <div class="max-w-4xl mx-auto px-4">
            <div class="inline-flex items-center bg-primary-500/10 text-primary-500 px-4 py-1 rounded-full text-xs font-semibold mb-4">
                <i class="fas fa-bolt mr-2"></i> ALL TOOLS FREE TO USE
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 text-gray-900 dark:text-white leading-tight">
                Your Complete <span class="text-primary-500">Online Utility</span> Toolkit
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                Convert, compress, edit and optimize files with our powerful online tools. No installation required.
            </p>
        </div>
    </section>

    <!-- 🔍 Search Bar -->
    <section class="max-w-3xl mx-auto px-4 -mt-8 mb-12">
        <div class="relative">
           <a href="{{ route('tools')}}" class="inline-flex items-center justify-center bg-primary-500 hover:bg-primary-600 text-white px-10 py-4 rounded-md text-sm font-semibold transition shadow-md hover:shadow-lg">
                    Dive Into Our Tools Collection <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <!-- 🔧 Tool Grid Section -->
    <section id="" class="max-w-7xl mx-auto px-4 sm:px-6 py-6 mb-14 text-center">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4 dark:text-white">Popular Tools</h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Hello and welcome!
            </p>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Access Some of the Essential Tools Instantly
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- PDF Tools Group -->
            <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Tool Card Example -->
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

                    <a href="{{ route('guest_jpg_to_pdf') }}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">JPG to PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Convert JPG images to PDF in seconds.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>

                    <a href="{{ route('guest_merge_pdf')}}" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition duration-300 relative overflow-hidden">
                        <div class="text-4xl mb-4 text-primary-500 group-hover:text-black">
                            <i class="bi bi-filetype-pdf"></i>
                        </div>
                        <h3 class="text-xl font-bold group-hover:text-primary-500 dark:text-white">Merge PDF</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Combine multiple files into one.</p>
                        <div class="mt-4 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                            Try now <i class="fas fa-arrow-right ml-1"></i>
                        </div>
                    </a>
                </div>
        </div>

                </div>
            </div>
        </div>

        <!--  Centered Button -->
        <!-- <div class="mt-12 flex justify-center">
            <a href="{{ route('tools')}}" class="inline-flex items-center justify-center bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-md text-sm font-semibold transition shadow-md hover:shadow-lg">
                    Explore All Tools <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div> -->
    </section>

    <!-- Features -->
    <!-- <section class="py-12 bg-white py-24" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center ">
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            PDFs Simplified
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Everything you need for your PDF files.
            </p>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            A complete set of free and easy-to-use tools to manage your PDF files.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="tool-card bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition transform hover:-translate-y-1">
            <div class="text-4xl mb-4 text-primary-500"><i class="bi bi-file-earmark-pdf-fill"></i></div>
            <h3 class="text-lg font-semibold mb-2 dark:text-white">PDF Tools</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Merge, split, compress and convert PDFs with ease.</p>
            </div>

            <div class="tool-card bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition transform hover:-translate-y-1">
            <div class="text-4xl mb-4 text-primary-500"><i class="bi bi-shield-lock-fill"></i></div>
            <h3 class="text-lg font-semibold mb-2 dark:text-white">Secure</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Files stay private – processed in your browser.</p>
            </div>

            <div class="tool-card bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition transform hover:-translate-y-1">
            <div class="text-4xl mb-4 text-primary-500"><i class="bi bi-lightning-fill"></i></div>
            <h3 class="text-lg font-semibold mb-2 dark:text-white">Fast</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Quick processing without quality loss.</p>
            </div>
        </div>
        </div>
    </section> -->

    <section class="py-12 bg-white text-gray-900" id="features">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-extrabold mb-4">PDFs Simplified</h2>
            <p class="max-w-2xl mx-auto text-lg mb-10 text-gray-600">
            Everything you need for your PDF files — fast, secure, and easy-to-use tools all in one place.
            </p>

            <div class="flex flex-col md:flex-row justify-center items-center space-y-16 md:space-y-0 md:space-x-24 text-center">
            
            <div>
                <div class="text-primary-500 text-4xl mb-4">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Powerful PDF Tools</h3>
                <p class="max-w-xs mx-auto text-gray-600 text-sm leading-relaxed">
                Merge, split, compress, and convert PDFs with just a few clicks.
                </p>
            </div>

            <div>
                <div class="text-primary-500 text-4xl mb-4 ">
                <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Rock-solid Security</h3>
                <p class="max-w-xs mx-auto text-gray-600 text-sm leading-relaxed">
                Files stay private and secure — all processing happens right in your browser.
                </p>
            </div>

            <div>
                <div class="text-primary-500 text-4xl mb-4 animate-spin-slow">
                <i class="bi bi-lightning-fill"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Lightning-fast Speed</h3>
                <p class="max-w-xs mx-auto text-gray-600 text-sm leading-relaxed">
                Experience rapid PDF processing without compromising quality.
                </p>
            </div>

            </div>
        </div>
    </section>

    <!-- Why Choose us Stack  -->
    <section class="py-8 gradient-bg" id="stats">
        <div class="max-w-7xl mx-auto p-8 sm:px-6 text-center">
            <h2 class="text-3xl font-bold mb-8 text-black">Why Choose Us?</h2>
            <div class="flex flex-col sm:flex-row justify-around space-y-10 sm:space-y-0 sm:space-x-10">

            <div class="flex flex-col items-center">
                <div class="text-4xl mb-3 text-primary-500">
                <i class="bi bi-speedometer2"></i>
                </div>
                <div class="text-4xl font-extrabold text-gray-500" data-target="99">0</div>
                <p class="uppercase tracking-widest mt-2 text-sm text-black">Fast Performance (%)</p>
            </div>

            <div class="flex flex-col items-center">
                <div class="text-4xl mb-3 text-primary-500">
                <i class="bi bi-file-earmark-arrow-down-fill"></i>
                </div>
                <div class="text-4xl font-extrabold text-gray-500" data-target="1000">0</div>
                <p class="uppercase tracking-widest mt-2 text-sm text-black">Output Generated</p>
            </div>

            <div class="flex flex-col items-center">
                <div class="text-4xl mb-3 text-primary-500">
                <i class="bi bi-people-fill"></i>
                </div>
                <div class="text-4xl font-extrabold text-gray-500" data-target="150">0</div>
                <p class="uppercase tracking-widest mt-2 text-sm text-black">User Served</p>
            </div>

            </div>
        </div>
    </section>

    <!-- About Us -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900" id="about">
        <div class="max-w-7xl mx-auto px-8 sm:px-6 text-center">
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    About Us
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    We're passionate about simplifying the way you work with PDFs. Whether it's editing, merging, or securing your documents, we build fast and user-friendly tools you can trust.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="about-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition transform hover:-translate-y-1">
                    <div class="text-4xl mb-4 text-primary-500"><i class="bi bi-people-fill"></i></div>
                    <h3 class="text-lg font-semibold mb-2 dark:text-white">Our Mission</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        To empower everyone with simple and secure PDF tools—free, fast, and accessible to all.
                    </p>
                </div>

                <div class="about-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition transform hover:-translate-y-1">
                    <div class="text-4xl mb-4 text-primary-500"><i class="bi bi-globe2"></i></div>
                    <h3 class="text-lg font-semibold mb-2 dark:text-white">Global Reach</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        Trusted by 100+ users, our platform makes it easy to modify documents with confidence.
                    </p>
                </div>

                <div class="about-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-card hover:shadow-card-hover transition transform hover:-translate-y-1">
                    <div class="text-4xl mb-4 text-primary-500"><i class="bi bi-heart-fill"></i></div>
                    <h3 class="text-lg font-semibold mb-2 dark:text-white">User Focused</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        Built with your needs in mind—not ads—we continuously improve our tools, to ensure they stay simple and user-friendly
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mt-6">
                <!-- Brand Column -->
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-lg font-bold text-primary-500">PDFThisThat</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Your complete PDF solution for all document needs.
                    </p>
                    <!-- <div class="flex space-x-4 text-gray-400 dark:text-gray-500">
                        <a href="#" aria-label="Twitter" class="hover:text-primary-500 transition text-lg"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="GitHub" class="hover:text-primary-500 transition text-lg"><i class="fab fa-github"></i></a>
                        <a href="#" aria-label="LinkedIn" class="hover:text-primary-500 transition text-lg"><i class="fab fa-linkedin"></i></a>
                    </div> -->
                </div>

                <!-- Tools Column -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">Tools</h3>
                    <ul class="space-y-2">
                        <li><a href="/jpg_to_pdf" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">Image to PDF</a></li>
                        <li><a href="/merge_pdf" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">Merge PDF</a></li>
                        
                    </ul>
                </div>

                <!-- Resources Column -->
                <div>
                    <!-- <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">Resources</h3> -->
                    <ul class="space-y-2">
                        <li><a href="/compress_pdf" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">Compress PDF</a></li>
                        <li><a href="/word_to_pdf" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">Word to PDF</a></li>
                        <li><a href="/edit_pdf" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">Edit PDF</a></li>
                    </ul>
                </div>

                <!-- Legal Column -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">Features</a></li>
                        <li><a href="#about" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">About Us</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-8 mb-2 border-t border-gray-200 dark:border-gray-800 text-center">
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                    &copy; 2025 PDFThisThat. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
  // Animated counter logic
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll("#stats [data-target]");
        
        counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / 200; // speed

            if(count < target){
            counter.innerText = Math.ceil(count + increment).toLocaleString();
            setTimeout(updateCount, 15);
            } else {
            counter.innerText = target.toLocaleString();
            }
        };
        updateCount();
        });
    });
    </script>
 
</body>

</html>