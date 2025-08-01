@extends('layouts.app')

@section('content')
<style>
    #pdf-canvas {
    pointer-events: auto;
    background: transparent;
    z-index: 10;
    }
    #pdf-iframe {
    z-index: 1;
    }
    /* Error Toast */
    .pdf-error-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        background: #ffebee;
        color: #c62828;
        border-left: 4px solid #c62828;
        border-radius: 4px;
        padding: 15px;
        display: flex;
        align-items: center;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .pdf-error-toast.fade-out {
        transform: translateX(100%);
        opacity: 0;
    }

    .toast-icon {
        font-weight: bold;
        margin-right: 12px;
    }

    .toast-close {
        background: none;
        border: none;
        color: inherit;
        font-size: 20px;
        margin-left: 15px;
        cursor: pointer;
        padding: 0;
    }

    /* Button Loading State */
    #download-btn[disabled] {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .spinner-border {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        vertical-align: text-bottom;
        border: 0.2em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
        margin-right: 0.5rem;
    }

    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }

</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<body class="h-full bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8 font-sans ">

        <div class="text-center mb-4 mt-6">
            <div class="flex justify-center text-primary-500 text-4xl mb-2">
                <i class="bi bi-brush"></i>
            </div>
            <h4 class="text-3xl font-extrabold text-primary-600 dark:text-primary-400 mb-2">PDF Editor</h1>
            <p class="text-md text-gray-600 dark:text-gray-300">
                Upload your PDF to start editing with various tools.
            </p>
        </div>

        <!-- Page Content Container -->
        <div class="w-8xl mx-auto px-4 py-8">

            <!-- Combined Tools + PDF Editor Panel -->
            <div class="bg-white rounded-2xl p-5 shadow-lg border border-gray-100 space-y-5">

                <!-- Tools Panel -->
                <div>

                    <h2 class="text-xl font-bold text-blue-600 mb-4 flex items-center gap-2 mb-2">
                        <i class="bi bi-tools"></i>
                        Editing Tools

                        <button id="download-btn" class="ml-auto bg-blue-500 text-white p-2.5 rounded hover:bg-blue-600 text-sm flex items-center gap-1">
                            <i class="bi bi-download"></i>
                            Download
                        </button>
                    </h2>

                    <!-- Tool Buttons -  color scheme -->
                    <div class="flex flex-wrap gap-2 mb-5">
                        <button id="select-tool" class="tool-button active px-3 py-1.5 text-sm rounded-lg border border-blue-100 bg-blue-50 hover:bg-blue-100 text-blue-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-cursor"></i>
                            Select
                        </button>
                        <button id="text-tool" class="tool-button px-3 py-1.5 text-sm rounded-lg border border-gray-200 bg-white hover:bg-blue-50 text-gray-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-fonts"></i>
                            Text
                        </button>
                        <button id="rect-tool" class="tool-button px-3 py-1.5 text-sm rounded-lg border border-gray-200 bg-white hover:bg-blue-50 text-gray-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-square"></i>
                            Rectangle
                        </button>
                        <button id="circle-tool" class="tool-button px-3 py-1.5 text-sm rounded-lg border border-gray-200 bg-white hover:bg-blue-50 text-gray-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-circle"></i>
                            Circle
                        </button>
                        <button id="line-tool" class="tool-button px-3 py-1.5 text-sm rounded-lg border border-gray-200 bg-white hover:bg-blue-50 text-gray-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-slash-lg"></i>
                            Line
                        </button>
                        <button id="brush-tool" class="tool-button px-3 py-1.5 text-sm rounded-lg border border-gray-200 bg-white hover:bg-blue-50 text-gray-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-brush"></i>
                            Brush
                        </button>
                        <button id="eraser-tool" class="tool-button px-3 py-1.5 text-sm rounded-lg border border-gray-200 bg-white hover:bg-blue-50 text-gray-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-eraser"></i>
                            Eraser
                        </button>
                        <button id="image-tool" class="tool-button px-3 py-1.5 text-sm rounded-lg border border-gray-200 bg-white hover:bg-blue-50 text-gray-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-image"></i>
                            Image
                        </button>
                        <button id="clear-all" class="tool-button px-3 py-1.5 text-sm rounded-lg border border-gray-200 bg-white hover:bg-blue-50 text-gray-700 shadow-sm transition-all duration-200 flex items-center gap-1">
                            <i class="bi bi-trash"></i>
                            Delete all
                        </button>
                    </div>

                    <!-- Tool Options  colors -->
                    <div class="flex flex-wrap gap-4 items-center bg-blue-50 p-3 rounded-lg">
                        <!-- Color Picker -->
                        <div class="flex items-center gap-2">
                            <label for="color-picker" class="text-sm font-medium text-blue-600">Color</label>
                            <div class="relative">
                                <input type="color" id="color-picker" value="#000000" class="h-7 w-7 rounded-md border-2 border-white shadow-md cursor-pointer ring-2 ring-blue-300">
                                <div class="absolute inset-0 rounded-md pointer-events-none shadow-inner"></div>
                            </div>
                        </div>

                        <!-- Brush Size -->
                        <div class="flex items-center gap-2">
                            <label for="brush-size" class="text-sm font-medium text-blue-600">Brush Size</label>
                            <input type="range" id="brush-size" min="1" max="50" value="5" class="w-24 accent-blue-500">
                            <span id="brush-size-value" class="text-sm text-blue-600 font-medium">5px</span>
                        </div>

                        <!-- Font Size -->
                        <div class="flex items-center gap-2">
                            <label for="font-size" class="text-sm font-medium text-blue-600">Font</label>
                            <div class="relative">
                                <input type="number" id="font-size" min="8" max="72" value="16" class="w-16 px-2 py-1 border border-blue-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white text-blue-700">
                            </div>
                        </div>
                        
                    </div>

                </div>

                <!-- pdf preview  -->
                <div id="pdf-container" class="flex flex-col justify-center space-y-8 overflow-x-auto py-4">
                    <?php foreach ($pdfImages as $index => $imagePath): ?>
                        <div class="page-container flex-shrink-0 w-[800px] mx-auto">                            
                            <canvas id="canvas-<?= $index ?>" class="w-full border rounded-md shadow-md mx-auto pdf-canvas"></canvas>
                        </div>
                    <?php endforeach; ?>
                </div>


            </div>
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
                <a href="/merge-pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 overflow-hidden">
                    <div class="text-2xl mb-2 text-primary-500 group-hover:text-black">
                        <i class="bi bi-filetype-pdf"></i>
                    </div>
                    <h3 class="text-lg font-semibold group-hover:text-primary-500 dark:text-white">Merge PDF</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1 text-xs">Combine multiple PDFs into one document.</p>
                    <div class="mt-3 text-xs text-primary-500 font-medium flex items-center opacity-0 group-hover:opacity-100 transition">
                        Try now <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </a>

                <a href="/compress-pdf" class="tool-card group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 overflow-hidden">
                    <div class="text-2xl mb-2 text-primary-500 group-hover:text-black">
                        <i class="bi bi-crop"></i>
                    </div>
                    <h3 class="text-lg font-semibold group-hover:text-primary-500 dark:text-white">Crop PDF</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1 text-xs">Crop and adjust your PDF document dimensions.</p>
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


