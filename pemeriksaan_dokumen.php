<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemeriksaan Dokumen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f5f6fa;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .header h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .section {
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .document-list {
            border-radius: 8px;
        }

        .document-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #eee;
            flex-wrap: wrap;
            gap: 10px;
        }

        .document-item:last-child {
            border-bottom: none;
        }

        .document-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
            min-width: 200px;
        }

        .document-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .document-name {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .document-status {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            margin-left: 10px;
        }

        .status-belum {
            background: #fff3cd;
            color: #856404;
        }

        .status-sudah {
            background: #d4edda;
            color: #155724;
        }

        .action-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .file-input {
            display: none;
        }

        .btn {
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn svg {
            width: 14px;
            height: 14px;
        }

        .btn-upload {
            background: #667eea;
            color: #fff;
        }

        .btn-upload:hover {
            background: #5a6fd6;
        }

        .btn-view {
            background: #28a745;
            color: #fff;
        }

        .btn-view:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
            color: #fff;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn svg {
            fill: #fff;
        }

        .file-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .file-name {
            font-size: 12px;
            color: #333;
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 500;
        }

        .file-name-original {
            font-size: 11px;
            color: #888;
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #fff;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-btn:hover {
            transform: scale(1.1);
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
            fill: #333;
        }

        .hidden {
            display: none !important;
        }

        /* Modal for viewing documents */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .modal-content {
            background: #fff;
            border-radius: 12px;
            width: 90%;
            max-width: 90%;
            max-height: 90%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 15px 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 16px;
            color: #333;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .modal-body {
            padding: 20px;
            overflow: auto;
        }

        .modal-body iframe {
            width: 100%;
            height: 70vh;
            border: none;
        }

        .modal-body img {
            max-width: 100%;
            max-height: 70vh;
            object-fit: contain;
        }

        /* Drag and Drop Styles */
        .drop-zone {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #fafafa;
            margin-top: 10px;
        }

        .drop-zone:hover {
            border-color: #667eea;
            background: #f0f2ff;
        }

        .drop-zone.drag-over {
            border-color: #667eea;
            background: #e8ebff;
            transform: scale(1.02);
        }

        .drop-zone-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 10px;
            fill: #667eea;
        }

        .drop-zone-text {
            color: #666;
            font-size: 13px;
        }

        .drop-zone-text strong {
            color: #667eea;
        }

        /* Progress Bar Styles */
        .progress-container {
            margin-top: 10px;
            display: none;
        }

        .progress-container.active {
            display: block;
        }

        .progress-bar-wrapper {
            background: #e9ecef;
            border-radius: 10px;
            height: 20px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-fill {
            background: linear-gradient(90deg, #667eea, #764ba2);
            height: 100%;
            width: 0%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .progress-bar-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 11px;
            font-weight: 600;
            color: #333;
        }

        .progress-filename {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        /* Drop zone for document items */
        .document-item-dropzone {
            border: 2px dashed transparent;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .document-item-dropzone.drag-over {
            border-color: #667eea;
            background: #f0f2ff;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='detail_pekerjaan.php?id=' + new URLSearchParams(window.location.search).get('id')">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Pemeriksaan Dokumen</h1>
            <p id="pekerjaanNama">Memuat...</p>
        </div>

        <div class="section" id="sectionUmum">
            <h2 class="section-title">Dokumen Umum</h2>
            <div class="drop-zone section-drop-zone" id="dropZoneUmum" data-section="umum">
                <svg class="drop-zone-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                </svg>
                <p class="drop-zone-text"><strong>Drag & Drop</strong> file di sini untuk upload dokumen umum</p>
            </div>
            <div class="document-list">
                <!-- doc1 - doc9 will be generated by JavaScript -->
            </div>
        </div>

        <div class="section" id="sectionTanah">
            <h2 class="section-title">Khusus Belanja Modal Tanah</h2>
            <div class="drop-zone section-drop-zone" id="dropZoneTanah" data-section="tanah">
                <svg class="drop-zone-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                </svg>
                <p class="drop-zone-text"><strong>Drag & Drop</strong> file di sini untuk upload dokumen tanah</p>
            </div>
            <div class="document-list">
                <!-- doc10 - doc15 will be generated by JavaScript -->
            </div>
        </div>

        <div class="section" id="sectionLainnya">
            <h2 class="section-title">Dokumen Lainnya</h2>
            <div class="drop-zone section-drop-zone" id="dropZoneLainnya" data-section="lainnya">
                <svg class="drop-zone-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                </svg>
                <p class="drop-zone-text"><strong>Drag & Drop</strong> file di sini untuk upload dokumen lainnya</p>
            </div>
            <div class="document-list" id="dokumenLainnyaList">
                <!-- Dokumen lainnya will be generated by JavaScript -->
            </div>
            <div style="margin-top: 15px;">
                <button class="btn btn-upload" onclick="addDokumenLainnya()">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Tambah Dokumen Lainnya
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for viewing documents -->
    <div id="viewModal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Lihat Dokumen</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
            </div>
        </div>
    </div>

    <script>
        // Global variable for pekerjaan ID
        var idPekerjaan = null;
        
        // Global variable for jenis belanja modal
        var jenisBelanjaModal = null;
        
        // Document configuration
        const docConfig = {
            // Dokumen Umum (doc1-doc9)
            'doc1': { name: 'Kontrak/Surat Pemesanan', subfolder: 'Dokumen/Umum', jenis: 'umum' },
            'doc2': { name: 'SPMK', subfolder: 'Dokumen/Umum', jenis: 'umum' },
            'doc3': { name: 'Gambar Rencana', subfolder: 'Gambar', jenis: 'umum' },
            'doc4': { name: 'Gambar Pelaksanaan', subfolder: 'Gambar', jenis: 'umum' },
            'doc5': { name: 'Backup Data Quantity', subfolder: 'Dokumen/Umum', jenis: 'umum' },
            'doc6': { name: 'Monthly Certificate', subfolder: 'Dokumen/Umum', jenis: 'umum' },
            'doc7': { name: 'Foto (0%, 50% dan 100%)', subfolder: 'Foto', jenis: 'umum' },
            'doc8': { name: 'Berita Acara Hasil Pemeriksaan Pekerjaan', subfolder: 'Dokumen/Umum', jenis: 'umum' },
            'doc9': { name: 'PHO (Provisional Hand Over)', subfolder: 'Serah_Terima', jenis: 'umum' },
            // Dokumen Tanah (doc10-doc15)
            'doc10': { name: 'Berita Acara Pengadaan/Pelepasan Tanah', subfolder: 'Dokumen/Tanah', jenis: 'tanah' },
            'doc11': { name: 'Surat Keterangan Penjualan Tanah', subfolder: 'Dokumen/Tanah', jenis: 'tanah' },
            'doc12': { name: 'Surat Pernyataan Persetujuan Pemilik Tanah', subfolder: 'Dokumen/Tanah', jenis: 'tanah' },
            'doc13': { name: 'Surat Pernyataan Pemilik Tanah', subfolder: 'Dokumen/Tanah', jenis: 'tanah' },
            'doc14': { name: 'Sertifikat Tanah Pemilik Sebelumnya', subfolder: 'Dokumen/Tanah', jenis: 'tanah' },
            'doc15': { name: 'Dokumen Apraisal Tanah', subfolder: 'Dokumen/Tanah', jenis: 'tanah' }
        };
        
        // Store uploaded document data
        var uploadedDocs = {};
        
        // Store dokumen lainnya data
        var dokumenLainnya = [];
        var dokumenLainnyaCounter = 0;
        
        // Get pekerjaan ID from URL
        function getPekerjaanId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
        }
        
        // Generate document items HTML
        function generateDocumentItems() {
            const umumContainer = document.querySelectorAll('.document-list')[0];
            const tanahContainer = document.querySelectorAll('.document-list')[1];
            
            let umumHtml = '';
            let tanahHtml = '';
            
            Object.keys(docConfig).forEach((docId, index) => {
                const doc = docConfig[docId];
                const docNum = index + 1;
                
                const html = `
                    <div class="document-item document-item-dropzone" id="item-${docId}" data-doc-id="${docId}">
                        <div class="document-info">
                            <input type="checkbox" class="document-checkbox" id="${docId}" onchange="updateCount()">
                            <label class="document-name" for="${docId}">${doc.name}</label>
                            <span class="document-status status-belum" id="status${docNum}">Belum Upload</span>
                        </div>
                        <div class="action-container">
                            <input type="file" class="file-input" id="file${docNum}" onchange="uploadFile(this, '${docId}')">
                            <button class="btn btn-upload" id="uploadBtn${docNum}" onclick="document.getElementById('file${docNum}').click()">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/></svg>
                                Upload
                            </button>
                            <button class="btn btn-view hidden" id="viewBtn${docNum}" onclick="viewDocument('${docId}')">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                Lihat
                            </button>
                            <button class="btn btn-delete hidden" id="deleteBtn${docNum}" onclick="deleteDocument('${docId}')">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                Hapus
                            </button>
                            <div class="file-info hidden" id="fileInfo${docNum}">
                                <span class="file-name" id="name${docNum}"></span>
                                <span class="file-name-original" id="originalName${docNum}"></span>
                            </div>
                        </div>
                        <div class="progress-container" id="progressContainer${docNum}">
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-fill" id="progressBar${docNum}"></div>
                                <span class="progress-bar-text" id="progressText${docNum}">0%</span>
                            </div>
                            <div class="progress-filename" id="progressFilename${docNum}"></div>
                        </div>
                    </div>
                `;
                
                if (doc.jenis === 'umum') {
                    umumHtml += html;
                } else {
                    tanahHtml += html;
                }
            });
            
            umumContainer.innerHTML = umumHtml;
            tanahContainer.innerHTML = tanahHtml;
            
            // Initialize drag and drop for document items
            initDragAndDrop();
        }
        
        // Load pekerjaan info and document status
        async function loadPekerjaanInfo() {
            idPekerjaan = getPekerjaanId();
            if (!idPekerjaan) return;
            
            try {
                // Get pekerjaan details
                const response = await fetch('api/get_pekerjaan.php?id=' + idPekerjaan);
                const result = await response.json();
                
                if (result.success && result.data) {
                    // Update header
                    document.getElementById('pekerjaanNama').textContent = result.data.nama_pekerjaan || '';
                    
                    // Get jenis belanja modal (inisial akun belanja)
                    jenisBelanjaModal = result.data.inisial_akun_belanja || '';
                    
                    // Apply conditional display based on jenis belanja modal
                    applyConditionalDisplay();
                }
                
                // Load document status from database
                await loadDokumenStatus();
                
                // Load dokumen lainnya
                await loadDokumenLainnya();
                
            } catch (error) {
                console.error('Error loading pekerjaan info:', error);
            }
        }
        
        // Apply conditional display based on jenis belanja modal
        function applyConditionalDisplay() {
            const sectionUmum = document.getElementById('sectionUmum');
            const sectionTanah = document.getElementById('sectionTanah');
            
            // TL = Belanja Modal Tanah
            if (jenisBelanjaModal === 'TL') {
                // If Belanja Modal Tanah, show only Tanah section
                sectionUmum.classList.add('hidden');
                sectionTanah.classList.remove('hidden');
            } else {
                // If not Belanja Modal Tanah, show only Umum section
                sectionUmum.classList.remove('hidden');
                sectionTanah.classList.add('hidden');
            }
            // Dokumen Lainnya section always visible
        }
        
        // Load document upload status from database
        async function loadDokumenStatus() {
            if (!idPekerjaan) return;
            
            try {
                // Also check individual dokumen table
                const docResponse = await fetch('api/get_dokumen.php?id_pekerjaan=' + idPekerjaan);
                const docResult = await docResponse.json();
                
                uploadedDocs = {};
                if (docResult.success && docResult.data) {
                    docResult.data.forEach(doc => {
                        uploadedDocs[doc.doc_id] = doc;
                    });
                }
                
                // Update UI for each document
                Object.keys(docConfig).forEach((docId, index) => {
                    const docNum = index + 1;
                    const docData = uploadedDocs[docId];
                    
                    if (docData && docData.status === 'sudah_upload') {
                        updateUIAfterUpload(docNum, docData);
                    } else {
                        resetUI(docNum);
                    }
                });
                
                // Update count
                updateCount();
                
            } catch (error) {
                console.error('Error loading dokumen status:', error);
            }
        }
        
        // Update UI after upload
        function updateUIAfterUpload(docNum, docData) {
            const statusSpan = document.getElementById('status' + docNum);
            if (statusSpan) {
                statusSpan.textContent = 'Sudah Upload';
                statusSpan.classList.remove('status-belum');
                statusSpan.classList.add('status-sudah');
            }
            
            const checkbox = document.getElementById('doc' + docNum);
            if (checkbox) {
                checkbox.checked = true;
            }
            
            // Show view and delete buttons
            document.getElementById('viewBtn' + docNum).classList.remove('hidden');
            document.getElementById('deleteBtn' + docNum).classList.remove('hidden');
            
            // Show file info
            const fileInfo = document.getElementById('fileInfo' + docNum);
            fileInfo.classList.remove('hidden');
            
            // Set file names
            document.getElementById('name' + docNum).textContent = docData.nama_dokumen || '';
            document.getElementById('originalName' + docNum).textContent = docData.nama_dokumen_asli || '';
            
            // Change upload button to "Ganti"
            const uploadBtn = document.getElementById('uploadBtn' + docNum);
            uploadBtn.innerHTML = `
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/></svg>
                Ganti
            `;
        }
        
        // Reset UI
        function resetUI(docNum) {
            const statusSpan = document.getElementById('status' + docNum);
            if (statusSpan) {
                statusSpan.textContent = 'Belum Upload';
                statusSpan.classList.add('status-belum');
                statusSpan.classList.remove('status-sudah');
            }
            
            const checkbox = document.getElementById('doc' + docNum);
            if (checkbox) {
                checkbox.checked = false;
            }
            
            // Hide view and delete buttons
            document.getElementById('viewBtn' + docNum).classList.add('hidden');
            document.getElementById('deleteBtn' + docNum).classList.add('hidden');
            
            // Hide file info
            document.getElementById('fileInfo' + docNum).classList.add('hidden');
            
            // Reset upload button
            const uploadBtn = document.getElementById('uploadBtn' + docNum);
            uploadBtn.innerHTML = `
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/></svg>
                Upload
            `;
        }
        
        // Update document count in database
        async function saveDocCountToDb(total, uploaded) {
            if (!idPekerjaan) return;
            
            try {
                const formData = new FormData();
                formData.append('action', 'save_dokumen');
                formData.append('id_pekerjaan', idPekerjaan);
                formData.append('dokumen_total', total);
                formData.append('dokumen_terupload', uploaded);
                
                const response = await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                console.log('Save doc count result:', result);
            } catch (error) {
                console.error('Error saving doc count:', error);
            }
        }
        
        function uploadFile(input, docId) {
            var file = input.files[0];
            if (file) {
                handleFileUpload(file, docId);
            }
        }
        
        // View document
        function viewDocument(docId) {
            const docData = uploadedDocs[docId];
            if (!docData || !docData.file_path) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Dokumen tidak ditemukan'
                });
                return;
            }
            
            const filePath = docData.file_path;
            const extension = filePath.split('.').pop().toLowerCase();
            
            document.getElementById('modalTitle').textContent = docData.nama_dokumen_asli || docData.nama_dokumen;
            
            const modalBody = document.getElementById('modalBody');
            
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(extension)) {
                // Show image
                modalBody.innerHTML = `<img src="${filePath}" alt="${docData.nama_dokumen_asli}">`;
            } else if (['pdf'].includes(extension)) {
                // Show PDF in iframe
                modalBody.innerHTML = `<iframe src="${filePath}" title="${docData.nama_dokumen_asli}"></iframe>`;
            } else {
                // Download link
                modalBody.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <p style="margin-bottom: 20px;">File tidak dapat ditampilkan langsung.</p>
                        <a href="${filePath}" download class="btn btn-upload" style="display: inline-flex;">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                            Download File
                        </a>
                    </div>
                `;
            }
            
            document.getElementById('viewModal').classList.remove('hidden');
        }
        
        // Close modal
        function closeModal() {
            document.getElementById('viewModal').classList.add('hidden');
            document.getElementById('modalBody').innerHTML = '';
        }
        
        // Delete document
        function deleteDocument(docId) {
            const docData = uploadedDocs[docId];
            if (!docData) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Dokumen tidak ditemukan'
                });
                return;
            }
            
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Dokumen?',
                text: 'Dokumen "' + (docData.nama_dokumen_asli || docData.nama_dokumen) + '" akan dihapus permanen.',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Delete from server
                    const formData = new FormData();
                    formData.append('action', 'delete_dokumen');
                    formData.append('id_pekerjaan', idPekerjaan);
                    formData.append('doc_id', docId);
                    
                    fetch('api/proses_pemeriksaan_pekerjaan.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove from local cache
                            delete uploadedDocs[docId];
                            
                            // Reset UI
                            const docNum = parseInt(docId.replace('doc', ''));
                            resetUI(docNum);
                            updateCount();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Dokumen berhasil dihapus',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Gagal menghapus dokumen.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting file:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus dokumen.'
                        });
                    });
                }
            });
        }

        function updateCount() {
            // Count only visible documents based on jenis belanja modal
            var visibleDocs = [];
            Object.keys(docConfig).forEach((docId) => {
                const doc = docConfig[docId];
                if (jenisBelanjaModal === 'TL' && doc.jenis === 'tanah') {
                    visibleDocs.push(docId);
                } else if (jenisBelanjaModal !== 'TL' && doc.jenis === 'umum') {
                    visibleDocs.push(docId);
                }
            });
            
            var totalDocs = visibleDocs.length;
            var checkedCount = 0;
            
            visibleDocs.forEach((docId) => {
                const checkbox = document.getElementById(docId);
                if (checkbox && checkbox.checked) {
                    checkedCount++;
                }
            });
            
            // Save to localStorage (for backwards compatibility)
            localStorage.setItem('docCount', checkedCount);
            // Save to database
            if (idPekerjaan) {
                saveDocCountToDb(totalDocs, checkedCount);
            }
        }
        
        // Load dokumen lainnya from database
        async function loadDokumenLainnya() {
            if (!idPekerjaan) return;
            
            try {
                const response = await fetch('api/get_dokumen.php?id_pekerjaan=' + idPekerjaan + '&jenis=lainnya');
                const result = await response.json();
                
                if (result.success && result.data) {
                    dokumenLainnya = result.data;
                    renderDokumenLainnya();
                }
            } catch (error) {
                console.error('Error loading dokumen lainnya:', error);
            }
        }
        
        // Render dokumen lainnya list
        function renderDokumenLainnya() {
            const container = document.getElementById('dokumenLainnyaList');
            let html = '';
            
            dokumenLainnya.forEach((doc, index) => {
                const isUploaded = doc.status === 'sudah_upload';
                html += `
                    <div class="document-item document-item-dropzone" id="lainnya-item-${doc.id_dokumen}" data-doc-id="lainnya-${doc.id_dokumen}">
                        <div class="document-info">
                            <span class="document-name">${doc.nama_dokumen || 'Dokumen Lainnya'}</span>
                            <span class="document-status ${isUploaded ? 'status-sudah' : 'status-belum'}">${isUploaded ? 'Sudah Upload' : 'Belum Upload'}</span>
                        </div>
                        <div class="action-container">
                            <input type="file" class="file-input" id="fileLainnya-${doc.id_dokumen}" onchange="uploadDokumenLainnya(this, ${doc.id_dokumen})">
                            <button class="btn btn-upload" onclick="document.getElementById('fileLainnya-${doc.id_dokumen}').click()">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/></svg>
                                ${isUploaded ? 'Ganti' : 'Upload'}
                            </button>
                            ${isUploaded ? `
                                <button class="btn btn-view" onclick="viewDokumenLainnya(${doc.id_dokumen})">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                    Lihat
                                </button>
                                <button class="btn btn-delete" onclick="deleteDokumenLainnya(${doc.id_dokumen})">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                    Hapus
                                </button>
                            ` : ''}
                            <button class="btn btn-delete" onclick="removeDokumenLainnyaEntry(${doc.id_dokumen})" style="background: #6c757d;">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                                Hapus Entry
                            </button>
                        </div>
                        <div class="progress-container" id="progressContainerLainnya-${doc.id_dokumen}">
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-fill" id="progressBarLainnya-${doc.id_dokumen}"></div>
                                <span class="progress-bar-text" id="progressTextLainnya-${doc.id_dokumen}">0%</span>
                            </div>
                            <div class="progress-filename" id="progressFilenameLainnya-${doc.id_dokumen}"></div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        // Handle file upload for dokumen lainnya with progress
        function handleFileUploadLainnya(file, idDokumen) {
            console.log('Uploading dokumen lainnya:', file.name);
            console.log('ID Pekerjaan:', idPekerjaan);
            console.log('ID Dokumen:', idDokumen);
            
            if (!idPekerjaan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID Pekerjaan tidak ditemukan'
                });
                return;
            }
            
            // Show progress container
            const progressContainer = document.getElementById('progressContainerLainnya-' + idDokumen);
            const progressBar = document.getElementById('progressBarLainnya-' + idDokumen);
            const progressText = document.getElementById('progressTextLainnya-' + idDokumen);
            const progressFilename = document.getElementById('progressFilenameLainnya-' + idDokumen);
            
            if (progressContainer) {
                progressContainer.classList.add('active');
                progressFilename.textContent = file.name;
                progressBar.style.width = '0%';
                progressText.textContent = '0%';
            }
            
            // Use XMLHttpRequest for progress tracking
            const xhr = new XMLHttpRequest();
            const formData = new FormData();
            formData.append('action', 'upload_dokumen_lainnya');
            formData.append('id_pekerjaan', idPekerjaan);
            formData.append('id_dokumen', idDokumen);
            formData.append('file', file);
            
            // Track upload progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    
                    if (progressBar && progressText) {
                        progressBar.style.width = percentComplete + '%';
                        progressText.textContent = percentComplete + '%';
                    }
                    
                    console.log('Upload progress:', percentComplete + '%');
                }
            });
            
            // Handle completion
            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    try {
                        const data = JSON.parse(xhr.responseText);
                        
                        if (data.success) {
                            // Update local data
                            const docIndex = dokumenLainnya.findIndex(d => d.id_dokumen === idDokumen);
                            if (docIndex !== -1) {
                                dokumenLainnya[docIndex].status = 'sudah_upload';
                                dokumenLainnya[docIndex].file_path = data.file_path;
                                dokumenLainnya[docIndex].nama_dokumen_asli = data.file_name;
                            }
                            
                            // Hide progress after a short delay
                            setTimeout(() => {
                                renderDokumenLainnya();
                            }, 500);
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Dokumen berhasil diupload',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            if (progressContainer) {
                                progressContainer.classList.remove('active');
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Gagal mengupload dokumen'
                            });
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        if (progressContainer) {
                            progressContainer.classList.remove('active');
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memproses respons server.'
                        });
                    }
                }
            });
            
            // Handle errors
            xhr.addEventListener('error', function() {
                console.error('Error uploading file');
                if (progressContainer) {
                    progressContainer.classList.remove('active');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan jaringan saat mengupload dokumen.'
                });
            });
            
            // Send request
            xhr.open('POST', 'api/proses_pemeriksaan_pekerjaan.php');
            xhr.send(formData);
        }
        
        // Add new dokumen lainnya entry
        async function addDokumenLainnya() {
            if (!idPekerjaan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID Pekerjaan tidak ditemukan'
                });
                return;
            }
            
            const { value: docName } = await Swal.fire({
                title: 'Tambah Dokumen Lainnya',
                input: 'text',
                inputLabel: 'Nama Dokumen',
                inputPlaceholder: 'Masukkan nama dokumen',
                showCancelButton: true,
                confirmButtonText: 'Tambah',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Nama dokumen harus diisi!';
                    }
                }
            });
            
            if (docName) {
                try {
                    const formData = new FormData();
                    formData.append('action', 'add_dokumen_lainnya');
                    formData.append('id_pekerjaan', idPekerjaan);
                    formData.append('nama_dokumen', docName);
                    
                    const response = await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    if (result.success) {
                        dokumenLainnya.push({
                            id_dokumen: result.id_dokumen,
                            nama_dokumen: docName,
                            status: 'belum_upload'
                        });
                        renderDokumenLainnya();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Entry dokumen berhasil ditambahkan',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: result.message || 'Gagal menambahkan entry dokumen'
                        });
                    }
                } catch (error) {
                    console.error('Error adding dokumen lainnya:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menambahkan entry dokumen'
                    });
                }
            }
        }
        
        // Upload dokumen lainnya
        function uploadDokumenLainnya(input, idDokumen) {
            var file = input.files[0];
            if (file) {
                handleFileUploadLainnya(file, idDokumen);
            }
        }
        
        // View dokumen lainnya
        function viewDokumenLainnya(idDokumen) {
            const doc = dokumenLainnya.find(d => d.id_dokumen === idDokumen);
            if (!doc || !doc.file_path) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Dokumen tidak ditemukan'
                });
                return;
            }
            
            const filePath = doc.file_path;
            const extension = filePath.split('.').pop().toLowerCase();
            
            document.getElementById('modalTitle').textContent = doc.nama_dokumen_asli || doc.nama_dokumen;
            
            const modalBody = document.getElementById('modalBody');
            
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(extension)) {
                modalBody.innerHTML = `<img src="${filePath}" alt="${doc.nama_dokumen_asli}">`;
            } else if (['pdf'].includes(extension)) {
                modalBody.innerHTML = `<iframe src="${filePath}" title="${doc.nama_dokumen_asli}"></iframe>`;
            } else {
                modalBody.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <p style="margin-bottom: 20px;">File tidak dapat ditampilkan langsung.</p>
                        <a href="${filePath}" download class="btn btn-upload" style="display: inline-flex;">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                            Download File
                        </a>
                    </div>
                `;
            }
            
            document.getElementById('viewModal').classList.remove('hidden');
        }
        
        // Delete dokumen lainnya file
        function deleteDokumenLainnya(idDokumen) {
            const doc = dokumenLainnya.find(d => d.id_dokumen === idDokumen);
            if (!doc) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Dokumen tidak ditemukan'
                });
                return;
            }
            
            Swal.fire({
                icon: 'warning',
                title: 'Hapus File Dokumen?',
                text: 'File dokumen akan dihapus permanen.',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('action', 'delete_dokumen_lainnya');
                    formData.append('id_pekerjaan', idPekerjaan);
                    formData.append('id_dokumen', idDokumen);
                    
                    fetch('api/proses_pemeriksaan_pekerjaan.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update local data
                            const docIndex = dokumenLainnya.findIndex(d => d.id_dokumen === idDokumen);
                            if (docIndex !== -1) {
                                dokumenLainnya[docIndex].status = 'belum_upload';
                                dokumenLainnya[docIndex].file_path = null;
                                dokumenLainnya[docIndex].nama_dokumen_asli = null;
                            }
                            renderDokumenLainnya();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'File dokumen berhasil dihapus',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Gagal menghapus file dokumen'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting dokumen lainnya:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus file dokumen'
                        });
                    });
                }
            });
        }
        
        // Remove dokumen lainnya entry completely
        function removeDokumenLainnyaEntry(idDokumen) {
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Entry Dokumen?',
                text: 'Entry dokumen dan file (jika ada) akan dihapus permanen.',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('action', 'remove_dokumen_lainnya');
                    formData.append('id_pekerjaan', idPekerjaan);
                    formData.append('id_dokumen', idDokumen);
                    
                    fetch('api/proses_pemeriksaan_pekerjaan.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove from local data
                            dokumenLainnya = dokumenLainnya.filter(d => d.id_dokumen !== idDokumen);
                            renderDokumenLainnya();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Entry dokumen berhasil dihapus',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Gagal menghapus entry dokumen'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error removing dokumen lainnya:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus entry dokumen'
                        });
                    });
                }
            });
        }
        
        // Close modal when clicking outside
        document.getElementById('viewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Initialize drag and drop functionality
        function initDragAndDrop() {
            // Prevent default drag behaviors on document
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                document.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            // Setup drag and drop for section drop zones
            const sectionDropZones = document.querySelectorAll('.section-drop-zone');
            
            sectionDropZones.forEach(zone => {
                zone.addEventListener('dragenter', handleSectionDragEnter);
                zone.addEventListener('dragover', handleSectionDragOver);
                zone.addEventListener('dragleave', handleSectionDragLeave);
                zone.addEventListener('drop', handleSectionDrop);
            });
            
            function handleSectionDragEnter(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            }
            
            function handleSectionDragOver(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
            }
            
            function handleSectionDragLeave(e) {
                e.preventDefault();
                const rect = this.getBoundingClientRect();
                const x = e.clientX;
                const y = e.clientY;
                
                if (x < rect.left || x > rect.right || y < rect.top || y > rect.bottom) {
                    this.classList.remove('drag-over');
                }
            }
            
            function handleSectionDrop(e) {
                e.preventDefault();
                e.stopPropagation();
                
                this.classList.remove('drag-over');
                
                const files = e.dataTransfer.files;
                const section = this.dataset.section;
                
                if (files.length > 0 && section) {
                    handleSectionFileUpload(files[0], section);
                }
            }
            
            // Setup drag and drop for each document item
            const dropZones = document.querySelectorAll('.document-item-dropzone');
            
            dropZones.forEach(zone => {
                zone.addEventListener('dragenter', handleDragEnter);
                zone.addEventListener('dragover', handleDragOver);
                zone.addEventListener('dragleave', handleDragLeave);
                zone.addEventListener('drop', handleDrop);
            });
            
            function handleDragEnter(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            }
            
            function handleDragOver(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
            }
            
            function handleDragLeave(e) {
                e.preventDefault();
                // Check if we're leaving the element entirely
                const rect = this.getBoundingClientRect();
                const x = e.clientX;
                const y = e.clientY;
                
                if (x < rect.left || x > rect.right || y < rect.top || y > rect.bottom) {
                    this.classList.remove('drag-over');
                }
            }
            
            function handleDrop(e) {
                e.preventDefault();
                e.stopPropagation();
                
                this.classList.remove('drag-over');
                
                const files = e.dataTransfer.files;
                const docId = this.dataset.docId;
                
                if (files.length > 0 && docId) {
                    // Check if it's a dokumen lainnya
                    if (docId.startsWith('lainnya-')) {
                        const idDokumen = parseInt(docId.replace('lainnya-', ''));
                        handleFileUploadLainnya(files[0], idDokumen);
                    } else {
                        handleFileUpload(files[0], docId);
                    }
                }
            }
        }
        
        // Handle file upload for section drop zones
        function handleSectionFileUpload(file, section) {
            if (!idPekerjaan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID Pekerjaan tidak ditemukan di URL'
                });
                return;
            }
            
            if (section === 'umum') {
                // Find first available umum document
                const umumDocs = Object.keys(docConfig).filter(docId => docConfig[docId].jenis === 'umum');
                const availableDoc = umumDocs.find(docId => !uploadedDocs[docId] || uploadedDocs[docId].status !== 'sudah_upload');
                
                if (availableDoc) {
                    handleFileUpload(file, availableDoc);
                } else {
                    // All umum docs uploaded, ask user which one to replace
                    showDocSelectionModal(file, 'umum');
                }
            } else if (section === 'tanah') {
                // Find first available tanah document
                const tanahDocs = Object.keys(docConfig).filter(docId => docConfig[docId].jenis === 'tanah');
                const availableDoc = tanahDocs.find(docId => !uploadedDocs[docId] || uploadedDocs[docId].status !== 'sudah_upload');
                
                if (availableDoc) {
                    handleFileUpload(file, availableDoc);
                } else {
                    // All tanah docs uploaded, ask user which one to replace
                    showDocSelectionModal(file, 'tanah');
                }
            } else if (section === 'lainnya') {
                // For dokumen lainnya, check if there are any entries
                if (dokumenLainnya.length === 0) {
                    // No entries yet, create one first
                    createAndUploadDokumenLainnya(file);
                } else {
                    // Find first available dokumen lainnya
                    const availableDoc = dokumenLainnya.find(doc => doc.status !== 'sudah_upload');
                    
                    if (availableDoc) {
                        handleFileUploadLainnya(file, availableDoc.id_dokumen);
                    } else {
                        // All docs uploaded, ask user which one to replace
                        showDokumenLainnyaSelectionModal(file);
                    }
                }
            }
        }
        
        // Show document selection modal for umum/tanah
        async function showDocSelectionModal(file, jenis) {
            const docs = Object.keys(docConfig)
                .filter(docId => docConfig[docId].jenis === jenis)
                .map(docId => ({
                    id: docId,
                    name: docConfig[docId].name,
                    uploaded: uploadedDocs[docId] && uploadedDocs[docId].status === 'sudah_upload'
                }));
            
            const { value: selectedDocId } = await Swal.fire({
                title: 'Pilih Dokumen',
                html: `
                    <p style="margin-bottom: 15px; color: #666;">Semua dokumen ${jenis === 'umum' ? 'umum' : 'tanah'} sudah terupload. Pilih dokumen yang ingin diganti:</p>
                    <select id="docSelect" class="swal2-select" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ddd;">
                        ${docs.map(doc => `<option value="${doc.id}">${doc.name} ${doc.uploaded ? '(Sudah Upload)' : ''}</option>`).join('')}
                    </select>
                `,
                showCancelButton: true,
                confirmButtonText: 'Upload',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    return document.getElementById('docSelect').value;
                }
            });
            
            if (selectedDocId) {
                handleFileUpload(file, selectedDocId);
            }
        }
        
        // Show document selection modal for dokumen lainnya
        async function showDokumenLainnyaSelectionModal(file) {
            const { value: selectedId } = await Swal.fire({
                title: 'Pilih Dokumen',
                html: `
                    <p style="margin-bottom: 15px; color: #666;">Semua dokumen lainnya sudah terupload. Pilih dokumen yang ingin diganti:</p>
                    <select id="docSelect" class="swal2-select" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ddd;">
                        ${dokumenLainnya.map(doc => `<option value="${doc.id_dokumen}">${doc.nama_dokumen} (Sudah Upload)</option>`).join('')}
                    </select>
                `,
                showCancelButton: true,
                confirmButtonText: 'Upload',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    return document.getElementById('docSelect').value;
                }
            });
            
            if (selectedId) {
                handleFileUploadLainnya(file, parseInt(selectedId));
            }
        }
        
        // Create new dokumen lainnya entry and upload file
        async function createAndUploadDokumenLainnya(file) {
            const { value: docName } = await Swal.fire({
                title: 'Nama Dokumen',
                input: 'text',
                inputLabel: 'Masukkan nama dokumen untuk file: ' + file.name,
                inputPlaceholder: 'Nama dokumen',
                showCancelButton: true,
                confirmButtonText: 'Upload',
                cancelButtonText: 'Batal',
                inputValue: file.name.replace(/\.[^/.]+$/, ""), // File name without extension
                inputValidator: (value) => {
                    if (!value) {
                        return 'Nama dokumen harus diisi!';
                    }
                }
            });
            
            if (docName) {
                try {
                    const formData = new FormData();
                    formData.append('action', 'add_dokumen_lainnya');
                    formData.append('id_pekerjaan', idPekerjaan);
                    formData.append('nama_dokumen', docName);
                    
                    const response = await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    if (result.success) {
                        // Add to local array
                        dokumenLainnya.push({
                            id_dokumen: result.id_dokumen,
                            nama_dokumen: docName,
                            status: 'belum_upload'
                        });
                        
                        // Upload the file
                        handleFileUploadLainnya(file, result.id_dokumen);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: result.message || 'Gagal menambahkan entry dokumen'
                        });
                    }
                } catch (error) {
                    console.error('Error creating dokumen lainnya:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menambahkan entry dokumen'
                    });
                }
            }
        }
        
        // Handle file upload with progress
        function handleFileUpload(file, docId) {
            const docNum = docId.replace('doc', '');
            
            console.log('Uploading file:', file.name);
            console.log('ID Pekerjaan:', idPekerjaan);
            console.log('Doc ID:', docId);
            
            if (!idPekerjaan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID Pekerjaan tidak ditemukan di URL'
                });
                return;
            }
            
            // Show progress container
            const progressContainer = document.getElementById('progressContainer' + docNum);
            const progressBar = document.getElementById('progressBar' + docNum);
            const progressText = document.getElementById('progressText' + docNum);
            const progressFilename = document.getElementById('progressFilename' + docNum);
            
            if (progressContainer) {
                progressContainer.classList.add('active');
                progressFilename.textContent = file.name;
                progressBar.style.width = '0%';
                progressText.textContent = '0%';
            }
            
            // Use XMLHttpRequest for progress tracking
            const xhr = new XMLHttpRequest();
            const formData = new FormData();
            formData.append('action', 'upload_dokumen');
            formData.append('id_pekerjaan', idPekerjaan);
            formData.append('doc_id', docId);
            formData.append('file', file);
            
            // Track upload progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    
                    if (progressBar && progressText) {
                        progressBar.style.width = percentComplete + '%';
                        progressText.textContent = percentComplete + '%';
                    }
                    
                    console.log('Upload progress:', percentComplete + '%');
                }
            });
            
            // Handle completion
            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    try {
                        const data = JSON.parse(xhr.responseText);
                        console.log('Response data:', data);
                        
                        if (data.success) {
                            // Update local cache
                            uploadedDocs[docId] = {
                                doc_id: docId,
                                nama_dokumen: data.saved_name || file.name,
                                nama_dokumen_asli: data.file_name || file.name,
                                file_path: data.file_path,
                                status: 'sudah_upload'
                            };
                            
                            updateUIAfterUpload(parseInt(docNum), uploadedDocs[docId]);
                            updateCount();
                            
                            // Hide progress after a short delay
                            setTimeout(() => {
                                if (progressContainer) {
                                    progressContainer.classList.remove('active');
                                }
                            }, 500);
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Dokumen berhasil diupload',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            // Hide progress on error
                            if (progressContainer) {
                                progressContainer.classList.remove('active');
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Gagal mengupload dokumen.'
                            });
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        if (progressContainer) {
                            progressContainer.classList.remove('active');
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memproses respons server.'
                        });
                    }
                } else {
                    if (progressContainer) {
                        progressContainer.classList.remove('active');
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Server merespons dengan error: ' + xhr.status
                    });
                }
            });
            
            // Handle errors
            xhr.addEventListener('error', function() {
                console.error('Error uploading file');
                if (progressContainer) {
                    progressContainer.classList.remove('active');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan jaringan saat mengupload dokumen.'
                });
            });
            
            // Handle abort
            xhr.addEventListener('abort', function() {
                console.log('Upload aborted');
                if (progressContainer) {
                    progressContainer.classList.remove('active');
                }
            });
            
            // Send request
            xhr.open('POST', 'api/proses_pemeriksaan_pekerjaan.php');
            xhr.send(formData);
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', async function() {
            generateDocumentItems();
            await loadPekerjaanInfo();
        });
    </script>
</body>
</html>
