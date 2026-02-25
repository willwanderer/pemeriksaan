<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.ico">
    <title>KKP Willybrodus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
            max-width: 1200px;
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

        /* Map Section */
        .map-section {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .map-section h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .map-container {
            height: 400px;
            border-radius: 8px;
            overflow: hidden;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        /* Photo Gallery */
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
        }

        .photo-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e1e1e1;
            padding-bottom: 10px;
        }

        .photo-tab {
            padding: 10px 20px;
            background: #f1f1f1;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .photo-tab.active {
            background: #667eea;
            color: #fff;
        }

        .photo-gallery {
            display: none;
        }

        .photo-gallery.active {
            display: block;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }

        .photo-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .photo-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .photo-label {
            background: #f5f5f5;
            padding: 12px;
            font-size: 14px;
            color: #333;
            text-align: center;
            font-weight: 600;
        }

        /* Data Info */
        .data-section {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .data-section h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .data-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }

        .data-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .data-value {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .status-sesuai {
            color: #27ae60;
        }

        .status-tidak-sesuai {
            color: #e74c3c;
        }

        .status-perlu-perbaikan {
            color: #f39c12;
        }

        .loading {
            text-align: center;
            padding: 50px;
            color: #666;
        }

        .no-photo {
            text-align: center;
            padding: 30px;
            color: #999;
            background: #f9f9f9;
            border-radius: 8px;
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
            <h1>Detail Rekapan Pemeriksaan Jalan</h1>
            <p id="pageTitle">Informasi lengkap pemeriksaan fisik jalan</p>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <h2>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#667eea">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                Lokasi Pemeriksaan
            </h2>
            <div class="map-container">
                <div id="map"></div>
            </div>
            <div style="margin-top: 15px; text-align: center;">
                <strong>Koordinat:</strong> 
                <span id="coordDisplay">Loading...</span>
            </div>
        </div>

        <!-- Photo Gallery -->
        <div class="photo-section">
            <h2>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#667eea">
                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                </svg>
                Galeri Foto Pemeriksaan
            </h2>
            
            <div class="photo-tabs">
                <button class="photo-tab active" onclick="showPhotoTab('sta')">Foto STA</button>
                <button class="photo-tab" onclick="showPhotoTab('bahu')">Foto Bahu</button>
                <button class="photo-tab" onclick="showPhotoTab('lain')">Foto Lain</button>
            </div>

            <div id="gallery-sta" class="photo-gallery active">
                <div class="photo-grid" id="photoGrid-sta"></div>
            </div>
            <div id="gallery-bahu" class="photo-gallery">
                <div class="photo-grid" id="photoGrid-bahu"></div>
            </div>
            <div id="gallery-lain" class="photo-gallery">
                <div class="photo-grid" id="photoGrid-lain"></div>
            </div>
        </div>

        <!-- Data Information -->
        <div class="data-section">
            <h2>Data Pemeriksaan</h2>
            <div class="data-grid" id="dataGrid">
                <div class="loading">Memuat data...</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Configuration
        const API_URL = 'api/proses_rekapan.php';
        const BM_TYPE = 'jalan';
        
        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        const idPekerjaan = urlParams.get('id_pekerjaan');
        
        let map, marker;
        
        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            
            if (id) {
                loadData(id);
            } else {
                Swal.fire('Error', 'ID tidak ditemukan', 'error').then(() => {
                    window.location.href = 'rekapan_pemeriksaan_jij.php';
                });
            }
        });
        
        function initMap() {
            map = L.map('map').setView([-5.1430, 119.4128], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
        }
        
        function setMarker(lat, lng) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
            map.setView([lat, lng], 16);
        }
        
        // Load existing data
        async function loadData(id) {
            try {
                const response = await fetch(`${API_URL}?type=${BM_TYPE}&id_pekerjaan=${idPekerjaan}&id=${id}`);
                const result = await response.json();
                
                if (result.success && result.data) {
                    const d = result.data;
                    
                    // Update page title
                    document.getElementById('pageTitle').textContent = `STA ${d.sta} - ${d.jenis_jalan || 'Jalan'}`;
                    
                    // Display coordinates
                    const coordDisplay = document.getElementById('coordDisplay');
                    if (d.latitude && d.longitude) {
                        coordDisplay.textContent = `Lat: ${d.latitude}, Long: ${d.longitude}`;
                        setMarker(parseFloat(d.latitude), parseFloat(d.longitude));
                    } else {
                        coordDisplay.textContent = 'Koordinat tidak tersedia';
                    }
                    
                    // Display photos
                    displayPhotos(d);
                    
                    // Display data
                    displayData(d);
                }
            } catch (error) {
                console.error('Error loading data:', error);
                Swal.fire('Error', 'Gagal memuat data', 'error');
            }
        }
        
        function displayPhotos(d) {
            const staGrid = document.getElementById('photoGrid-sta');
            const bahuGrid = document.getElementById('photoGrid-bahu');
            const lainGrid = document.getElementById('photoGrid-lain');
            
            // Foto STA
            if (d.foto_sta) {
                staGrid.innerHTML = `
                    <div class="photo-card">
                        <img src="${d.foto_sta}" alt="Foto STA">
                        <div class="photo-label">Foto STA - ${d.sta}</div>
                    </div>
                `;
            } else {
                staGrid.innerHTML = '<div class="no-photo">Tidak ada foto STA</div>';
            }
            
            // Foto Bahu
            if (d.foto_bahu) {
                bahuGrid.innerHTML = `
                    <div class="photo-card">
                        <img src="${d.foto_bahu}" alt="Foto Bahu">
                        <div class="photo-label">Foto Bahu Jalan</div>
                    </div>
                `;
            } else {
                bahuGrid.innerHTML = '<div class="no-photo">Tidak ada foto bahu</div>';
            }
            
            // Foto Lain
            if (d.foto_bendauji || d.foto_lain) {
                let photosHtml = '';
                if (d.foto_bendauji) {
                    photosHtml += `
                        <div class="photo-card">
                            <img src="${d.foto_bendauji}" alt="Foto Benda Uji">
                            <div class="photo-label">Foto Benda Uji</div>
                        </div>
                    `;
                }
                if (d.foto_lain) {
                    photosHtml += `
                        <div class="photo-card">
                            <img src="${d.foto_lain}" alt="Foto Lain">
                            <div class="photo-label">Foto Lainnya</div>
                        </div>
                    `;
                }
                lainGrid.innerHTML = photosHtml;
            } else {
                lainGrid.innerHTML = '<div class="no-photo">Tidak ada foto tambahan</div>';
            }
        }
        
        function displayData(d) {
            const grid = document.getElementById('dataGrid');
            
            // Status class
            let statusClass = 'status-sesuai';
            if (d.status_kesesuaian === 'tidak_sesuai') statusClass = 'status-tidak-sesuai';
            if (d.status_kesesuaian === 'perlu_perbaikan') statusClass = 'status-perlu-perbaikan';
            
            // Status text
            let statusText = 'Sesuai';
            if (d.status_kesesuaian === 'tidak_sesuai') statusText = 'Tidak Sesuai';
            if (d.status_kesesuaian === 'perlu_perbaikan') statusText = 'Perlu Perbaikan';
            
            grid.innerHTML = `
                <div class="data-item">
                    <div class="data-label">STA</div>
                    <div class="data-value">${d.sta || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Tipe STA</div>
                    <div class="data-value">${d.STA_type || 'STA'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Jenis Jalan</div>
                    <div class="data-value">${d.jenis_jalan || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Status Kesesuaian</div>
                    <div class="data-value ${statusClass}">${statusText}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Lebar Jalan (m)</div>
                    <div class="data-value">${d.lebar_jalan || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Tebal 1 (cm)</div>
                    <div class="data-value">${d.tebal_1 || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Tebal 2 (cm)</div>
                    <div class="data-value">${d.tebal_2 || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Tebal 3 (cm)</div>
                    <div class="data-value">${d.tebal_3 || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Tebal 4 (cm)</div>
                    <div class="data-value">${d.tebal_4 || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Lebar Bahu Kiri (m)</div>
                    <div class="data-value">${d.lebar_bahu_kiri || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Lebar Bahu Kanan (m)</div>
                    <div class="data-value">${d.lebar_bahu_kanan || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Tebal Bahu Kiri (cm)</div>
                    <div class="data-value">${d.tebal_bahu_kiri || '-'}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Tebal Bahu Kanan (cm)</div>
                    <div class="data-value">${d.tebal_bahu_kanan || '-'}</div>
                </div>
                <div class="data-item" style="grid-column: 1 / -1;">
                    <div class="data-label">Catatan</div>
                    <div class="data-value">${d.catatan || 'Tidak ada catatan'}</div>
                </div>
            `;
        }
        
        function showPhotoTab(tab) {
            // Hide all galleries
            document.querySelectorAll('.photo-gallery').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.photo-tab').forEach(el => el.classList.remove('active'));
            
            // Show selected gallery
            document.getElementById('gallery-' + tab).classList.add('active');
            
            // Highlight tab
            event.target.classList.add('active');
        }
    </script>
</body>
</html>