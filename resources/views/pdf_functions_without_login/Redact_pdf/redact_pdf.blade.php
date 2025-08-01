@extends('layouts.app')

@section('content')

<main class="flex-grow  dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto">

    <!-- Heading -->
    <div class="text-center mb-6">
      <div class="flex justify-center text-primary-500 text-4xl mb-2">
        <i class="bi bi-card-heading"></i>
      </div>
      <h4 class="text-3xl font-bold text-primary-600 dark:text-primary-400">Redact PDF</h1>
      <p class="text-sm text-gray-600 dark:text-gray-300">Securely hide sensitive content in your PDF.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden p-6 space-y-6">

      <!-- Message area -->
      <div id="message" class="hidden p-3 border rounded text-sm"></div>

      <!-- Form -->
      <form id="redactForm" class="space-y-5" enctype="multipart/form-data" method="POST" action="#" onsubmit="handleSubmit()">
        @csrf

        <!-- Upload -->
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1 text-sm">Upload PDF File:</label>
          <div id="drop-zone" class="relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-xl p-8 text-center bg-gray-50/40 dark:bg-gray-700/30 hover:border-primary-500 transition cursor-pointer">
            <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
            <div class="flex flex-col items-center space-y-2">
              <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
              </svg>
              <p class="text-sm text-primary-600 dark:text-primary-400 font-medium">Click or drag & drop</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">PDF only, max 20MB</p>
            </div>
          </div>
          <p id="file-name" class="mt-2 text-center text-primary-500 text-sm hidden"></p>
        </div>

        <!-- Redaction Tools -->
        <div id="redaction-tools" class="hidden border border-gray-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800 rounded-lg">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Redaction Tools</label>
          <div class="flex items-center gap-3 flex-wrap">

            <!-- Draw -->
            <button type="button" id="draw-btn"
                    class="flex items-center gap-1 px-3 py-1.5 bg-primary-600 text-white text-xs font-medium rounded-md hover:bg-primary-700 focus:outline-none focus:ring-1 focus:ring-primary-400 shadow-sm">
              <i class="fas fa-pencil-alt text-xs"></i> Redact
            </button>

            <!-- Clear -->
            <button type="button" id="clear-btn"
                    class="flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-red-400 shadow-sm">
              <i class="fas fa-trash-alt text-xs"></i> Clear
            </button>

            <!-- Reset -->
            <button type="button" id="reset-btn" title="Reset Changes" class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-md p-2 text-sm flex items-center justify-center transition">
              <i class="fas fa-undo-alt"></i>Reset
            </button>

            <!-- Color Picker -->
            <div class="flex items-center gap-2 text-sm">
              <label for="redaction-color" class="text-gray-700 dark:text-gray-300">Color:</label>
              <input type="color" id="redaction-color" value="#000000" class="w-8 h-8 rounded border border-gray-300 dark:border-gray-600 bg-transparent cursor-pointer">
            </div>
          </div>

          <!-- Instruction -->
            <div class="bg-yellow-50 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 text-xs p-2 rounded border border-yellow-300 dark:border-yellow-600 flex items-start gap-1 mt-4">
                <ul>
                  <li><i class="bi bi-dot"></i><span>Click and drag to create redaction boxes.</span></li>
                  <li><i class="bi bi-dot"></i><span>Right click on the redaction boxes to remove it.</span></li>
                </ul>
            </div> 
        </div>
        
        <!-- Preview -->
        <div id="pdf_preview" class="hidden border border-gray-300 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-900">
          <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">PDF Preview & Redaction</label>
          <div id="pdf_preview_container" class="space-y-3 flex flex-col items-center overflow-auto max-h-[60vh]"></div>
        </div>

        <!-- Generate Button -->
        <div id="action-buttons" class="hidden">
          <button type="button" id="process-btn" class="w-full flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition text-sm">
            <i class="fas fa-file-pdf mr-2"></i>
            Generate Redacted PDF
          </button>
        </div>

        <input type="hidden" name="redaction_boxes" id="redaction_boxes_data" />
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>

    function handleSubmit() {
        const btn = document.getElementById("process-btn");
        btn.disabled = true;
        btn.textContent = "Processing...";
        btn.classList.add("opacity-50", "cursor-not-allowed");
        // Allow the form to continue submitting normally
    }
      const { jsPDF } = window.jspdf;

      // Set PDF.js worker path
      pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.worker.min.js';

      let pdfDoc = null;
      let redactionMode = false;
      let isDrawing = false;
      let startX, startY;
      let redactionBoxes = {};
      let boxCounter = 0;
      let currentBox = null;
      let originalCanvasData = {}; // Store original canvas data for reset
      let canvasScaleFactors = {}; // Store scale factors for each canvas

      document.addEventListener('DOMContentLoaded', () => {
        const pdfInput = document.getElementById('pdf_file');
        const fileNameDisplay = document.getElementById('file-name');
        const pdfPreviewContainer = document.getElementById('pdf_preview_container');
        const pdfPreviewSection = document.getElementById('pdf_preview');
        const drawBtn = document.getElementById('draw-btn');
        const clearBtn = document.getElementById('clear-btn');
        const resetBtn = document.getElementById('reset-btn');
        const redactionTools = document.getElementById('redaction-tools');
        const actionButtons = document.getElementById('action-buttons');
        const redactionColor = document.getElementById('redaction-color');
        const redactForm = document.getElementById('redactForm');
        const redactionBoxesDataInput = document.getElementById('redaction_boxes_data');
        const messageDiv = document.getElementById('message');
        const processBtn = document.getElementById('process-btn');

        resetUI();

        pdfInput.addEventListener('change', e => {
          if (!e.target.files.length) return;

          clearMessage();
          resetUI();

          const file = e.target.files[0];
          fileNameDisplay.textContent = `Selected file: ${file.name}`;
          fileNameDisplay.classList.remove('hidden');

          if (file.type !== 'application/pdf') {
            showMessage('Please upload a valid PDF file.', 'error');
            resetUI(true);
            return;
          }

          const maxSizeMB = 20;
          const maxSizeBytes = maxSizeMB * 1024 * 1024;
          if (file.size > maxSizeBytes) {
            showMessage(`File size exceeds ${maxSizeMB}MB limit.`, 'error');
            resetUI(true);
            return;
          }

          const fileReader = new FileReader();
          fileReader.onload = () => {
            const pdfData = new Uint8Array(fileReader.result);
            pdfjsLib.getDocument(pdfData).promise.then(doc => {
              pdfDoc = doc;
              pdfPreviewSection.classList.remove('hidden');
              redactionTools.classList.remove('hidden');
              actionButtons.classList.remove('hidden');
              
              // Clear previous preview
              pdfPreviewContainer.innerHTML = '';
              originalCanvasData = {};
              canvasScaleFactors = {};
              
              // Render all pages
              for (let i = 1; i <= pdfDoc.numPages; i++) {
                renderPage(i, pdfDoc);
              }
            }).catch(err => {
              console.error('PDF error:', err);
              showMessage('Error reading PDF file. Please try again.', 'error');
              resetUI(true);
            });
          };
          fileReader.readAsArrayBuffer(file);
        });

        drawBtn.addEventListener('click', () => {
          redactionMode = !redactionMode;
          drawBtn.classList.toggle('bg-primary-600', redactionMode);
          drawBtn.classList.toggle('bg-primary-500', !redactionMode);
        });

        clearBtn.addEventListener('click', () => {
          redactionBoxes = {};
          boxCounter = 0;
          redrawBoxes();
        });

        resetBtn.addEventListener('click', () => {
          resetUI();
        });

        redactionColor.addEventListener('input', e => {
          if (currentBox) {
            currentBox.color = e.target.value;
            redrawBoxes();
          }
        });

        processBtn.addEventListener('click', generateRedactedPDF);

        function renderPage(pageNum, pdfDoc) {
          pdfDoc.getPage(pageNum).then(page => {
            // Calculate viewport with proper scaling for display
            const viewport = page.getViewport({ scale: 1.0 });
            
            // Calculate scale to fit container width (max 800px)
            const containerWidth = 800;
            const scale = containerWidth / viewport.width;
            const scaledViewport = page.getViewport({ scale: scale });
            
            // Create a canvas for rendering the page
            const canvas = document.createElement('canvas');
            canvas.dataset.page = pageNum;
            const context = canvas.getContext('2d');

            // Set the canvas display size
            canvas.style.width = `${scaledViewport.width}px`;
            canvas.style.height = `${scaledViewport.height}px`;
            
            // Set the canvas render dimensions (for high DPI)
            const outputScale = window.devicePixelRatio || 1;
            canvas.width = Math.floor(scaledViewport.width * outputScale);
            canvas.height = Math.floor(scaledViewport.height * outputScale);
            
            // Store the scale factor for coordinate conversion
            canvasScaleFactors[pageNum] = {
              displayToActual: outputScale,
              actualToDisplay: 1 / outputScale,
              viewportScale: scale
            };

            // Append the canvas to the preview container
            pdfPreviewContainer.appendChild(canvas);

            // Render the page content into the canvas
            const renderContext = {
              canvasContext: context,
              viewport: scaledViewport,
              transform: [outputScale, 0, 0, outputScale, 0, 0]
            };

            page.render(renderContext).promise.then(() => {
              // Store original canvas data for reset functionality
              originalCanvasData[pageNum] = canvas.toDataURL('image/png');
              
              // Add mouse event listeners to allow drawing
              canvas.addEventListener('mousedown', startDrawing);
              canvas.addEventListener('mousemove', draw);
              canvas.addEventListener('mouseup', stopDrawing);
              canvas.addEventListener('mouseout', stopDrawing);
              canvas.addEventListener('contextmenu', handleRightClick);

            });
          });
        }

        function startDrawing(e) {
          if (!redactionMode) return;

          const canvas = e.target;
          const pageNum = parseInt(canvas.dataset.page);
          const scaleInfo = canvasScaleFactors[pageNum];
          
          // Get mouse position relative to canvas
          const rect = canvas.getBoundingClientRect();
          const x = (e.clientX - rect.left) * scaleInfo.displayToActual;
          const y = (e.clientY - rect.top) * scaleInfo.displayToActual;
          
          startX = x;
          startY = y;
          isDrawing = true;

          currentBox = { 
            id: boxCounter++, 
            pageNum: pageNum, 
            x: startX, 
            y: startY, 
            width: 0, 
            height: 0, 
            color: redactionColor.value 
          };
        }

        function draw(e) {
          if (!isDrawing || !currentBox) return;

          const canvas = e.target;
          const pageNum = parseInt(canvas.dataset.page);
          const scaleInfo = canvasScaleFactors[pageNum];
          
          // Get current mouse position
          const rect = canvas.getBoundingClientRect();
          const currentX = (e.clientX - rect.left) * scaleInfo.displayToActual;
          const currentY = (e.clientY - rect.top) * scaleInfo.displayToActual;

          currentBox.width = currentX - currentBox.x;
          currentBox.height = currentY - currentBox.y;

          redrawBoxes();
        }

        function stopDrawing() {
          if (!currentBox) return;

          // Normalize box coordinates (width/height can be negative)
          if (currentBox.width < 0) {
            currentBox.x += currentBox.width;
            currentBox.width = Math.abs(currentBox.width);
          }
          if (currentBox.height < 0) {
            currentBox.y += currentBox.height;
            currentBox.height = Math.abs(currentBox.height);
          }

          // Only keep boxes with reasonable size
          if (currentBox.width > 5 && currentBox.height > 5) {
            if (!redactionBoxes[currentBox.pageNum]) {
              redactionBoxes[currentBox.pageNum] = [];
            }
            redactionBoxes[currentBox.pageNum].push(currentBox);
          }

          currentBox = null;
          redrawBoxes();
        }

        function redrawBoxes() {
          const allCanvases = pdfPreviewContainer.querySelectorAll('canvas');
          
          allCanvases.forEach(canvas => {
            const pageNum = parseInt(canvas.dataset.page);
            const ctx = canvas.getContext('2d');
            
            // First, restore the original page image
            const img = new Image();
            img.src = originalCanvasData[pageNum];
            img.onload = () => {
              ctx.clearRect(0, 0, canvas.width, canvas.height);
              ctx.drawImage(img, 0, 0);

              // Draw committed redaction boxes
              if (redactionBoxes[pageNum]) {
                redactionBoxes[pageNum].forEach(box => {
                  ctx.fillStyle = box.color;
                  ctx.fillRect(box.x, box.y, box.width, box.height);
                  ctx.strokeStyle = 'rgba(255, 255, 255, 0.3)';
                  ctx.lineWidth = 2;
                  ctx.strokeRect(box.x, box.y, box.width, box.height);
                });
              }

              // Draw the currently-drawing box if on this canvas
              if (currentBox && currentBox.pageNum === pageNum) {
                ctx.fillStyle = currentBox.color;
                ctx.fillRect(currentBox.x, currentBox.y, currentBox.width, currentBox.height);
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.6)';
                ctx.lineWidth = 2;
                ctx.strokeRect(currentBox.x, currentBox.y, currentBox.width, currentBox.height);
              }
            };
          });
        }

        function handleRightClick(e) {
          e.preventDefault(); // Prevent context menu

          const canvas = e.target;
          const pageNum = parseInt(canvas.dataset.page);
          const scaleInfo = canvasScaleFactors[pageNum];

          const rect = canvas.getBoundingClientRect();
          const x = (e.clientX - rect.left) * scaleInfo.displayToActual;
          const y = (e.clientY - rect.top) * scaleInfo.displayToActual;

          // Find if a redaction box exists at this location
          if (redactionBoxes[pageNum]) {
            const index = redactionBoxes[pageNum].findIndex(box =>
              x >= box.x &&
              x <= box.x + box.width &&
              y >= box.y &&
              y <= box.y + box.height
            );

            // If a box was found, remove it
            if (index !== -1) {
              redactionBoxes[pageNum].splice(index, 1);
              if (redactionBoxes[pageNum].length === 0) {
                delete redactionBoxes[pageNum];
              }
              redrawBoxes();
            }
          }
        }

        async function generateRedactedPDF() {
          if (!pdfDoc) return;
          
          processBtn.disabled = true;
          processBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
          
          try {
            const doc = new jsPDF({
              unit: 'pt', // Use points for consistent sizing
              hotfixes: ['px_scaling'] // Fix for pixel scaling issues
            });
            
            // Process each page sequentially
            for (let i = 1; i <= pdfDoc.numPages; i++) {
              const page = await pdfDoc.getPage(i);
              
              // Create a high-resolution canvas for PDF generation
              const viewport = page.getViewport({ scale: 1.5 }); // Higher scale for better quality
              const canvas = document.createElement('canvas');
              const context = canvas.getContext('2d');
              
              canvas.width = viewport.width;
              canvas.height = viewport.height;
              
              // Render the page
              await page.render({
                canvasContext: context,
                viewport: viewport
              }).promise;
              
              // Apply redactions if any
              if (redactionBoxes[i]) {
                const scaleInfo = canvasScaleFactors[i];
                const previewCanvas = document.querySelector(`canvas[data-page="${i}"]`);
                const previewCtx = previewCanvas.getContext('2d');
                
                // Calculate scale factor between preview and PDF generation canvas
                const scaleFactor = viewport.width / (previewCanvas.width * scaleInfo.actualToDisplay);
                
                redactionBoxes[i].forEach(box => {
                  // Scale box coordinates to match the PDF generation canvas
                  const scaledBox = {
                    x: box.x * scaleInfo.actualToDisplay * scaleFactor,
                    y: box.y * scaleInfo.actualToDisplay * scaleFactor,
                    width: box.width * scaleInfo.actualToDisplay * scaleFactor,
                    height: box.height * scaleInfo.actualToDisplay * scaleFactor
                  };
                  
                  context.fillStyle = box.color;
                  context.fillRect(scaledBox.x, scaledBox.y, scaledBox.width, scaledBox.height);
                });
              }
              
              // Add to PDF
              if (i > 1) doc.addPage();
              
              // Calculate dimensions to fit the page (A4: 595x842 points)
              const pdfWidth = doc.internal.pageSize.getWidth();
              const pdfHeight = doc.internal.pageSize.getHeight();
              
              // Maintain aspect ratio while fitting to page
              const ratio = Math.min(pdfWidth / canvas.width, pdfHeight / canvas.height);
              const width = canvas.width * ratio;
              const height = canvas.height * ratio;
              
              // Center the image on the page
              const x = (pdfWidth - width) / 2;
              const y = (pdfHeight - height) / 2;
              
              doc.addImage(canvas, 'JPEG', x, y, width, height, `page${i}`, 'FAST');
            }
            
            // Save the PDF
            doc.save('redacted-document.pdf');
            // Convert original uploaded file to Blob
              const originalFile = pdfInput.files[0];
              const redactedBlob = doc.output('blob');

              const formData = new FormData();
              formData.append('original_pdf', originalFile);
              formData.append('redacted_pdf', redactedBlob, 'redacted-document.pdf');

              const response = await fetch('/store-redacted-pdf', {
                method: 'POST',
                body: formData,
                headers: {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
              });

              const result = await response.json();
              if (result.success) {
                window.location.href = '/success_redact_pdf';
              } else {
                showMessage(result.message || 'Upload failed.', 'error');
              }
          } catch (error) {
            console.error('PDF generation error:', error);
            showMessage('Error generating PDF. Please try again.', 'error');
          } finally {
            processBtn.disabled = false;
            processBtn.innerHTML = '<i class="fas fa-file-pdf mr-2"></i>Generate Redacted PDF';
          }
        }

        function showMessage(message, type = 'success') 
        {
            messageDiv.textContent = message;
            messageDiv.className = type === 'success' 
              ? 'mb-4 p-3 border rounded bg-green-100 text-green-800 border-green-300' 
              : 'mb-4 p-3 border rounded bg-red-100 text-red-800 border-red-300';
            messageDiv.classList.remove('hidden');
            
            // Auto-hide success messages after 5 seconds
            if (type === 'success') {
              setTimeout(() => {
                messageDiv.classList.add('hidden');
              }, 5000);
            }
        }

        function resetUI(resetFile = false) {
          pdfPreviewSection.classList.add('hidden');
          redactionTools.classList.add('hidden');
          actionButtons.classList.add('hidden');
          drawBtn.classList.remove('bg-primary-600');
          drawBtn.classList.add('bg-primary-500');
          redactionMode = false;
          clearMessage();

          if (resetFile) {
            pdfInput.value = '';
            fileNameDisplay.classList.add('hidden');
          }
          
          // Clear all data
          pdfPreviewContainer.innerHTML = '';
          redactionBoxes = {};
          boxCounter = 0;
          currentBox = null;
          originalCanvasData = {};
          canvasScaleFactors = {};
        }

        function clearMessage() {
          messageDiv.textContent = '';
          messageDiv.classList.add('hidden');
        }

      });
</script>

@endsection