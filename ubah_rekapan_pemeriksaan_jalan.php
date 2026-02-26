<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.ico">
    <title>KKP Willybrodus</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Custom spinner for fallback loading */
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
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

        /* Photo Section */
        .photo-section {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .photo-section h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .photo-section h2 svg {
            width: 24px;
            height: 24px;
            fill: #667eea;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .photo-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .photo-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }

        .photo-label {
            background: #f5f5f5;
            padding: 10px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }

        .photo-upload {
            border: 2px dashed #ccc;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 180px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .photo-upload:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .photo-upload svg {
            width: 40px;
            height: 40px;
            fill: #999;
            margin-bottom: 10px;
        }

        .photo-upload span {
            font-size: 14px;
            color: #999;
        }

        .photo-input {
            display: none;
        }

        /* Form Section */
        .form-section {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .form-section h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section h2 svg {
            width: 24px;
            height: 24px;
            fill: #667eea;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 8px 16px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .radio-label:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .radio-label input[type="radio"] {
            margin-right: 8px;
            width: 18px;
            height: 18px;
            accent-color: #667eea;
            cursor: pointer;
        }

        .radio-label input[type="radio"]:checked + .radio-text {
            color: #667eea;
            font-weight: 600;
        }

        .radio-label:has(input[type="radio"]:checked) {
            border-color: #667eea;
            background: #f0f2ff;
        }

        .radio-text {
            font-size: 14px;
            color: #333;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }


        input::placeholder {
            color: #999;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        button {
            flex: 1;
            padding: 14px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit {
            background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
            color: #fff;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(245, 124, 0, 0.4);
        }

        .btn-batal {
            background: #f1f1f1;
            color: #666;
        }

        .btn-batal:hover {
            background: #e1e1e1;
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
            z-index: 100;
        }

        .back-btn:hover {
            transform: scale(1.1);
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
            fill: #333;
        }

        .photo-preview {
            margin-top: 10px;
            width: 100%;
            min-height: 80px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            display: none;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f9f9f9;
        }

        .photo-preview.active {
            display: flex;
        }

        .photo-preview img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
        }

        .btn-gps {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-gps:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-gps:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        #map {
            z-index: 1;
        }

        .leaflet-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='rekapan_pemeriksaan_jij.php?id_pekerjaan=' + new URLSearchParams(window.location.search).get('id_pekerjaan') + (new URLSearchParams(window.location.search).get('id_sub') ? '&id_sub=' + new URLSearchParams(window.location.search).get('id_sub') : '')">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Ubah Rekapan Pemeriksaan</h1>
            <p>Formulir untuk mengubah data rekapan pemeriksaan fisik</p>
        </div>

        <!-- Photo Section - Appears First -->
        <div class="photo-section">
            <h2>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                </svg>
                Foto Dokumentasi
            </h2>
            <div class="photo-grid">
                <!-- Foto STA -->
                <div class="photo-card">
                    <div class="photo-upload photo-card" onclick="document.getElementById('foto_sta').click()">
                        <input type="file" id="foto_sta" name="foto_sta" class="photo-input" accept="image/*" onchange="previewPhoto(this, 'preview-foto_sta')">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/>
                        </svg>
                        <span>Foto STA</span>
                    </div>
                    <div class="photo-preview" id="preview-foto_sta"></div>
                </div>
                <!-- Foto Bahu -->
                <div class="photo-card">
                    <div class="photo-upload photo-card" onclick="document.getElementById('foto_bahu').click()">
                        <input type="file" id="foto_bahu" name="foto_bahu" class="photo-input" accept="image/*" onchange="previewPhoto(this, 'preview-foto_bahu')">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/>
                        </svg>
                        <span>Foto Bahu</span>
                    </div>
                    <div class="photo-preview" id="preview-foto_bahu"></div>
                </div>
                <!-- Foto Lain -->
                <div class="photo-card">
                    <div class="photo-upload photo-card" onclick="document.getElementById('foto_lain').click()">
                        <input type="file" id="foto_lain" name="foto_lain" class="photo-input" accept="image/*" onchange="previewPhoto(this, 'preview-foto_lain')">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/>
                        </svg>
                        <span>Foto Lain</span>
                    </div>
                    <div class="photo-preview" id="preview-foto_lain"></div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <h2>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
                Data Pemeriksaan
            </h2>
            <form id="rekapanForm">
                <input type="hidden" id="idrekapan" name="idrekapan">
                
                <!-- Data Utama -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="sta">STA</label>
                        <input type="text" id="sta" name="sta" placeholder="STA 0+000" required>
                    </div>
                    <div class="form-group">
                        <label for="STA_type">Tipe STA</label>
                        <select id="STA_type" name="STA_type">
                            <option value="STA">STA</option>
                            <option value="KM">KM</option>
                        </select>
                    </div>
                </div>

                <!-- Lokasi GPS (Tampilan Saja - Read Only) -->
                <div class="form-row">
                    <div class="form-group" style="display:none;">
                        <button type="button" class="btn-gps" id="getLocationBtn" onclick="getLocation()">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
                            </svg>
                            Dapatkan Lokasi Saat Ini
                        </button>
                        <span id="gpsStatus" style="font-size:12px; color:#666; margin-left:10px;"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group" style="display:none;">
                        <label for="latitude">Latitude</label>
                        <input type="number" id="latitude" name="latitude" step="0.00000001" placeholder="-5.12345678" readonly>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label for="longitude">Longitude</label>
                        <input type="number" id="longitude" name="longitude" step="0.00000001" placeholder="119.12345678" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div id="map" style="height: 300px; width: 100%; border-radius: 8px; margin-top: 10px;"></div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="jenis">Jenis Jalan</label>
                        <select id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis Jalan</option>
                            <option value="AC-WC">AC-WC (Asphalt Concrete - Wearing Course)</option>
                            <option value="AC-BC">AC-BC (Asphalt Concrete - Binder Course)</option>
                            <option value="LPA">LPA (Lapisan Pondasi Agregat)</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Posisi Jalan</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="posisi_jalan" value="Kiri">
                            <span class="radio-text">Kiri</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="posisi_jalan" value="Tengah" checked>
                            <span class="radio-text">Tengah</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="posisi_jalan" value="Kanan">
                            <span class="radio-text">Kanan</span>
                        </label>
                    </div>
                </div>

                <!-- Data Tebal Perkerasan -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="tebal1">Tebal 1 (mm)</label>
                        <input type="text" id="tebal1" name="tebal1" class="decimal-mask" placeholder="4,0">
                    </div>
                    <div class="form-group">
                        <label for="tebal2">Tebal 2 (mm)</label>
                        <input type="text" id="tebal2" name="tebal2" class="decimal-mask" placeholder="4,0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="tebal3">Tebal 3 (mm)</label>
                        <input type="text" id="tebal3" name="tebal3" class="decimal-mask" placeholder="4,0">
                    </div>
                    <div class="form-group">
                        <label for="tebal4">Tebal 4 (mm)</label>
                        <input type="text" id="tebal4" name="tebal4" class="decimal-mask" placeholder="4,0">
                    </div>
                </div>

                <!-- Data Lebar Jalan -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="lebarjalan">Lebar Jalan (m)</label>
                        <input type="number" id="lebarjalan" name="lebarjalan" step="0.01" placeholder="7.00">
                    </div>
                </div>

                <!-- Data Bahu Jalan Kiri -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="lebarkiri">Lebar Bahu Kiri (m)</label>
                        <input type="number" id="lebarkiri" name="lebarkiri" step="0.01" placeholder="1.50">
                    </div>
                    <div class="form-group">
                        <label for="tekalkiri">Tebal Bahu Kiri (cm)</label>
                        <input type="number" id="tekalkiri" name="tekalkiri" step="0.01" placeholder="25.00">
                    </div>
                </div>

                <!-- Data Bahu Jalan Kanan -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="lebarkanan">Lebar Bahu Kanan (m)</label>
                        <input type="number" id="lebarkanan" name="lebarkanan" step="0.01" placeholder="1.50">
                    </div>
                    <div class="form-group">
                        <label for="tekalkanan">Tebal Bahu Kanan (cm)</label>
                        <input type="number" id="tekalkanan" name="tekalkanan" step="0.01" placeholder="25.00">
                    </div>
                </div>

                <!-- Status & Catatan -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="statusKesesuaian">Status Kesesuaian</label>
                        <select id="statusKesesuaian" name="statusKesesuaian" required>
                            <option value="sesuai">Sesuai</option>
                            <option value="tidak_sesuai">Tidak Sesuai</option>
                            <option value="perlu_perbaikan">Perlu Perbaikan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <input type="text" id="catatan" name="catatan" placeholder="Catatan optional">
                    </div>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn-batal" onclick="window.location.href='rekapan_pemeriksaan_jij.php?id_pekerjaan=' + new URLSearchParams(window.location.search).get('id_pekerjaan')">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Configuration
        const API_URL = 'api/proses_rekapan.php';
        const BM_TYPE = 'jalan';
        
        // Decimal Input Mask - Format: #,## (1 digit before comma, 2 digits after) for AC-WC/AC-BC
        // Format: ##,## (2 digits before comma, 2 digits after) for LPA
        class DecimalMask {
            constructor(inputElement, format = 'short') {
                this.input = inputElement;
                this.format = format; // 'short' = #,## (for mm), 'long' = ##,## (for cm)
                this.init();
            }
            
            init() {
                this.input.addEventListener('input', (e) => this.handleInput(e));
                this.input.addEventListener('keypress', (e) => this.handleKeyPress(e));
                this.input.addEventListener('blur', (e) => this.handleBlur(e));
                this.input.addEventListener('focus', (e) => this.handleFocus(e));
            }
            
            handleKeyPress(e) {
                const char = String.fromCharCode(e.which);
                const allowedChars = /[0-9]/;
                
                if (!allowedChars.test(char)) {
                    e.preventDefault();
                    return false;
                }
            }
            
            handleInput(e) {
                let value = this.input.value;
                
                // Remove any non-digit characters
                value = value.replace(/[^0-9]/g, '');
                
                // Format based on type
                if (this.format === 'long') {
                    // ##,## format (2 digits before comma, 2 digits after)
                    if (value.length >= 3) {
                        const firstDigits = value.slice(0, 2);
                        const remainingDigits = value.slice(2);
                        value = firstDigits + ',' + remainingDigits;
                    }
                } else {
                    // #,## format (1 digit before comma, 2 digits after)
                    if (value.length >= 2) {
                        const firstDigit = value.charAt(0);
                        const remainingDigits = value.slice(1);
                        value = firstDigit + ',' + remainingDigits;
                    }
                }
                
                this.input.value = value;
            }
            
            handleBlur(e) {
                // Keep the format with comma as decimal separator
            }
            
            handleFocus(e) {
                this.input.select();
            }
            
            getValue() {
                const value = this.input.value;
                if (value === '') return null;
                return value.replace(',', '.');
            }
        }
        
        // Store mask instances
        let decimalMasks = {};
        
        // Initialize decimal masks for tebal inputs
        function initializeDecimalMasks() {
            const tebalInputs = ['tebal1', 'tebal2', 'tebal3', 'tebal4'];
            const currentJenis = document.getElementById('jenis')?.value || 'AC-WC';
            const format = (currentJenis === 'LPA') ? 'long' : 'short';
            
            tebalInputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    // Change from number to text type for mask
                    input.type = 'text';
                    input.removeAttribute('step');
                    input.classList.add('decimal-mask');
                    
                    // Set placeholder based on format
                    input.placeholder = (format === 'long') ? '15,00' : '4,0';
                    
                    // Create mask instance
                    decimalMasks[id] = new DecimalMask(input, format);
                }
            });
        }
        
        // Update thickness format based on road type
        function updateThicknessFormat(jenis) {
            const isLPA = (jenis === 'LPA');
            const format = isLPA ? 'long' : 'short';
            const unitLabel = isLPA ? 'cm' : 'mm';
            const placeholder = isLPA ? '15,00' : '4,0';
            
            // Update labels and placeholders
            const tebalInputs = ['tebal1', 'tebal2', 'tebal3', 'tebal4'];
            tebalInputs.forEach(id => {
                const input = document.getElementById(id);
                const label = document.querySelector(`label[for="${id}"]`);
                
                if (input) {
                    input.placeholder = placeholder;
                    // Recreate mask with new format
                    decimalMasks[id] = new DecimalMask(input, format);
                }
                
                if (label) {
                    label.textContent = label.textContent.replace(/\(.*\)/, `(${unitLabel})`);
                }
            });
        }
        
        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        const idPekerjaan = urlParams.get('id_pekerjaan');
        
        // Load data on page load
        let map, marker;
        
        document.addEventListener('DOMContentLoaded', function() {
            initMap(true); // true = read-only mode for edit page
            
            // Initialize decimal masks for tebal inputs
            initializeDecimalMasks();
            
            // Add change listener for jenis jalan to update mask format
            const jenisSelect = document.getElementById('jenis');
            if (jenisSelect) {
                jenisSelect.addEventListener('change', function() {
                    updateThicknessFormat(this.value);
                });
                // Initialize based on current selection
                updateThicknessFormat(jenisSelect.value);
            }
            
            if (id) {
                loadData(id);
            } else {
                Swal.fire('Error', 'ID tidak ditemukan', 'error').then(() => {
                    window.location.href = 'rekapan_pemeriksaan_jij.php';
                });
            }
        });
        
        function initMap(readOnly = true) {
            map = L.map('map').setView([-5.1430, 119.4128], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
            
            // Only allow click to set marker if not read-only (not used in edit mode)
            if (!readOnly) {
                map.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    
                    document.getElementById('latitude').value = lat.toFixed(8);
                    document.getElementById('longitude').value = lng.toFixed(8);
                    
                    setMarker(lat, lng);
                });
            }
        }
        
        function setMarker(lat, lng) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng], {draggable: true}).addTo(map);
            
            marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                document.getElementById('latitude').value = pos.lat.toFixed(8);
                document.getElementById('longitude').value = pos.lng.toFixed(8);
            });
            
            map.setView([lat, lng], 16);
        }
        
        // Get GPS location
        function getLocation() {
            const statusEl = document.getElementById('gpsStatus');
            const btn = document.getElementById('getLocationBtn');
            
            if (!navigator.geolocation) {
                Swal.fire('Error', 'Geolocation tidak didukung oleh browser ini', 'error');
                return;
            }
            
            btn.disabled = true;
            statusEl.textContent = 'Mendapatkan lokasi...';
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    document.getElementById('latitude').value = lat.toFixed(8);
                    document.getElementById('longitude').value = lng.toFixed(8);
                    
                    if (map) {
                        setMarker(lat, lng);
                    }
                    
                    btn.disabled = false;
                    statusEl.textContent = 'Lokasi berhasil diperoleh!';
                    
                    setTimeout(() => {
                        statusEl.textContent = '';
                    }, 3000);
                },
                function(error) {
                    btn.disabled = false;
                    statusEl.textContent = '';
                    
                    let errorMessage = 'Gagal mendapatkan lokasi';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Izin lokasi ditolak. Harap aktifkan GPS dan izinkan akses lokasi.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Informasi lokasi tidak tersedia';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Waktu habis untuk mendapatkan lokasi';
                            break;
                    }
                    
                    Swal.fire('Error', errorMessage, 'error');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }
        
        // Load existing data
        async function loadData(id) {
            try {
                const response = await fetch(`${API_URL}?type=${BM_TYPE}&id_pekerjaan=${idPekerjaan}&id=${id}`);
                const result = await response.json();
                
                if (result.success && result.data) {
                    const d = result.data;
                    
                    // Populate form fields
                    document.getElementById('idrekapan').value = d.id_rekapan_jalan;
                    document.getElementById('sta').value = d.sta || '';
                    document.getElementById('STA_type').value = d.STA_type || 'STA';
                    document.getElementById('latitude').value = d.latitude || '';
                    document.getElementById('longitude').value = d.longitude || '';
                    document.getElementById('jenis').value = d.jenis_jalan || '';
                    
                    // Set posisi_jalan radio button
                    const posisiJalan = d.posisi_jalan || 'Tengah';
                    const radioButtons = document.getElementsByName('posisi_jalan');
                    for (const radio of radioButtons) {
                        if (radio.value === posisiJalan) {
                            radio.checked = true;
                            break;
                        }
                    }
                    
                    document.getElementById('tebal1').value = d.tebal_1 || '';
                    document.getElementById('tebal2').value = d.tebal_2 || '';
                    document.getElementById('tebal3').value = d.tebal_3 || '';
                    document.getElementById('tebal4').value = d.tebal_4 || '';
                    document.getElementById('lebarjalan').value = d.lebar_jalan || '';
                    document.getElementById('lebarkiri').value = d.lebar_bahu_kiri || '';
                    document.getElementById('tekalkiri').value = d.tebal_bahu_kiri || '';
                    document.getElementById('lebarkanan').value = d.lebar_bahu_kanan || '';
                    document.getElementById('tekalkanan').value = d.tebal_bahu_kanan || '';
                    document.getElementById('statusKesesuaian').value = d.status_kesesuaian || 'sesuai';
                    document.getElementById('catatan').value = d.catatan || '';
                    
                    // Show location on map if coordinates exist
                    if (d.latitude && d.longitude) {
                        setMarker(parseFloat(d.latitude), parseFloat(d.longitude));
                    }
                    
                    // Show existing photos
                    if (d.foto_sta) {
                        showExistingPhoto(d.foto_sta, 'preview-foto_sta');
                    }
                    if (d.foto_bahu) {
                        showExistingPhoto(d.foto_bahu, 'preview-foto_bahu');
                    }
                    if (d.foto_lain) {
                        showExistingPhoto(d.foto_lain, 'preview-foto_lain');
                    }
                }
            } catch (error) {
                console.error('Error loading data:', error);
                Swal.fire('Error', 'Gagal memuat data', 'error');
            }
        }
        
        function previewPhoto(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    preview.classList.add('active');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function showExistingPhoto(path, previewId) {
            if (path) {
                const preview = document.getElementById(previewId);
                preview.innerHTML = `<img src="${path}" alt="Foto">`;
                preview.classList.add('active');
            }
        }
        
        document.getElementById('rekapanForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!id || !idPekerjaan) {
                Swal.fire('Error', 'ID tidak lengkap', 'error');
                return;
            }
            
            const formData = new FormData(this);
            formData.append('type', BM_TYPE);
            formData.append('id', id);
            formData.append('id_pekerjaan', idPekerjaan);
            
            // Explicitly get posisi_jalan value from radio buttons
            const posisiJalanRadios = document.getElementsByName('posisi_jalan');
            let posisiJalanValue = 'Tengah';
            for (const radio of posisiJalanRadios) {
                if (radio.checked) {
                    posisiJalanValue = radio.value;
                    break;
                }
            }
            formData.set('posisi_jalan', posisiJalanValue);
            
            // Get existing data for photo paths
            try {
                const existingResp = await fetch(`${API_URL}?type=${BM_TYPE}&id_pekerjaan=${idPekerjaan}&id=${id}`);
                const existingData = await existingResp.json();
                
                if (existingData.success && existingData.data) {
                    const d = existingData.data;
                    // Keep existing photo paths if no new file uploaded
                    if (!formData.get('foto_sta') || formData.get('foto_sta').size === 0) {
                        formData.set('foto_sta', d.foto_sta || '');
                    }
                    if (!formData.get('foto_bahu') || formData.get('foto_bahu').size === 0) {
                        formData.set('foto_bahu', d.foto_bahu || '');
                    }
                    if (!formData.get('foto_lain') || formData.get('foto_lain').size === 0) {
                        formData.set('foto_lain', d.foto_lain || '');
                    }
                }
            } catch (err) {
                console.error('Error fetching existing data:', err);
            }
            
            // Show SweetAlert loading animation with custom GIF
            Swal.fire({
                title: 'Memperbarui Data...',
                html: '<img src="img/load.gif" alt="Loading">',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false
            });
            
            try {
                const response = await fetch(API_URL + '?action=update_with_image', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                
                // Close SweetAlert loading
                Swal.close();
                
                if (result.success) {
                    // Store current STA value for potential reuse
                    const currentSTA = document.getElementById('sta').value;
                    
                    // Show popup with two options
                    Swal.fire({
                        title: 'Berhasil!',
                        html: 'Data berhasil diperbarui<br><br>Pilih opsi untuk melanjutkan:',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Lanjut ke STA Berikutnya',
                        cancelButtonText: 'Masih di STA saat ini',
                        reverseButtons: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User clicked "Lanjut ke STA Berikutnya" - increment STA by 100
                            let newSTA = currentSTA;
                            if (currentSTA) {
                                // Parse STA format (e.g., "0+100" or "1+500")
                                const staMatch = currentSTA.match(/^(\d+)\+(\d+)$/);
                                if (staMatch) {
                                    const prefix = parseInt(staMatch[1], 10);
                                    let suffix = parseInt(staMatch[2], 10);
                                    suffix += 100;
                                    
                                    // Handle overflow (e.g., 0+900 + 100 = 1+000)
                                    if (suffix >= 1000) {
                                        prefix += Math.floor(suffix / 1000);
                                        suffix = suffix % 1000;
                                    }
                                    newSTA = prefix + '+' + suffix.toString().padStart(3, '0');
                                } else {
                                    // Try parsing just a number
                                    const numMatch = currentSTA.match(/^(\d+)$/);
                                    if (numMatch) {
                                        newSTA = (parseInt(numMatch[1], 10) + 100).toString();
                                    }
                                }
                            }
                            console.log('Incrementing STA:', currentSTA, '->', newSTA);
                            
                            // Redirect to form with new STA
                            let redirectUrl = 'input_data_jalan.php?id_pekerjaan=' + idPekerjaan;
                            const urlSub = urlParams.get('id_sub');
                            if (urlSub) {
                                redirectUrl += '&id_sub_pekerjaan=' + urlSub;
                            }
                            if (newSTA) {
                                redirectUrl += '&sta=' + encodeURIComponent(newSTA);
                            }
                            window.location.href = redirectUrl;
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // User clicked "Masih di STA saat ini" - stay on same page
                            console.log('Keeping same STA:', currentSTA);
                            // Optionally reload the page to refresh data
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire('Gagal', result.message || 'Gagal menyimpan data', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                // Close SweetAlert loading
                Swal.close();
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        });
    </script>
</body>
</html>
