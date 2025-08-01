@extends('layouts.app')

@section('content')

<main class="flex-grow bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto">

    <!-- Heading -->
    <div class="text-center mb-4">
      <div class="flex justify-center text-primary-500 text-4xl mb-2">
        <i class="bi bi-pencil-square"></i>
      </div>
      <h4 class="text-2xl font-extrabold text-primary-600 dark:text-primary-400 mb-1">Sign PDF</h1>
      <p class="text-base text-gray-600 dark:text-gray-300">Add your signature to the document.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-4 p-6">
      <!-- Message area -->
      <div id="message" class="mb-3 hidden p-2 border rounded text-sm"></div>

      <form id="redactForm" class="space-y-4" enctype="multipart/form-data" method="POST" action="#">
        @csrf

        <!-- Upload Section  -->
        <div>
          <!-- File -->
          <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium text-sm">PDF File:</label>

          <!-- Upload Section -->
          <div
            id="drop-zone"
            class="relative border-2 border-dashed border-primary-400 dark:border-primary-600 rounded-2xl p-8 text-center hover:border-primary-500 dark:hover:border-primary-500 transition-colors bg-gray-50/50 dark:bg-gray-700/30 cursor-pointer">
            <input
              type="file"
              name="pdf_file"
              id="pdf_file"
              accept="application/pdf"
              required
              class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
            <div class="flex flex-col items-center justify-center space-y-2">
              <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
              </svg>
              <div class="text-sm text-gray-600 dark:text-gray-400">
                <p class="font-medium text-primary-600 dark:text-primary-400">Click to upload</p>
                <p>or drag and drop your PDF</p>
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400">PDF file only (max 20MB)</p>
            </div>
          </div>
          
          <!-- Preview -->
          <p id="file-name" class="mt-1 text-primary-500 text-center hidden text-sm"></p>
        </div>


      <div id="annotation-tools" class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-md text-sm space-y-4 hidden">

        <!-- Tool Buttons -->
        <div class="flex flex-wrap gap-2">
          <button id="text-btn" type="button" class="flex items-center gap-2 px-3 py-1.5 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-400 transition-all">
            <i class="fas fa-signature text-sm"></i>
            <span>Sign</span>
          </button>

          <button id="brush-btn" type="button" class="flex items-center gap-2 px-3 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all">
            <i class="fas fa-pencil-alt text-sm"></i>
            <span>Draw</span>
          </button>

          <button id="eraser-btn" type="button" class="flex items-center gap-2 px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 transition-all">
            <i class="fas fa-eraser text-sm"></i>
            <span>Erase</span>
          </button>

          <button id="delete-all-btn" type="button" class="flex items-center gap-2 px-3 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all">
            <i class="fas fa-trash text-sm"></i>
            <span>Clear</span>
          </button>
        </div>

        <!-- Divider -->
        <hr class="border-gray-300 dark:border-gray-600">

        <!-- Font Controls -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <!-- Font Size -->
          <div class="flex items-center gap-2">
            <label for="font-size" class="text-gray-700 dark:text-gray-300 whitespace-nowrap">Size</label>
            <select id="font-size" class="w-full h-8 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-primary-400">
              <option value="12">12</option>
              <option value="14">14</option>
              <option value="16" selected>16</option>
              <option value="18">18</option>
              <option value="20">20</option>
              <option value="24">24</option>
            </select>
          </div>

          <!-- Font Style -->
          <div class="flex items-center gap-2">
            <label for="font-style" class="text-gray-700 dark:text-gray-300 whitespace-nowrap">Font</label>
            <select id="font-style" class="w-full h-8 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-primary-400">
              <option value="Arial">Arial</option>
              <option value="Courier New">Courier</option>
              <option value="Georgia">Georgia</option>
              <option value="Times New Roman">Times</option>
              <option value="Verdana">Verdana</option>
            </select>
          </div>

          <!-- Font Color -->
          <div class="flex items-center gap-2">
            <label for="font-color" class="text-gray-700 dark:text-gray-300 whitespace-nowrap">Color</label>
            <input type="color" id="font-color" value="#000000" class="w-8 h-8 rounded-md border border-gray-300 dark:border-gray-600 cursor-pointer">
          </div>
        </div>

        <!-- Hint -->
        <p class="text-gray-500 dark:text-gray-400 italic">
          Tip: Add or draw a signature. Use the eraser to remove items.
        </p>
      </div>

         
        <!-- Preview of pdf pages -->
        <div id="pdf_preview" class="mb-4 rounded-lg border border-gray-300 dark:border-gray-700 p-3 hidden">
          <label class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-1">PDF Preview & Redaction</label>
          <div id="pdf_preview_container" class="space-y-2 flex flex-col items-center overflow-auto max-h-[60vh]"></div>
        </div>
         
         
        <!-- Download button -->
        <div id="action-buttons" class="mt-4 hidden">
          <button
            type="button"
            id="process-btn"
            class="w-full flex items-center justify-center px-4 py-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg transition-all duration-300 text-sm"
          >
            <i class="fas fa-file-pdf mr-2"></i>
            Generate Redacted PDF
          </button>
        </div>

        <!-- Hidden input to store redaction boxes data -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
  const { jsPDF } = window.jspdf;
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.worker.min.js';

  document.addEventListener('DOMContentLoaded', () => {
    let pdfDoc = null;
    let isDrawing = false;
    let annotationMode = 'none';
    let brushColor = '#000000';
    let fontStyle = 'Arial';
    let fontSize = 16;
    let activeTextElement = null;

    const pdfInput = document.getElementById('pdf_file');
    const fileNameDisplay = document.getElementById('file-name');
    const pdfPreviewContainer = document.getElementById('pdf_preview_container');
    const pdfPreviewSection = document.getElementById('pdf_preview');
    const annotationTools = document.getElementById('annotation-tools');
    const actionButtons = document.getElementById('action-buttons');
    const processBtn = document.getElementById('process-btn');
    const deleteAllBtn = document.getElementById('delete-all-btn');
    const messageDiv = document.getElementById('message');

    const textBtn = document.getElementById('text-btn');
    const brushBtn = document.getElementById('brush-btn');
    const eraserBtn = document.getElementById('eraser-btn');
    const fontSelector = document.getElementById('font-style');
    const fontColorPicker = document.getElementById('font-color');
    const fontSizeSelector = document.getElementById('font-size');

    function clearMessage() {
      messageDiv.textContent = '';
      messageDiv.classList.add('hidden');
    }

    function showMessage(message, type = 'success') {
      messageDiv.textContent = message;
      messageDiv.className = type === 'success'
        ? 'mb-4 p-3 border rounded bg-green-100 text-green-800 border-green-300'
        : 'mb-4 p-3 border rounded bg-red-100 text-red-800 border-red-300';
      messageDiv.classList.remove('hidden');
      if (type === 'success') {
        setTimeout(() => messageDiv.classList.add('hidden'), 5000);
      }
    }

    function resetUI(resetFile = false) {
      pdfPreviewSection.classList.add('hidden');
      annotationTools.classList.add('hidden');
      actionButtons.classList.add('hidden');
      clearMessage();
      if (resetFile) {
        pdfInput.value = '';
        fileNameDisplay.classList.add('hidden');
      }
      pdfPreviewContainer.innerHTML = '';
      pdfDoc = null;
      activeTextElement = null;
    }

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

      if (file.size > 20 * 1024 * 1024) {
        showMessage('File exceeds 20MB size limit.', 'error');
        resetUI(true);
        return;
      }

      const fileReader = new FileReader();
      fileReader.onload = () => {
        const pdfData = new Uint8Array(fileReader.result);
        pdfjsLib.getDocument(pdfData).promise.then(doc => {
          pdfDoc = doc;
          pdfPreviewSection.classList.remove('hidden');
          annotationTools.classList.remove('hidden');
          actionButtons.classList.remove('hidden');
          pdfPreviewContainer.innerHTML = '';
          for (let i = 1; i <= doc.numPages; i++) {
            renderPage(i);
          }
        }).catch(err => {
          console.error('PDF load error:', err);
          showMessage('Failed to load PDF.', 'error');
          resetUI(true);
        });
      };
      fileReader.readAsArrayBuffer(file);
    });

  function renderPage(pageNum) {
    pdfDoc.getPage(pageNum).then(page => {
    const containerWidth = pdfPreviewContainer.clientWidth || 600; // fallback width
    const originalViewport = page.getViewport({ scale: 1 });
    const scale = (containerWidth - 40) / originalViewport.width; // subtract some padding/margin
    const viewport = page.getViewport({ scale });

    const canvas = document.createElement('canvas');
    canvas.dataset.page = pageNum;
    canvas.width = viewport.width;
    canvas.height = viewport.height;
    const context = canvas.getContext('2d');

    const canvasContainer = document.createElement('div');
    canvasContainer.className = 'canvas-container relative mb-4';
    canvasContainer.dataset.page = pageNum;
    canvasContainer.style.position = 'relative';
    canvasContainer.style.width = `${viewport.width}px`;
    canvasContainer.style.height = `${viewport.height}px`;
    canvasContainer.appendChild(canvas);

    pdfPreviewContainer.appendChild(canvasContainer);

    page.render({ canvasContext: context, viewport }).promise.then(() => {
      canvas.addEventListener('mousedown', startDrawing);
      canvas.addEventListener('mousemove', draw);
      canvas.addEventListener('mouseup', stopDrawing);
      canvas.addEventListener('mouseout', stopDrawing);
    });
    });
  }


    function createTextElement(x, y) {
      const textDiv = document.createElement('div');
      textDiv.className = 'text-annotation absolute cursor-move border border-gray-300 bg-white bg-opacity-80';
      Object.assign(textDiv.style, {
        left: `${x}px`, top: `${y}px`, color: brushColor,
        fontFamily: fontStyle, fontSize: `${fontSize}px`,
        minWidth: '20px', minHeight: '24px', padding: '4px',
        resize: 'both', overflow: 'hidden', outline: 'none',
        lineHeight: '1.2', whiteSpace: 'nowrap', overflowX: 'auto'
      });
      textDiv.contentEditable = true;
      textDiv.tabIndex = 0;
      textDiv.textContent = 'Edit text';

      const deleteBtn = document.createElement('button');
      deleteBtn.textContent = '×';
      deleteBtn.className = 'delete-btn absolute top-0 right-0 bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center cursor-pointer';
      deleteBtn.style.zIndex = 2000;
      deleteBtn.onclick = e => {
        e.stopPropagation();
        textDiv.remove();
        if (activeTextElement === textDiv) activeTextElement = null;
      };
      textDiv.appendChild(deleteBtn);

      const resizeHandle = document.createElement('div');
      resizeHandle.className = 'resize-handle absolute bottom-0 right-0 w-3 h-3 bg-blue-500 cursor-se-resize opacity-70 hover:opacity-100';
      textDiv.appendChild(resizeHandle);

      textDiv.addEventListener('keydown', e => { if (e.key === 'Enter') e.preventDefault(); });
      textDiv.addEventListener('dblclick', e => {
        e.stopPropagation();
        const range = document.createRange();
        range.selectNodeContents(textDiv);
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
      });
      textDiv.addEventListener('paste', e => {
        e.preventDefault();
        document.execCommand('insertText', false, e.clipboardData.getData('text/plain').replace(/[\r\n]+/g, ' '));
      });

      makeDraggable(textDiv);
      textDiv.addEventListener('focus', () => {
        activeTextElement = textDiv;
        fontSelector.value = textDiv.style.fontFamily;
        fontColorPicker.value = rgbToHex(textDiv.style.color);
        fontSizeSelector.value = parseInt(textDiv.style.fontSize);
      });

      return textDiv;
    }

    function makeDraggable(element) {
      let isDragging = false, startX, startY;
      element.addEventListener('mousedown', e => {
        if (e.target.classList.contains('delete-btn')) return;
        isDragging = true;
        startX = e.clientX - element.offsetLeft;
        startY = e.clientY - element.offsetTop;
        element.style.zIndex = 1000;
        e.preventDefault();
      });
      document.addEventListener('mousemove', e => {
        if (isDragging) {
          element.style.left = `${e.clientX - startX}px`;
          element.style.top = `${e.clientY - startY}px`;
        }
      });
      document.addEventListener('mouseup', () => isDragging = false);
    }

    function startDrawing(e) {
      const canvas = e.target;
      const rect = canvas.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      if (annotationMode === 'text') {
        const container = canvas.parentElement;
        const textElement = createTextElement(x, y);
        container.appendChild(textElement);
        setTimeout(() => {
          textElement.focus();
          document.execCommand('selectAll', false, null);
        }, 0);
        activeTextElement = textElement;
      } else if (annotationMode === 'brush' || annotationMode === 'eraser') {
        const ctx = canvas.getContext('2d');
        isDrawing = true;
        ctx.strokeStyle = annotationMode === 'eraser' ? 'white' : brushColor;
        ctx.lineWidth = annotationMode === 'eraser' ? 10 : 2;
        ctx.lineCap = 'round';
        ctx.beginPath();
        ctx.moveTo(x, y);
      }
    }

    function draw(e) {
      if (!isDrawing || annotationMode === 'text') return;
      const canvas = e.target;
      const rect = canvas.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const ctx = canvas.getContext('2d');
      ctx.lineTo(x, y);
      ctx.stroke();
    }

    function stopDrawing(e) {
      if (isDrawing) {
        isDrawing = false;
        const canvas = e.target;
        canvas.getContext('2d').closePath();
      }
    }

    function rgbToHex(rgb) {
      const result = /^rgba?\((\d+),\s*(\d+),\s*(\d+)/.exec(rgb);
      return result ? "#" + [1, 2, 3].map(i => parseInt(result[i]).toString(16).padStart(2, '0')).join('') : rgb;
    }

    // Tool controls
    textBtn.onclick = () => toggleTool('text');
    brushBtn.onclick = () => toggleTool('brush');
    eraserBtn.onclick = () => toggleTool('eraser');

    function toggleTool(tool) {
      annotationMode = annotationMode === tool ? 'none' : tool;
      updateToolButtonStates();
    }

    function updateToolButtonStates() {
      [textBtn, brushBtn, eraserBtn].forEach(btn => {
        const mode = btn.id.replace('-btn', '');
        const active = annotationMode === mode;
        btn.classList.toggle('bg-blue-600', active);
        btn.classList.toggle('text-white', active);
      });
    }

    fontSelector.onchange = e => {
      fontStyle = e.target.value;
      if (activeTextElement) activeTextElement.style.fontFamily = fontStyle;
    };

    fontColorPicker.onchange = e => {
      brushColor = e.target.value;
      if (activeTextElement) activeTextElement.style.color = brushColor;
    };

    fontSizeSelector.onchange = e => {
      fontSize = parseInt(e.target.value);
      if (activeTextElement) activeTextElement.style.fontSize = `${fontSize}px`;
    };

    deleteAllBtn.onclick = () => {
      document.querySelectorAll('.text-annotation').forEach(el => el.remove());
      document.querySelectorAll('.canvas-container canvas').forEach(canvas => {
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const pageNum = parseInt(canvas.dataset.page);
        if (pdfDoc && pageNum) {
          pdfDoc.getPage(pageNum).then(page => {
            const viewport = page.getViewport({ scale: 1.5 });
            page.render({ canvasContext: ctx, viewport });
          });
        }
      });
      activeTextElement = null;
      annotationMode = 'none';
      updateToolButtonStates();
      showMessage('All annotations deleted.', 'success');
    };

    processBtn.onclick = async () => {
      if (!pdfDoc) {
        showMessage('No PDF loaded.', 'error');
        return;
      }

      try {
        processBtn.disabled = true;
        processBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        showMessage('Processing PDF...', 'success');

        const pdf = new jsPDF({ unit: 'pt', format: 'a4' });

        for (let i = 0; i < pdfDoc.numPages; i++) {
          const pageNum = i + 1;
          const canvasContainer = pdfPreviewContainer.children[i];
          if (!canvasContainer) continue;

          const originalCanvas = canvasContainer.querySelector('canvas');
          const annotations = canvasContainer.querySelectorAll('.text-annotation');

          const tempCanvas = document.createElement('canvas');
          const tempCtx = tempCanvas.getContext('2d');

          tempCanvas.width = originalCanvas.width;
          tempCanvas.height = originalCanvas.height;
          tempCtx.drawImage(originalCanvas, 0, 0);

          // Draw text annotations
          tempCtx.save();
          annotations.forEach(annotation => {
            const style = window.getComputedStyle(annotation);
            const rect = annotation.getBoundingClientRect();
            const canvasRect = originalCanvas.getBoundingClientRect();
            const x = rect.left - canvasRect.left;
            const y = rect.top - canvasRect.top;
            const lines = annotation.innerText.replace('×', '').split('\n');
            const lineHeight = parseInt(style.fontSize) * 1.2;

            tempCtx.font = `${style.fontSize} ${style.fontFamily}`;
            tempCtx.fillStyle = style.color;
            tempCtx.textBaseline = 'top';

            lines.forEach((line, index) => {
              tempCtx.fillText(line, x, y + index * lineHeight);
            });
          });
          tempCtx.restore();

          const pageWidth = pdf.internal.pageSize.getWidth();
          const pageHeight = pdf.internal.pageSize.getHeight();
          const ratio = Math.min(pageWidth / tempCanvas.width, pageHeight / tempCanvas.height);
          const width = tempCanvas.width * ratio;
          const height = tempCanvas.height * ratio;
          const x = (pageWidth - width) / 2;
          const y = (pageHeight - height) / 2;

          if (i > 0) pdf.addPage();
          pdf.addImage(tempCanvas, 'JPEG', x, y, width, height);
        }

        const pdfBlob = await pdf.output('blob');

        // Optional: trigger local download
        const downloadUrl = URL.createObjectURL(pdfBlob);
        const a = document.createElement('a');
        a.href = downloadUrl;
        a.download = 'signed_document.pdf';
        window.location.href = '/success_sign_pdf';
        document.body.appendChild(a);
        a.click();
        URL.revokeObjectURL(downloadUrl);

        // Prepare for upload
        const formData = new FormData();
        const originalFile = pdfInput.files[0];
        const signedFile = new File([pdfBlob], 'signed_' + originalFile.name, {
          type: 'application/pdf'
        });

        formData.append('pdf_file', originalFile);
        formData.append('signed_pdf', signedFile);

        const csrfToken = document.querySelector('input[name="_token"]')?.value;

        const response = await fetch('/store-signed-pdf', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken // ✅ No Content-Type header here
          },
          body: formData
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
          throw new Error(result?.error || 'Upload failed');
        }

        window.location.href = '/success_sign_pdf';
      } catch (err) {
        console.error(err);
        showMessage(err.message || 'Something went wrong.', 'error');
      } finally {
        processBtn.disabled = false;
        processBtn.innerHTML = '<i class="fas fa-file-signature mr-2"></i>Sign PDF';
      }
    };

  });
</script>

@endsection