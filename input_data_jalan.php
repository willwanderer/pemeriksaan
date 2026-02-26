<?php
// PHP Logic to handle form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    include 'includes/db_connect.php';
    
    // Get form data
    $id_pekerjaan = $_POST['id_pekerjaan'] ?? '';
    $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'] ?? '';
    $sta = $_POST['sta'] ?? '';
    $STA_type = $_POST['STA_type'] ?? 'STA';
    $jenis = $_POST['jenis'] ?? '';
    $posisi_jalan = $_POST['posisi_jalan'] ?? 'Tengah';
    
    // Convert decimal format (comma to dot) for database
    $tebal1 = isset($_POST['tebal1']) ? str_replace(',', '.', $_POST['tebal1']) : null;
    $tebal2 = isset($_POST['tebal2']) ? str_replace(',', '.', $_POST['tebal2']) : null;
    $tebal3 = isset($_POST['tebal3']) ? str_replace(',', '.', $_POST['tebal3']) : null;
    $tebal4 = isset($_POST['tebal4']) ? str_replace(',', '.', $_POST['tebal4']) : null;
    $lebarjalan = isset($_POST['lebarjalan']) ? str_replace(',', '.', $_POST['lebarjalan']) : null;
    
    $lebarkiri = $_POST['lebarkiri'] ?? null;
    $tekalkiri = $_POST['tekalkiri'] ?? null;
    $lebarkanan = $_POST['lebarkanan'] ?? null;
    $tekalkanan = $_POST['tekalkanan'] ?? null;
    $statusKesesuaian = $_POST['statusKesesuaian'] ?? 'sesuai';
    $catatan = $_POST['catatan'] ?? '';
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;
    
    // Validate required fields
    $errors = [];
    
    if (empty($id_pekerjaan)) {
        $errors[] = 'ID Pekerjaan wajib diisi';
    }
    
    if (empty($sta)) {
        $errors[] = 'STA wajib diisi';
    }
    
    if (empty($jenis)) {
        $errors[] = 'Jenis Jalan wajib diisi';
    }
    
    // Validate decimal format for tebal and lebar fields
    $decimalPattern = '/^[0-9]?[.]?[0-9]{0,2}$/';
    
    
    if (empty($errors)) {
        // Insert data into database
        try {
            $conn = getConnection();
            
            $sql = "INSERT INTO rekapan_pemeriksaan_jalan 
                    (id_pekerjaan, id_sub_pekerjaan, sta, STA_type, jenis_jalan, posisi_jalan, tebal_1, tebal_2, tebal_3, tebal_4, 
                     lebar_jalan, lebar_bahu_kiri, tebal_bahu_kiri, lebar_bahu_kanan, tebal_bahu_kanan, status_kesesuaian, 
                     catatan, latitude, longitude, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssssssssssssssd", 
                $id_pekerjaan, 
                $id_sub_pekerjaan, 
                $sta, 
                $STA_type, 
                $jenis, 
                $posisi_jalan,
                $tebal1, 
                $tebal2, 
                $tebal3, 
                $tebal4, 
                $lebarjalan, 
                $lebarkiri, 
                $tekalkiri, 
                $lebarkanan, 
                $tekalkanan, 
                $statusKesesuaian, 
                $catatan, 
                $latitude,
                $longitude
            );
            
            if ($stmt->execute()) {
                $message = 'Data jalan berhasil disimpan!';
                $messageType = 'success';
            } else {
                $message = 'Gagal menyimpan data: ' . $stmt->error;
                $messageType = 'error';
            }
            
            $stmt->close();
            $conn->close();
            
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = implode('<br>', $errors);
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.ico">
    <title>KKP Willybrodus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 700px;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
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

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #667eea;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #667eea;
        }

        .section-title:first-of-type {
            margin-top: 0;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-reset {
            background: #f1f1f1;
            color: #666;
        }

        .btn-reset:hover {
            background: #e1e1e1;
        }

        /* File Upload Styles */
        .file-input {
            padding: 10px;
            border: 2px dashed #667eea;
            background: #f8f9ff;
            cursor: pointer;
        }

        .file-input:hover {
            background: #eef0ff;
            border-color: #764ba2;
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

        /* Leaflet Map */
        #map {
            z-index: 1;
        }

        .leaflet-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .file-preview {
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

        .file-preview.active {
            display: flex;
        }

        .file-preview img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
        }

        @media (max-width: 600px) {
            .container {
                padding: 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }
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
        
        /* Radio Button Group Styles */
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
        
        /* Spinner and Loading Styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading-text {
            color: white;
            margin-top: 20px;
            font-size: 18px;
            font-weight: 600;
        }
        
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div style="text-align: center;">
            <div class="loading-spinner"></div>
            <div class="loading-text" id="loadingText">Menyimpan data...</div>
        </div>
    </div>
    
    <button class="back-btn" onclick="window.location.href='rekapan_pemeriksaan_jij.php?id_pekerjaan=' + new URLSearchParams(window.location.search).get('id_pekerjaan') + (new URLSearchParams(window.location.search).get('id_sub_pekerjaan') ? '&id_sub=' + new URLSearchParams(window.location.search).get('id_sub_pekerjaan') : '')">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Input Data Jalan</h1>
            <p id="pekerjaanName">Formulir untuk memasukkan data karakteristik jalan</p>
        </div>

        <form id="roadDataForm">
            <!-- Lokasi GPS -->
            <div class="section-title">Lokasi GPS</div>
            <div class="form-row">
                <div class="form-group">
                    <button type="button" class="btn-gps" id="getLocationBtn" onclick="getLocation()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
                        </svg>
                        Dapatkan Lokasi Saat Ini
                    </button>
                    <span id="gpsStatus" style="font-size:12px; color:#666; margin-left:10px; display: inline-block;"></span>
                </div>
            </div>
            <div class="form-row" style="display:none;">
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="number" id="latitude" name="latitude" step="0.00000001" placeholder="-5.12345678" readonly>
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="number" id="longitude" name="longitude" step="0.00000001" placeholder="119.12345678" readonly>
                </div>
            </div>
            <div class="form-group">
                <div id="map" style="height: 300px; width: 100%; border-radius: 8px; margin-top: 10px;"></div>
            </div>
            <!-- Data Utama -->
            <div class="section-title">Data Utama</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="id_sub_pekerjaan">Sub Pekerjaan</label>
                    <select id="id_sub_pekerjaan" name="id_sub_pekerjaan">
                        <option value="">Pilih Sub Pekerjaan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sta">STA</label>
                    <input type="text" id="sta" name="sta" placeholder="STA 0+000">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="display:none;">
                    <label for="STA_type">Tipe STA</label>
                    <select id="STA_type" name="STA_type">
                        <option value="STA" selected>STA</option>
                        <option value="KM">KM</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis Jalan</label>
                    <select id="jenis" name="jenis">
                        <option value="">Pilih Jenis Jalan</option>
                        <option value="AC-WC">AC-WC (Asphalt Concrete - Wearing Course)</option>
                        <option value="AC-BC">AC-BC (Asphalt Concrete - Binder Course)</option>
                        <option value="LPA">LPA (Lapisan Pondasi Agregat)</option>
                    </select>
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
            </div>
            
            <!-- Data Tebal Perkerasan -->
            <div class="section-title">Data Tebal Perkerasan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="tebal1">Tebal 1 (mm)</label>
                    <input type="text" id="tebal1" name="tebal1" class="decimal-mask" placeholder="4,0/6,0">
                </div>
                <div class="form-group">
                    <label for="tebal2">Tebal 2 (mm)</label>
                    <input type="text" id="tebal2" name="tebal2" class="decimal-mask" placeholder="4,0/6,0">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="tebal3">Tebal 3 (mm)</label>
                    <input type="text" id="tebal3" name="tebal3" class="decimal-mask" placeholder="4,0/6,0">
                </div>
                <div class="form-group">
                    <label for="tebal4">Tebal 4 (mm)</label>
                    <input type="text" id="tebal4" name="tebal4" class="decimal-mask" placeholder="4,0/6,0">
                </div>
            </div>

            <!-- Data Lebar Jalan -->
            <div class="section-title">Data Lebar Jalan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="lebarjalan">Lebar Jalan (m)</label>
                    <input type="text" id="lebarjalan" name="lebarjalan" class="decimal-mask" placeholder="3,0/4,0">
                </div>
            </div>

            <!-- Data Bahu Jalan Kiri -->
            <div class="section-title">Data Bahu Jalan Kiri</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="lebarkiri">Lebar Bahu Kiri (cm)</label>
                    <input type="number" id="lebarkiri" name="lebarkiri" step="0.01" placeholder="30">
                </div>
                <div class="form-group">
                    <label for="tekalkiri">Tebal Bahu Kiri (cm)</label>
                    <input type="number" id="tekalkiri" name="tekalkiri" step="0.01" placeholder="30">
                </div>
            </div>

            <!-- Data Bahu Jalan Kanan -->
            <div class="section-title">Data Bahu Jalan Kanan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="lebarkanan">Lebar Bahu Kanan (cm)</label>
                    <input type="number" id="lebarkanan" name="lebarkanan" step="0.01" placeholder="30">
                </div>
                <div class="form-group">
                    <label for="tekalkanan">Tebal Bahu Kanan (cm)</label>
                    <input type="number" id="tekalkanan" name="tekalkanan" step="0.01" placeholder="30">
                </div>
            </div>

            <!-- Upload Foto Jalan -->
             <div class="section-title">Kesesuaian Pekerjaan</div>
             <div class="form-row">
                <div class="form-group">
                    <label for="statusKesesuaian">Status Kesesuaian</label>
                    <select id="statusKesesuaian" name="statusKesesuaian">
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
            <div class="section-title">Upload Foto Jalan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="fotosta">Foto STA</label>
                    <input type="file" id="fotosta" name="fotosta" accept="image/*" class="file-input">
                    <div class="file-preview" id="preview-fotosta"></div>
                </div>
                <div class="form-group">
                    <label for="fotobahu">Foto Bahu</label>
                    <input type="file" id="fotobahu" name="fotobahu" accept="image/*" class="file-input">
                    <div class="file-preview" id="preview-fotobahu"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="fotobendauji">Foto Benda Uji</label>
                    <input type="file" id="fotobendauji" name="fotobendauji" accept="image/*" class="file-input">
                    <div class="file-preview" id="preview-fotobendauji"></div>
                </div>
                <div class="form-group">
                    <label for="fotolain">Foto Lainnya</label>
                    <input type="file" id="fotolain" name="fotolain" accept="image/*" class="file-input">
                    <div class="file-preview" id="preview-fotolain"></div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="btn-group">
                <button type="reset" class="btn-reset">Reset</button>
                <button type="submit" class="btn-submit">Simpan Data</button>
            </div>
        </form>
    </div>

    <script>
        // Decimal Input Mask - Format: #,## (1 digit before comma, 2 digits after) for AC-WC/AC-BC
        // Format: ##,## (2 digits before comma, 2 digits after) for LPA
        class DecimalMask {
            constructor(inputElement, format = 'short') {
                this.input = inputElement;
                this.format = format; // 'short' = #,## (for mm), 'long' = ##,## (for cm)
                this.init();
            }
            
            init() {
                // Handle input events
                this.input.addEventListener('input', (e) => this.handleInput(e));
                this.input.addEventListener('keypress', (e) => this.handleKeyPress(e));
                this.input.addEventListener('blur', (e) => this.handleBlur(e));
                this.input.addEventListener('focus', (e) => this.handleFocus(e));
            }
            
            handleKeyPress(e) {
                // Allow only digits
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
                // Select all text on focus for easy editing
                this.input.select();
            }
            
            getValue() {
                const value = this.input.value;
                if (value === '') return null;
                
                // Convert comma to dot for PHP processing
                return value.replace(',', '.');
            }
        }
        
        // Initialize decimal masks for all decimal inputs
        let decimalMasks = {};
        
        // Update thickness format based on road type
        function updateThicknessFormat(jenis) {
            const isLPA = (jenis === 'LPA');
            const format = isLPA ? 'long' : 'short';
            const unitLabel = isLPA ? 'cm' : 'mm';
            const placeholder = isLPA ? '15,00' : '4,0/6,0';
            
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
                    // Update label to show correct unit
                    if (label.textContent.includes('Tebal')) {
                        label.textContent = label.textContent.replace(/\(.*\)/, `(${unitLabel})`);
                    }
                }
            });
        }
        
        // Update thickness format based on road type
        // PHP Message handling
        const phpMessage = "<?php echo addslashes($message); ?>";
        const phpMessageType = "<?php echo $messageType; ?>";
        
        // Get id_pekerjaan and id_sub_pekerjaan from URL
        const urlParams = new URLSearchParams(window.location.search);
        const idPekerjaan = urlParams.get('id_pekerjaan');
        const idSubPekerjaan = urlParams.get('id_sub_pekerjaan');
        
        // Load pekerjaan name if available
        if (idPekerjaan) {
            loadPekerjaanName(idPekerjaan);
        }
        
        async function loadPekerjaanName(id) {
            try {
                const response = await fetch('api/get_pekerjaan.php?id=' + id);
                const result = await response.json();
                
                if (result.success && result.data) {
                    const pekerjaanName = document.getElementById('pekerjaanName');
                    if (pekerjaanName) {
                        pekerjaanName.textContent = result.data.nama_pekerjaan || 'Pekerjaan #' + id;
                    }
                }
            } catch (error) {
                console.error('Error loading pekerjaan name:', error);
            }
        }
        
        // Load sub_pekerjaan options
        async function loadSubPekerjaan(idPekerjaan) {
            try {
                const response = await fetch('api/proses_sub_pekerjaan.php?type=jalan&id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                
                const select = document.getElementById('id_sub_pekerjaan');
                select.innerHTML = '<option value="">Pilih Sub Pekerjaan</option>';
                
                if (result.success && result.data) {
                    result.data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id_sub_pekerjaan;
                        option.textContent = sub.nama_sub_pekerjaan || 'Sub Pekerjaan #' + sub.id_sub_pekerjaan;
                        if (idSubPekerjaan && idSubPekerjaan == sub.id_sub_pekerjaan) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error loading sub pekerjaan:', error);
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Display PHP message if exists
            if (phpMessage && phpMessage !== '') {
                if (phpMessageType === 'success') {
                    Swal.fire({
                        title: 'Berhasil',
                        html: phpMessage,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                } else if (phpMessageType === 'error') {
                    Swal.fire({
                        title: 'Gagal',
                        html: phpMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
            
            // Find all decimal-mask inputs and initialize them with default format (short for mm)
            const decimalInputs = document.querySelectorAll('.decimal-mask');
            decimalInputs.forEach(input => {
                decimalMasks[input.id] = new DecimalMask(input, 'short');
            });
            
            // Add change listener for jenis jalan to update mask format
            const jenisSelect = document.getElementById('jenis');
            if (jenisSelect) {
                jenisSelect.addEventListener('change', function() {
                    updateThicknessFormat(this.value);
                });
            }
            
            // Initialize map
            initMap();
            
            if (idPekerjaan) {
                loadSubPekerjaan(idPekerjaan);
            }
            
            // Check if STA is passed in URL and populate it
            const staFromUrl = urlParams.get('sta');
            if (staFromUrl) {
                document.getElementById('sta').value = staFromUrl;
                console.log('STA from URL:', staFromUrl);
            }
            
            // Auto-get GPS location on page load
            autoGetLocation();
        });
        
        async function loadPekerjaanName(id) {
            try {
                const response = await fetch('api/get_pekerjaan.php?id=' + id);
                const result = await response.json();
                
                if (result.success && result.data) {
                    const pekerjaanName = document.getElementById('pekerjaanName');
                    if (pekerjaanName) {
                        pekerjaanName.textContent = result.data.nama_pekerjaan || 'Pekerjaan #' + id;
                    }
                }
            } catch (error) {
                console.error('Error loading pekerjaan name:', error);
            }
        }
        
        // Load sub_pekerjaan options
        async function loadSubPekerjaan(idPekerjaan) {
            try {
                const response = await fetch('api/proses_sub_pekerjaan.php?type=jalan&id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                
                const select = document.getElementById('id_sub_pekerjaan');
                select.innerHTML = '<option value="">Pilih Sub Pekerjaan</option>';
                
                if (result.success && result.data) {
                    result.data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id_sub_pekerjaan;
                        option.textContent = sub.nama_sub_pekerjaan || 'Sub Pekerjaan #' + sub.id_sub_pekerjaan;
                        if (idSubPekerjaan && idSubPekerjaan == sub.id_sub_pekerjaan) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error loading sub pekerjaan:', error);
            }
        }
        
        // Initialize map
        let map, marker;
        
        function initMap() {
            // Default to Indonesia center
            map = L.map('map').setView([-5.1430, 119.4128], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
            
            // Click on map to set location
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                
                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lng.toFixed(8);
                
                setMarker(lat, lng);
            });
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
        
        // Auto-get GPS location on page load
        function autoGetLocation() {
            const statusEl = document.getElementById('gpsStatus');
            
            if (!navigator.geolocation) {
                statusEl.textContent = 'Browser tidak mendukung geolokasi';
                statusEl.style.color = '#e74c3c';
                return;
            }
            
            statusEl.textContent = 'Mendeteksi lokasi otomatis...';
            statusEl.style.color = '#666';
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    document.getElementById('latitude').value = lat.toFixed(8);
                    document.getElementById('longitude').value = lng.toFixed(8);
                    
                    if (map) {
                        setMarker(lat, lng);
                        // Zoom to user's location
                        map.setView([lat, lng], 16);
                    }
                    
                    statusEl.textContent = 'Lokasi otomatis terdeteksi!';
                    statusEl.style.color = '#27ae60';
                    
                    setTimeout(() => {
                        statusEl.textContent = '';
                    }, 5000);
                },
                function(error) {
                    let errorMessage = '';
                    let textColor = '#e74c3c';
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Izin lokasi ditolak. Klik tombol untuk mencoba lagi.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Lokasi tidak tersedia. Isi manual atau klik tombol.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Waktu habis. Isi manual atau klik tombol.';
                            break;
                        default:
                            errorMessage = 'Gagal mendapatkan lokasi otomatis.';
                    }
                    
                    statusEl.textContent = errorMessage;
                    statusEl.style.color = textColor;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 300000 // Cache location for 5 minutes
                }
            );
        }
        
        // File upload preview functionality
        const fileInputs = document.querySelectorAll('.file-input');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewId = 'preview-' + this.id;
                const preview = document.getElementById(previewId);
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                        preview.classList.add('active');
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = '';
                    preview.classList.remove('active');
                }
            });
        });
        
        // Auto-fill Status Kesesuaian based on road type and average thickness
        function calculateAverageThickness() {
            const tebal1 = parseFloat(document.getElementById('tebal1').value) || 0;
            const tebal2 = parseFloat(document.getElementById('tebal2').value) || 0;
            const tebal3 = parseFloat(document.getElementById('tebal3').value) || 0;
            const tebal4 = parseFloat(document.getElementById('tebal4').value) || 0;
            
            // Count non-zero values
            const values = [tebal1, tebal2, tebal3, tebal4].filter(v => v > 0);
            
            if (values.length === 0) return 0;
            
            // Calculate average
            const sum = values.reduce((a, b) => a + b, 0);
            return sum / values.length;
        }
        
        function updateStatusKesesuaian() {
            const jenis = document.getElementById('jenis').value;
            const avgThickness = calculateAverageThickness();
            const statusSelect = document.getElementById('statusKesesuaian');
            
            // Only auto-fill for AC-WC and AC-BC road types
            if (jenis === 'AC-WC' || jenis === 'AC-BC') {
                let status = '';
                
                if (jenis === 'AC-WC') {
                    // AC-WC: if avg thickness > 3.9 cm → "sesuai", if ≤ 3.9 cm → "tidak_sesuai"
                    if (avgThickness > 3.9) {
                        status = 'sesuai';
                    } else {
                        status = 'tidak_sesuai';
                    }
                } else if (jenis === 'AC-BC') {
                    // AC-BC: if avg thickness > 5.9 cm → "sesuai", if ≤ 5.9 cm → "tidak_sesuai"
                    if (avgThickness > 5.9) {
                        status = 'sesuai';
                    } else {
                        status = 'tidak_sesuai';
                    }
                }
                
                // Update the select value
                statusSelect.value = status;
                console.log('Auto-filled Status Kesesuaian:', status, 'for', jenis, 'with avg thickness:', avgThickness.toFixed(2), 'cm');
            }
        }
        
        // Add event listeners for real-time auto-fill
        document.getElementById('jenis').addEventListener('change', updateStatusKesesuaian);
        document.getElementById('tebal1').addEventListener('input', updateStatusKesesuaian);
        document.getElementById('tebal2').addEventListener('input', updateStatusKesesuaian);
        document.getElementById('tebal3').addEventListener('input', updateStatusKesesuaian);
        document.getElementById('tebal4').addEventListener('input', updateStatusKesesuaian);
        
        // Function to reset form except STA
        function resetFormExceptSTA(newSTA) {
            // Get current URL params
            const urlParams = new URLSearchParams(window.location.search);
            const idPekerjaanVal = urlParams.get('id_pekerjaan');
            const idSubPekerjaanVal = urlParams.get('id_sub_pekerjaan');
            
            // Build redirect URL with STA parameter
            let redirectUrl = 'input_data_jalan.php?id_pekerjaan=' + idPekerjaanVal;
            if (idSubPekerjaanVal) {
                redirectUrl += '&id_sub_pekerjaan=' + idSubPekerjaanVal;
            }
            if (newSTA) {
                redirectUrl += '&sta=' + encodeURIComponent(newSTA);
            }
            
            // Redirect to the form
            window.location.href = redirectUrl;
        }

        document.getElementById('roadDataForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!idPekerjaan) {
                Swal.fire('Error', 'ID Pekerjaan tidak ditemukan!', 'error');
                return;
            }
            
            // Validate and collect empty fields for notification
            const emptyFields = [];
            const fieldLabels = {
                'id_sub_pekerjaan': 'Sub Pekerjaan',
                'sta': 'STA',
                'jenis': 'Jenis Jalan',
                'STA_type': 'Tipe STA',
                'tebal1': 'Tebal 1',
                'tebal2': 'Tebal 2',
                'tebal3': 'Tebal 3',
                'tebal4': 'Tebal 4',
                'lebarjalan': 'Lebar Jalan',
                'lebarkiri': 'Lebar Bahu Kiri',
                'tekalkiri': 'Tebal Bahu Kiri',
                'lebarkanan': 'Lebar Bahu Kanan',
                'tekalkanan': 'Tebal Bahu Kanan',
                'statusKesesuaian': 'Status Kesesuaian',
                'catatan': 'Catatan',
                'latitude': 'Latitude',
                'longitude': 'Longitude'
            };
            
            // Check all form fields
            const form = this;
            const formData = new FormData(form);
            
            for (const [key, value] of formData.entries()) {
                if (fieldLabels[key] && (value === '' || value === null || value === undefined)) {
                    emptyFields.push(fieldLabels[key]);
                }
            }
            
            // Also check select elements that might have empty values
            const selectElements = form.querySelectorAll('select');
            selectElements.forEach(select => {
                if (select.value === '' && fieldLabels[select.name]) {
                    if (!emptyFields.includes(fieldLabels[select.name])) {
                        emptyFields.push(fieldLabels[select.name]);
                    }
                }
            });
            
            // Show warning if there are empty fields, but still allow submission
            let warningMessage = '';
            if (emptyFields.length > 0) {
                warningMessage = '\n\nField berikut tidak diisi:\n- ' + emptyFields.join('\n- ');
                console.log('Empty fields detected:', emptyFields);
            }
            
            const formDataToSend = new FormData(form);
            formDataToSend.append('type', 'jalan');
            formDataToSend.append('id_pekerjaan', idPekerjaan);
            formDataToSend.append('id_sub_pekerjaan', idSubPekerjaan || null);
            
            // Explicitly get posisi_jalan value from radio buttons
            const posisiJalanRadios = document.getElementsByName('posisi_jalan');
            let posisiJalanValue = 'Tengah';
            for (const radio of posisiJalanRadios) {
                if (radio.checked) {
                    posisiJalanValue = radio.value;
                    break;
                }
            }
            formDataToSend.set('posisi_jalan', posisiJalanValue);
            console.log('posisi_jalan value:', posisiJalanValue);
            
            // Show loading overlay
            const loadingOverlay = document.getElementById('loadingOverlay');
            const loadingText = document.getElementById('loadingText');
            loadingOverlay.classList.add('active');
            loadingText.textContent = 'Menyimpan data...';
            
            try {
                console.log('Sending data with images...');
                const response = await fetch('api/proses_rekapan.php?action=create_with_image', {
                    method: 'POST',
                    body: formDataToSend
                });
                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Response result:', result);
                
                // Hide loading overlay
                loadingOverlay.classList.remove('active');
                
                if (result.success) {
                    // Store current STA value for potential reuse
                    const currentSTA = document.getElementById('sta').value;
                    const currentJenis = document.getElementById('jenis').value;
                    
                    let successMessage = 'Data berhasil disimpan!';
                    if (emptyFields.length > 0) {
                        successMessage += '\n\nCatatan: Field berikut tidak diisi:\n- ' + emptyFields.join('\n- ');
                    }
                    
                    // Show popup with two options
                    Swal.fire({
                        title: 'Berhasil',
                        html: successMessage + '<br><br>Pilih opsi untuk melanjutkan:',
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
                            
                            // Reload page with new STA, clear other fields
                            resetFormExceptSTA(newSTA);
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // User clicked "Masih di STA saat ini" - keep same STA
                            console.log('Keeping same STA:', currentSTA);
                            resetFormExceptSTA(currentSTA);
                        }
                    });
                } else {
                    Swal.fire('Gagal', result.message || 'Gagal menyimpan data', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                // Hide loading overlay on error
                loadingOverlay.classList.remove('active');
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data. Buka console untuk detail.', 'error');
            }
        });
    </script>
</body>
</html>
