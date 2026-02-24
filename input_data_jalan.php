<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Jalan</title>
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
    </style>
</head>
<body>
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
                    <label for="id_sub_pekerjaan">Sub Pekerjaan <span style="color:red">*</span></label>
                    <select id="id_sub_pekerjaan" name="id_sub_pekerjaan" required>
                        <option value="">Pilih Sub Pekerjaan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sta">STA</label>
                    <input type="text" id="sta" name="sta" placeholder="STA 0+000" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="STA_type">Tipe STA</label>
                    <select id="STA_type" name="STA_type">
                        <option value="STA">STA</option>
                        <option value="KM">KM</option>
                    </select>
                </div>
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

            
            
            

            <!-- Data Tebal Perkerasan -->
            <div class="section-title">Data Tebal Perkerasan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="tebal1">Tebal 1 (cm)</label>
                    <input type="number" id="tebal1" name="tebal1" step="0.01" placeholder="4,00/6,00" required>
                </div>
                <div class="form-group">
                    <label for="tebal2">Tebal 2 (cm)</label>
                    <input type="number" id="tebal2" name="tebal2" step="0.01" placeholder="4,00/6,00">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="tebal3">Tebal 3 (cm)</label>
                    <input type="number" id="tebal3" name="tebal3" step="0.01" placeholder="4,00/6,00">
                </div>
                <div class="form-group">
                    <label for="tebal4">Tebal 4 (cm)</label>
                    <input type="number" id="tebal4" name="tebal4" step="0.01" placeholder="4,00/6,00">
                </div>
            </div>

            <!-- Data Lebar Jalan -->
            <div class="section-title">Data Lebar Jalan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="lebarjalan">Lebar Jalan (m)</label>
                    <input type="number" id="lebarjalan" name="lebarjalan" step="0.01" placeholder="7.00" required>
                </div>
            </div>

            <!-- Data Bahu Jalan Kiri -->
            <div class="section-title">Data Bahu Jalan Kiri</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="lebarkiri">Lebar Bahu Kiri (cm)</label>
                    <input type="number" id="lebarkiri" name="lebarkiri" step="0.01" placeholder="1.50">
                </div>
                <div class="form-group">
                    <label for="tekalkiri">Tebal Bahu Kiri (cm)</label>
                    <input type="number" id="tekalkiri" name="tekalkiri" step="0.01" placeholder="25.00">
                </div>
            </div>

            <!-- Data Bahu Jalan Kanan -->
            <div class="section-title">Data Bahu Jalan Kanan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="lebarkanan">Lebar Bahu Kanan (cm)</label>
                    <input type="number" id="lebarkanan" name="lebarkanan" step="0.01" placeholder="1.50">
                </div>
                <div class="form-group">
                    <label for="tekalkanan">Tebal Bahu Kanan (cm)</label>
                    <input type="number" id="tekalkanan" name="tekalkanan" step="0.01" placeholder="25.00">
                </div>
            </div>

            <!-- Upload Foto Jalan -->
             <div class="section-title">Kesesuaian Pekerjaan</div>
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
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            
            if (idPekerjaan) {
                loadSubPekerjaan(idPekerjaan);
            }
            
            // Auto-get GPS location on page load
            autoGetLocation();
        });
        
        // Auto-get GPS location
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

        document.getElementById('roadDataForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!idPekerjaan) {
                Swal.fire('Error', 'ID Pekerjaan tidak ditemukan!', 'error');
                return;
            }
            
            const formData = new FormData(this);
            formData.append('type', 'jalan');
            formData.append('id_pekerjaan', idPekerjaan);
            formData.append('id_sub_pekerjaan', idSubPekerjaan || null);
            
            try {
                console.log('Sending data with images...');
                const response = await fetch('api/proses_rekapan.php?action=create_with_image', {
                    method: 'POST',
                    body: formData
                });
                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Response result:', result);
                
                if (result.success) {
                    Swal.fire('Berhasil', 'Data berhasil disimpan!', 'success').then(() => {
                        let redirectUrl = 'rekapan_pemeriksaan_jij.php?id_pekerjaan=' + idPekerjaan;
                        if (idSubPekerjaan) {
                            redirectUrl += '&id_sub=' + idSubPekerjaan;
                        }
                        window.location.href = redirectUrl;
                    });
                } else {
                    Swal.fire('Gagal', result.message || 'Gagal menyimpan data', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data. Buka console untuk detail.', 'error');
            }
        });
    </script>
</body>
</html>
