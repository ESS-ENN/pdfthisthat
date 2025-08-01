@extends('layouts.app')

@section('content')

<body class="h-full bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8 font-sans mb-6">

    <div class="text-center mb-4 mt-6">
        <div class="flex justify-center text-primary-500 text-4xl mb-2">
            <i class="bi bi-crop"></i>
        </div>
        <h4 class="text-3xl font-extrabold text-primary-600 dark:text-primary-400 mb-2">Crop PDF</h1>
        <p class="text-md text-gray-600 dark:text-gray-300">
           Crop and adjust your PDF document dimensions.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden p-6 w-full max-w-4xl mx-auto">
    <form method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="handleSubmit()">
        @csrf

        <!-- File Upload -->
        <div class="space-y-2" id="upload-section">
            <label class="block text-md font-medium text-gray-700 dark:text-gray-300">Choose PDF File</label>
            <div class="mt-1 relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-2xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30">
                <input 
                    type="file" 
                    name="pdf" 
                    id="pdf" 
                    accept=".pdf" 
                    required 
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                >
                <div class="flex flex-col items-center justify-center space-y-2">
                    <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                        <p>or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF (max 20MB)</p>
                    <p id="file-name" class="text-sm text-primary-500 mt-1 hidden"></p>
                </div>
            </div>
        </div>

        <!-- Preview and Crop Section (Initially hidden) -->
        <div id="preview-crop-section" class="hidden transition-all duration-300 ease-in-out space-y-6">
            <!-- PDF Preview Grid -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Page to Crop</label>
                <div id="pdf-preview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 max-h-72 overflow-y-auto p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <!-- Thumbnails will appear here -->
                </div>
            </div>

            <!-- Crop Area Container -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Crop Area</label>
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                    <div id="crop-area" class="mx-auto w-full md:w-1/2 border-2 border-dashed border-primary-400 dark:border-primary-500 rounded-lg overflow-hidden bg-white dark:bg-gray-800">
                        <!-- Cropper will be initialized here -->
                    </div>
                    <input type="hidden" id="selected-page" name="page_number">
                </div>
            </div>

            <!-- Apply to all toggle -->
            <div class="flex items-center space-x-3 pt-2">
                <input type="checkbox" id="apply-all" class="form-checkbox h-4 w-4 text-primary-600 rounded">
                <label for="apply-all" class="text-gray-700 dark:text-gray-300 text-sm">Apply crop to all pages</label>
            </div>

            <!-- Submit Button -->
            <button type="button" id="upload-crop"
                class="w-full flex items-center justify-center px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300 text-sm shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Crop & Download PDF
                </button>
            </div>
        </form>
    </div>
</body>

<!-- PDF Tools Group - Compact Version -->
<div class="max-w-7xl mx-auto px-2 sm:px-4 py-4 text-center mt-8">

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

<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

<!-- Cropper.js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>

    function handleSubmit() {
        const btn = document.getElementById("upload-crop");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }

    document.getElementById('pdf').addEventListener('change', function (e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            document.getElementById('file-name').textContent = fileName;
            document.getElementById('file-name').classList.remove('hidden');
            document.getElementById('upload-section').classList.add('hidden');
            document.getElementById('preview-crop-section').classList.remove('hidden');
        }
    });

    let cropper, typedArray, cropBoxData, currentPDF;

    const pdfInput = document.getElementById('pdf');
    const previewContainer = document.getElementById('pdf-preview');
    const cropArea = document.getElementById('crop-area');
    const applyAllToggle = document.getElementById('apply-all');
    const uploadCropBtn = document.getElementById('upload-crop');
    const selectedPageInput = document.getElementById('selected-page');

    pdfInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file && file.type === 'application/pdf') {
            const reader = new FileReader();
            reader.onload = function () {
                typedArray = new Uint8Array(reader.result);
                pdfjsLib.getDocument(typedArray).promise.then(pdf => {
                    currentPDF = pdf;
                    renderPDFPages(pdf);
                });
            };
            reader.readAsArrayBuffer(file);
        }
    });

    function renderPDFPages(pdf) {
        previewContainer.innerHTML = '';
        for (let i = 1; i <= pdf.numPages; i++) {
            pdf.getPage(i).then(page => {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                const scale = 1.5;
                const viewport = page.getViewport({ scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                page.render({ canvasContext: context, viewport }).promise.then(() => {
                    const img = document.createElement('img');
                    img.src = canvas.toDataURL();
                    img.dataset.page = i;
                    img.classList.add('cursor-pointer', 'w-full', 'max-w-[300px]');
                    img.addEventListener('click', () => selectPageForCropping(i, img.src));
                    previewContainer.appendChild(img);
                });
            });
        }
    }

    function selectPageForCropping(pageNumber, imageUrl) {
        selectedPageInput.value = pageNumber;
        cropArea.innerHTML = `<img id="crop-image" src="${imageUrl}" class="max-w-full">`;
        const cropImage = document.getElementById('crop-image');
        if (cropper) cropper.destroy();

        cropper = new Cropper(cropImage, {
            aspectRatio: NaN,
            viewMode: 1,
            autoCropArea: 0.8,
            ready: function () {
                cropBoxData = cropper.getData();
            },
            crop: function () {
                cropBoxData = cropper.getData();
            }
        });
    }

    uploadCropBtn.addEventListener('click', async () => {
        if (!cropper) {
            alert("Please select a page and crop first.");
            return;
        }

        const cropData = cropBoxData;
        const selectedPage = parseInt(selectedPageInput.value);
        const applyToAll = applyAllToggle.checked;
        const { jsPDF } = window.jspdf;

        let pdf;
        for (let i = 1; i <= currentPDF.numPages; i++) {
            const page = await currentPDF.getPage(i);
            const scale = 1.5;
            const viewport = page.getViewport({ scale });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            await page.render({ canvasContext: context, viewport }).promise;

            let imgData, width, height;

            if (applyToAll || i === selectedPage) {
                const croppedCanvas = document.createElement('canvas');
                const croppedContext = croppedCanvas.getContext('2d');
                croppedCanvas.width = cropData.width;
                croppedCanvas.height = cropData.height;

                croppedContext.drawImage(
                    canvas,
                    cropData.x, cropData.y, cropData.width, cropData.height,
                    0, 0, cropData.width, cropData.height
                );

                imgData = croppedCanvas.toDataURL('image/jpeg', 1.0);
                width = cropData.width;
                height = cropData.height;
            } else {
                imgData = canvas.toDataURL('image/jpeg', 1.0);
                width = canvas.width;
                height = canvas.height;
            }

            const orientation = width > height ? 'landscape' : 'portrait';

            if (!pdf) {
                pdf = new jsPDF({ orientation, unit: 'px', format: [width, height] });
            } else {
                pdf.addPage([width, height], orientation);
            }

            pdf.addImage(imgData, 'JPEG', 0, 0, width, height);
        }

        // Save to device
        pdf.save('cropped.pdf');

        // Upload to server
        const blob = pdf.output('blob');
        const formData = new FormData();
        const originalFile = pdfInput.files[0];
        formData.append('cropped_pdf', blob, 'cropped.pdf');
        formData.append('pdf_file', originalFile);

        try {
            const res = await fetch('/upload_cropped_pdf', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const result = await res.json();
            console.log('Upload response:', result);

            if (result.success) {
                window.location.href = '/success_crop_pdf';
            } else {
                alert('Upload failed: ' + (result.error || 'Unknown error'));
            }
        } catch (err) {
            console.error('Upload error:', err);
            alert('Something went wrong:\n' + err.message);
        }
    });


    
</script>

@endsection