<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>

<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>

<!-- fabric.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const canvases = [];
    const images = <?= json_encode($pdfImages) ?>;
    let activeCanvas = null;
    let currentTool = 'select';
    let currentColor = '#000000';
    let currentFontSize = 20;
    let currentBrushSize = 5;
    let startX, startY;
    let currentLine, currentRect, currentCircle;

    // Initialize canvases
    images.forEach((image, index) => {
        const canvasEl = document.getElementById(`canvas-${index}`);
        const canvas = new fabric.Canvas(`canvas-${index}`, {
            selection: true,
            preserveObjectStacking: true,
            backgroundColor: '#ffffff'
        });

        // Set active canvas when clicked
        canvasEl.addEventListener('click', () => {
            setActiveCanvas(canvas);
        });

        fabric.Image.fromURL(image, function(imgObj) {
            // Calculate scale factor to fit canvas width (800px)
            const maxWidth = 800;
            const scaleFactor = maxWidth / imgObj.width;
            
            imgObj.set({
                scaleX: scaleFactor,
                scaleY: scaleFactor,
                selectable: true,
                hasControls: true,
                lockUniScaling: false
            });

            canvas.setWidth(imgObj.width * scaleFactor);
            canvas.setHeight(imgObj.height * scaleFactor);
            
            canvas.setBackgroundImage(imgObj, canvas.renderAll.bind(canvas), {
                originX: 'left',
                originY: 'top',
                left: 0,
                top: 0,
                selectable: true
            });
            
            // Enable moving and resizing of the background image
            canvas.backgroundImage.set({
                selectable: true,
                hasControls: true,
                lockMovementX: false,
                lockMovementY: false,
                lockScalingX: false,
                lockScalingY: false
            });
            
            canvas.renderAll();
        });

        bindCanvasEvents(canvas);
        canvases.push(canvas);

        if (index === 0) setActiveCanvas(canvas); // Set first canvas as default
    });

    function setActiveCanvas(canvas) {
        activeCanvas = canvas;
        // Update UI to show which canvas is active
        document.querySelectorAll('.page-container').forEach(container => {
            container.classList.remove('border-blue-500');
        });
        canvas.wrapperEl.closest('.page-container').classList.add('border-blue-500');
    }

    function setActiveTool(tool) {
        currentTool = tool;
        canvases.forEach(canvas => {
            canvas.isDrawingMode = false;
            canvas.selection = (tool === 'select');
            canvas.defaultCursor = (tool === 'select') ? 'default' : 'crosshair';
        });

        if (activeCanvas) {
            if (tool === 'brush' || tool === 'eraser') {
                activeCanvas.isDrawingMode = true;
                activeCanvas.freeDrawingBrush.width = currentBrushSize;
                activeCanvas.freeDrawingBrush.color = (tool === 'eraser') ? '#ffffff' : currentColor;
            }
        }

        document.querySelectorAll('.tool-button').forEach(btn => btn.classList.remove('active'));
        const toolBtn = document.getElementById(`${tool}-tool`);
        if (toolBtn) toolBtn.classList.add('active');
    }

    function bindCanvasEvents(canvas) {
        canvas.on('mouse:down', function (options) {
            if (canvas !== activeCanvas) return;

            const pointer = canvas.getPointer(options.e);

            if (currentTool === 'text' && options.target === null) {
                const text = new fabric.IText('Click to type', {
                    left: pointer.x,
                    top: pointer.y,
                    fontFamily: 'Arial',
                    fill: currentColor,
                    fontSize: currentFontSize,
                    selectable: true,
                    hasControls: true
                });
                canvas.add(text);
                canvas.setActiveObject(text);
                text.enterEditing();
                setActiveTool('select');
            } else if (currentTool === 'line' && !currentLine) {
                startX = pointer.x;
                startY = pointer.y;
                currentLine = new fabric.Line([startX, startY, startX, startY], {
                    stroke: currentColor,
                    strokeWidth: currentBrushSize,
                    selectable: true,
                    hasControls: true
                });
                canvas.add(currentLine);
            } else if (currentTool === 'rect' && !currentRect) {
                startX = pointer.x;
                startY = pointer.y;
                currentRect = new fabric.Rect({
                    left: startX,
                    top: startY,
                    fill: 'transparent',
                    stroke: currentColor,
                    strokeWidth: currentBrushSize,
                    width: 1,
                    height: 1,
                    selectable: true,
                    hasControls: true
                });
                canvas.add(currentRect);
            } else if (currentTool === 'circle' && !currentCircle) {
                startX = pointer.x;
                startY = pointer.y;
                currentCircle = new fabric.Circle({
                    left: startX,
                    top: startY,
                    fill: 'transparent',
                    stroke: currentColor,
                    strokeWidth: currentBrushSize,
                    radius: 1,
                    selectable: true,
                    hasControls: true
                });
                canvas.add(currentCircle);
            }
        });

        canvas.on('mouse:move', function (options) {
            if (canvas !== activeCanvas) return;

            const pointer = canvas.getPointer(options.e);
            if (currentTool === 'line' && currentLine) {
                currentLine.set({ x2: pointer.x, y2: pointer.y });
                canvas.renderAll();
            } else if (currentTool === 'rect' && currentRect) {
                currentRect.set({
                    width: pointer.x - startX,
                    height: pointer.y - startY
                });
                canvas.renderAll();
            } else if (currentTool === 'circle' && currentCircle) {
                const radius = Math.sqrt(Math.pow(pointer.x - startX, 2) + Math.pow(pointer.y - startY, 2));
                currentCircle.set({ radius });
                canvas.renderAll();
            }
        });

        canvas.on('mouse:up', function () {
            if (canvas !== activeCanvas) return;

            if (currentLine) {
                currentLine.set({ selectable: true });
                currentLine = null;
            }
            if (currentRect) {
                currentRect.set({ selectable: true });
                currentRect = null;
            }
            if (currentCircle) {
                currentCircle.set({ selectable: true });
                currentCircle = null;
            }
        });
    }

    // Tool buttons
    document.getElementById('select-tool').addEventListener('click', () => setActiveTool('select'));
    document.getElementById('text-tool').addEventListener('click', () => setActiveTool('text'));
    document.getElementById('rect-tool').addEventListener('click', () => setActiveTool('rect'));
    document.getElementById('circle-tool').addEventListener('click', () => setActiveTool('circle'));
    document.getElementById('line-tool').addEventListener('click', () => setActiveTool('line'));
    document.getElementById('brush-tool').addEventListener('click', () => setActiveTool('brush'));
    document.getElementById('eraser-tool').addEventListener('click', () => setActiveTool('eraser'));

        // Image upload to active canvas
    document.getElementById('image-tool').addEventListener('click', () => {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = function (event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function (e) {
                fabric.Image.fromURL(e.target.result, function(img) {
                    // Calculate scaling to fit 100×100 while maintaining aspect ratio
                    const maxDimension = 100;
                    let scale = 1;
                    
                    if (img.width > img.height) {
                        scale = maxDimension / img.width;
                    } else {
                        scale = maxDimension / img.height;
                    }
                    
                    img.set({
                        left: 100,
                        top: 100,
                        scaleX: scale,
                        scaleY: scale,
                        selectable: true,
                        hasControls: true,
                        lockUniScaling: false,
                        lockScalingFlip: true,
                        cornerSize: 10,
                        transparentCorners: false,
                        // Add custom property to identify this as an image
                        isCustomImage: true
                    });
                    
                    if (activeCanvas) {
                        activeCanvas.add(img);
                        activeCanvas.setActiveObject(img);
                        activeCanvas.renderAll();
                        activeCanvas.viewportCenterObject(img);
                    }
                });
            };
            reader.readAsDataURL(file);
        };
        input.click();
    });

    // Function to prepare canvas for PDF export (call this before exporting)
    function prepareCanvasForPDFExport() {
        if (!activeCanvas) return;
        
        activeCanvas.forEachObject(function(obj) {
            if (obj.isCustomImage) {
                // Hide controls and selection
                obj.selectable = false;
                obj.hasControls = false;
                obj.hoverCursor = 'default';
            }
        });
        activeCanvas.discardActiveObject();
        activeCanvas.renderAll();
    }

    // Function to restore canvas controls after PDF export (call this after exporting)
    function restoreCanvasControls() {
        if (!activeCanvas) return;
        
        activeCanvas.forEachObject(function(obj) {
            if (obj.isCustomImage) {
                // Restore controls and selection
                obj.selectable = true;
                obj.hasControls = true;
                obj.hoverCursor = 'move';
            }
        });
        activeCanvas.renderAll();
    }

    // Brush size change
    document.getElementById('brush-size').addEventListener('input', function (event) {
        currentBrushSize = parseInt(event.target.value);
        document.getElementById('brush-size-value').innerText = `${currentBrushSize}px`;
        if (activeCanvas && activeCanvas.isDrawingMode) {
            activeCanvas.freeDrawingBrush.width = currentBrushSize;
        }
    });

    // Color picker
    document.getElementById('color-picker').addEventListener('input', function (event) {
        currentColor = event.target.value;
        if (activeCanvas && activeCanvas.isDrawingMode && currentTool === 'brush') {
            activeCanvas.freeDrawingBrush.color = currentColor;
        }
    });

    // Font size
    document.getElementById('font-size').addEventListener('input', function (event) {
        currentFontSize = parseInt(event.target.value);
    });

    // Clear all button
    document.getElementById('clear-all').addEventListener('click', function() {
        if (activeCanvas) {
            // Keep the background image but remove all other objects
            const bgImage = activeCanvas.backgroundImage;
            activeCanvas.clear();
            if (bgImage) {
                activeCanvas.setBackgroundImage(bgImage, activeCanvas.renderAll.bind(activeCanvas));
            }
            activeCanvas.renderAll();
        }
    });

    // document.getElementById('download-btn').addEventListener('click', async function () {
    //     const canvases = Array.from(document.querySelectorAll('canvas'));
    //     const jsPDF = window.jspdf.jsPDF;
    //     const A4_WIDTH = 595.28;
    //     const A4_HEIGHT = 841.89;

    //     const pdf = new jsPDF({
    //         orientation: 'portrait',
    //         unit: 'pt',
    //         format: 'a4'
    //     });

    //     for (let i = 0; i < canvases.length; i++) {
    //         const canvas = canvases[i];

    //         // Skip blank canvases to avoid extra black pages
    //         if (isCanvasCompletelyBlank(canvas)) continue;
    //         const ctx = canvas.getContext('2d');
    //         ctx.save();
    //         ctx.globalCompositeOperation = 'destination-over';
    //         ctx.fillStyle = '#FFFFFF';
    //         ctx.fillRect(0, 0, canvas.width, canvas.height);
    //         ctx.restore();

    //         const imgData = canvas.toDataURL('image/jpeg', 1.0);

    //         // Calculate height keeping A4 width aspect ratio
    //         const aspectRatio = canvas.height / canvas.width;
    //         const pageHeight = A4_WIDTH * aspectRatio;

    //         if (i > 0) pdf.addPage();

    //         // Ensure image height fits within A4
    //         const finalHeight = pageHeight > A4_HEIGHT ? A4_HEIGHT : pageHeight;

    //         pdf.addImage(imgData, 'JPEG', 0, 0, A4_WIDTH, finalHeight);
    //     }

    //     const pdfBlob = pdf.output('blob');
    //     const filename = `edited_pdf_${Date.now()}.pdf`;
    //     triggerDownloadFromBlob(pdfBlob, filename);

    //     const formData = new FormData();
    //     formData.append('pdf', pdfBlob, filename);

    //     const response = await fetch('/upload_edited_pdf', {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': getCsrfToken()
    //         },
    //         body: formData
    //     });

    //     const data = await response.json();

    //     if (data.success) {
    //         window.location.href = `/success_edit_pdf`;
    //     } else {
    //         showErrorToast('Failed to upload edited PDF!');
    //     }
    // });

    // function isCanvasCompletelyBlank(canvas) {
    //     if (!canvas || canvas.width === 0 || canvas.height === 0) return true;

    //     const tempCanvas = document.createElement('canvas');
    //     tempCanvas.width = canvas.width;
    //     tempCanvas.height = canvas.height;
    //     const tempCtx = tempCanvas.getContext('2d');
    //     tempCtx.drawImage(canvas, 0, 0);

    //     const imageData = tempCtx.getImageData(0, 0, tempCanvas.width, tempCanvas.height).data;
    //     return !imageData.some((channel, index) => {
    //         // Check for any non-transparent pixel
    //         return (index + 1) % 4 !== 0 && channel !== 255; // Ignore alpha
    //     });
    // }


    document.getElementById('download-btn').addEventListener('click', async function () {
        const canvases = Array.from(document.querySelectorAll('canvas'));
        const jsPDF = window.jspdf.jsPDF;
        const A4_WIDTH = 595.28;
        const A4_HEIGHT = 841.89;

        const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'pt',
            format: 'a4'
        });


        let addedFirstPage = false;

        for (let i = 0; i < canvases.length; i++) {
            const canvas = canvases[i];

            if (isCanvasCompletelyBlank(canvas)) {
                continue; // skip blank canvases
            }

            // Add white background behind canvas drawing
            const ctx = canvas.getContext('2d');
            ctx.save();
            ctx.globalCompositeOperation = 'destination-over';
            ctx.fillStyle = '#FFFFFF';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.restore();

            const imgData = canvas.toDataURL('image/jpeg', 1.0);

            const imgWidth = canvas.width;
            const imgHeight = canvas.height;

            const maxWidth = A4_WIDTH;
            const maxHeight = A4_HEIGHT;

            let renderWidth = maxWidth;
            let renderHeight = imgHeight * (maxWidth / imgWidth);

            if (renderHeight > maxHeight) {
                renderHeight = maxHeight;
                renderWidth = imgWidth * (maxHeight / imgHeight);
            }

            if (addedFirstPage) {
                pdf.addPage(); // Add page **before** adding image, but skip for first image
            } else {
                addedFirstPage = true; // Mark that first page is used
            }

            pdf.addImage(imgData, 'JPEG', 0, 0, renderWidth, renderHeight);
        }


        if (!addedFirstPage) {
            // No pages to save, show error or just return
            showErrorToast('No content to export!');
            return;
        }

        const pdfBlob = pdf.output('blob');
        const filename = `edited_pdf_${Date.now()}.pdf`;
        triggerDownloadFromBlob(pdfBlob, filename);

        const formData = new FormData();
        formData.append('pdf', pdfBlob, filename);

        const response = await fetch('/upload_edited_pdf', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = `/success_edit_pdf`;
        } else {
            showErrorToast('Failed to upload edited PDF!');
        }
    });

    function isCanvasCompletelyBlank(canvas) {
        if (!canvas || canvas.width === 0 || canvas.height === 0) return true;

        const ctx = canvas.getContext('2d');
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;

        for (let i = 0; i < imageData.length; i += 4) {
            const r = imageData[i];
            const g = imageData[i + 1];
            const b = imageData[i + 2];
            const a = imageData[i + 3];
            // Pixel not white and fully opaque means canvas is not blank
            if (!(r === 255 && g === 255 && b === 255 && a === 255)) {
                return false;
            }
        }
        return true;
    }

    // Helper to get CSRF token safely
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || null;
    }

    // Download PDF from blob
    function triggerDownloadFromBlob(blob, filename) {
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename.replace(/[^a-z0-9._-]/gi, '_');
        // window.open('/success_edit_pdf', '_blank');
        window.location.href = '/success_edit_pdf';
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        
        // Cleanup
        setTimeout(() => {
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }, 100);
    }

    // Improved error toast with better accessibility
    function showErrorToast(message) {
    // Remove existing toasts
    document.querySelectorAll('.pdf-error-toast').forEach(t => {
        t.classList.add('fade-out');
        setTimeout(() => t.remove(), 300);
    });

    const toast = document.createElement('div');
    toast.className = 'pdf-error-toast';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.tabIndex = -1; // Make it focusable for accessibility

    toast.innerHTML = `
        <div class="toast-icon" aria-hidden="true">⚠️</div>
        <div class="toast-message">${escapeHtml(message)}</div>
        <button class="toast-close" aria-label="Close error message">&times;</button>
    `;

    document.body.appendChild(toast);
    
    // Focus the toast for screen readers
    setTimeout(() => toast.focus(), 100);

    const hideTimeout = setTimeout(() => fadeOutAndRemove(toast), 5000);

    toast.querySelector('.toast-close').addEventListener('click', () => {
        clearTimeout(hideTimeout);
        fadeOutAndRemove(toast);
    });

    // Close on Escape key
    toast.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
        clearTimeout(hideTimeout);
        fadeOutAndRemove(toast);
        }
    });

    function fadeOutAndRemove(el) {
        el.classList.add('fade-out');
        setTimeout(() => el.remove(), 300);
    }
    }

    // Basic HTML escaping for toast messages
    function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    // Default tool
    setActiveTool('select');

});

</script>


@endsection