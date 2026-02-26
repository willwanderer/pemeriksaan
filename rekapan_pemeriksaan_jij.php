<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.ico">
    <title>KKP Willybrodus</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-left h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header-left p {
            color: #666;
            font-size: 14px;
        }

        .btn-tambah {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-tambah:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-tambah svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }

        .btn-action {
            background: transparent;
            border: none;
            padding: 6px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-action svg {
            width: 18px;
            height: 18px;
        }

        .btn-edit {
            color: #4caf50;
        }

        .btn-edit:hover {
            background: #4caf50;
        }

        .btn-edit:hover svg {
            fill: #fff;
        }

        .btn-view {
            color: #2196f3;
        }

        .btn-view:hover {
            background: #2196f3;
        }

        .btn-view:hover svg {
            fill: #fff;
        }

        .btn-delete {
            color: #e74c3c;
        }

        .btn-delete:hover {
            background: #e74c3c;
        }

        .btn-delete:hover svg {
            fill: #fff;
        }

        .table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        thead th {
            color: #fff;
            padding: 12px 10px;
            text-align: center;
            font-weight: 600;
            font-size: 12px;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: #f8f9ff;
        }

        tbody td {
            padding: 12px 10px;
            font-size: 13px;
            color: #333;
            text-align: center;
            white-space: nowrap;
        }

        .no-data {
            text-align: center;
            padding: 50px;
            color: #999;
        }

        .catatan { text-align: left; max-width: 200px; }
        .status-sesuai { color: #4caf50; font-weight: 600; }
        .status-tidak-sesuai { color: #e74c3c; font-weight: 600; }
        .status-perbaikan { color: #ff9800; font-weight: 600; }

        .filter-section { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .filter-row { display: flex; gap: 15px; flex-wrap: wrap; }
        .filter-group { flex: 1; min-width: 200px; }
        .filter-group label { display: block; margin-bottom: 5px; color: #666; font-size: 12px; font-weight: 600; }
        .filter-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }

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

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-tambah {
                width: 100%;
                justify-content: center;
            }
        }
        
        .table-section {
            margin-bottom: 30px;
        }
        
        .section-header {
            color: #fff;
            padding: 12px 15px;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
        }
        
        .table-section table {
            margin-bottom: 0;
        }
        
        .table-section:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='detail_pekerjaan.php?id=' + new URLSearchParams(window.location.search).get('id_pekerjaan')">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <div class="header-left">
                <h1>Rekapan Pemeriksaan Fisik</h1>
                <p>Peningkatan Jalan Cijeruk-Cibinong - Belanja Modal Jalan, Irigasi, dan Jaringan</p>
            </div>
            <a href="#" id="btnTambahData" class="btn-tambah">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Tambah Data
            </a>
        </div>

        <div class="filter-section">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Status</label>
                    <select id="statusFilter" onchange="filterData()">
                        <option value="">Semua Status</option>
                        <option value="sesuai">Sesuai</option>
                        <option value="tidak_sesuai">Tidak Sesuai</option>
                        <option value="perbaikan">Perbaikan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-container">
            <!-- Tabel AC-BC -->
            <div class="table-section">
                <h2 class="section-header" style="background: #667eea;">Tabel Pemeriksaan AC-BC (Asphalt Concrete - Binder Course)</h2>
                <table class="data-table" id="tableACBC">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>STA</th>
                            <th>Jenis</th>
                            <th>Posisi</th>
                            <th colspan="4">Tebal (mm)</th>
                            <th>Lebar Jalan (m)</th>
                            <th>Kesesuaian</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Tebal 1</th>
                            <th>Tebal 2</th>
                            <th>Tebal 3</th>
                            <th>Tebal 4</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="rekapanBodyACBC">
                        <tr><td colspan="12" class="no-data">Tidak ada data AC-BC</td></tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Tabel AC-WC -->
            <div class="table-section">
                <h2 class="section-header" style="background: #764ba2;">Tabel Pemeriksaan AC-WC (Asphalt Concrete - Wearing Course)</h2>
                <table class="data-table" id="tableACWC">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>STA</th>
                            <th>Jenis</th>
                            <th>Posisi</th>
                            <th colspan="4">Tebal (mm)</th>
                            <th>Lebar Jalan (m)</th>
                            <th>Kesesuaian</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Tebal 1</th>
                            <th>Tebal 2</th>
                            <th>Tebal 3</th>
                            <th>Tebal 4</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="rekapanBodyACWC">
                        <tr><td colspan="12" class="no-data">Tidak ada data AC-WC</td></tr>
                    </tbody>
                </table>
            </div>
            
            
            
            <!-- Tabel Bahu Jalan -->
            <div class="table-section">
                <h2 class="section-header" style="background: #f59e0b;">Tabel Pemeriksaan Bahu Jalan</h2>
                <table class="data-table" id="tableBahu">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>STA</th>
                            <th colspan="2">Bahu Kiri</th>
                            <th colspan="2">Bahu Kanan</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Lebar (m)</th>
                            <th>Tebal (cm)</th>
                            <th>Lebar (m)</th>
                            <th>Tebal (cm)</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="rekapanBodyBahu">
                        <tr><td colspan="8" class="no-data">Tidak ada data Bahu Jalan</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabel LPA -->
            <div class="table-section">
                <h2 class="section-header" style="background: #10b981;">Tabel Pemeriksaan LPA (Lapis Permukaan Aus)</h2>
                <table class="data-table" id="tableLPA">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>STA</th>
                            <th>Jenis</th>
                            <th>Posisi</th>
                            <th colspan="4">Tebal (cm)</th>
                            <th>Lebar Jalan (m)</th>
                            <th>Kesesuaian</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Tebal 1</th>
                            <th>Tebal 2</th>
                            <th>Tebal 3</th>
                            <th>Tebal 4</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="rekapanBodyLPA">
                        <tr><td colspan="12" class="no-data">Tidak ada data LPA</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Configuration
        const BM_TYPE = 'jalan';
        const API_URL = 'api/proses_rekapan.php';
        
        let currentData = [];
        let idPekerjaan = null;
        let idSubPekerjaan = null;
        let pekerjaanData = null;
        let subPekerjaanData = null;
        
        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        idPekerjaan = urlParams.get('id_pekerjaan');
        idSubPekerjaan = urlParams.get('id_sub');
        
        console.log('URL Params:', {
            id_pekerjaan: idPekerjaan,
            id_sub: idSubPekerjaan
        });
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            if (idPekerjaan) {
                loadPekerjaanDetail(idPekerjaan);
                if (idSubPekerjaan) {
                    loadSubPekerjaanDetail(idSubPekerjaan);
                } else {
                    // No sub-pekerjaan, show empty for sub pekerjaan field
                    const subPekerjaanNameInput = document.getElementById('subPekerjaanName');
                    if (subPekerjaanNameInput) {
                        subPekerjaanNameInput.value = '-';
                    }
                }
                loadRekapan();
            }
        });
        
        // Load pekerjaan detail for header
        async function loadPekerjaanDetail(id) {
            try {
                const response = await fetch('api/get_pekerjaan.php?id=' + id);
                const result = await response.json();
                
                if (result.success && result.data) {
                    pekerjaanData = result.data;
                    const pekerjaanNameInput = document.getElementById('pekerjaanName');
                    if (pekerjaanNameInput) {
                        pekerjaanNameInput.value = pekerjaanData.nama_pekerjaan || pekerjaanData.nama_entitas || 'Pekerjaan';
                    }
                    updateHeader();
                }
            } catch (error) {
                console.error('Error loading pekerjaan detail:', error);
            }
        }
        
        // Update header with pekerjaan data
        function updateHeader() {
            if (pekerjaanData || subPekerjaanData) {
                const headerTitle = document.querySelector('.header-left h1');
                const headerDesc = document.querySelector('.header-left p');
                
                if (headerTitle) {
                    headerTitle.textContent = 'Rekapan Pemeriksaan Fisik';
                }
                if (headerDesc) {
                    let title = '';
                    if (subPekerjaanData) {
                        title = subPekerjaanData.nama_sub_pekerjaan || 'Sub Pekerjaan';
                    } else if (pekerjaanData) {
                        title = pekerjaanData.nama_pekerjaan || pekerjaanData.nama_entitas || 'Pekerjaan';
                    }
                    headerDesc.textContent = title;
                }
            }
        }
        
        // Load sub pekerjaan detail
        async function loadSubPekerjaanDetail(id) {
            try {
                const response = await fetch('api/proses_sub_pekerjaan.php?id=' + id);
                const result = await response.json();
                
                if (result.success && result.data) {
                    subPekerjaanData = result.data;
                    const subPekerjaanNameInput = document.getElementById('subPekerjaanName');
                    if (subPekerjaanNameInput) {
                        subPekerjaanNameInput.value = subPekerjaanData.nama_sub_pekerjaan || 'Sub Pekerjaan';
                    }
                    updateHeader();
                }
            } catch (error) {
                console.error('Error loading sub pekerjaan detail:', error);
            }
        }
        
        // Load rekapan data
        async function loadRekapan() {
            // Load pekerjaan detail for header
            if (idPekerjaan) {
                loadPekerjaanDetail(idPekerjaan);
                
                // If id_sub is provided, load sub pekerjaan detail
                if (idSubPekerjaan) {
                    loadSubPekerjaanDetail(idSubPekerjaan);
                    document.getElementById('btnTambahData').href = 'input_data_jalan.php?id_pekerjaan=' + idPekerjaan + '&id_sub_pekerjaan=' + idSubPekerjaan;
                } else {
                    document.getElementById('btnTambahData').href = 'input_data_jalan.php?id_pekerjaan=' + idPekerjaan;
                }
            } else {
                document.getElementById('btnTambahData').href = '#';
            }
            
            if (!idPekerjaan) {
                document.getElementById('rekapanBodyACBC').innerHTML = '<tr><td colspan="11" class="no-data">Pilih pekerjaan terlebih dahulu</td></tr>';
                document.getElementById('rekapanBodyACWC').innerHTML = '<tr><td colspan="11" class="no-data">Pilih pekerjaan terlebih dahulu</td></tr>';
                document.getElementById('rekapanBodyBahu').innerHTML = '<tr><td colspan="8" class="no-data">Pilih pekerjaan terlebih dahulu</td></tr>';
                return;
            }
            
            try {
                let apiUrl = `${API_URL}?type=${BM_TYPE}&id_pekerjaan=${idPekerjaan}`;
                if (idSubPekerjaan) {
                    apiUrl += `&id_sub_pekerjaan=${idSubPekerjaan}`;
                }
                console.log('Loading from:', apiUrl);
                const response = await fetch(apiUrl);
                const result = await response.json();
                console.log('API Result:', result);
                
                if (result.success) {
                    currentData = result.data;
                    renderTable();
                } else {
                    document.getElementById('rekapanBodyACBC').innerHTML = '<tr><td colspan="11" class="no-data">' + (result.message || 'Data tidak ditemukan') + '</td></tr>';
                    document.getElementById('rekapanBodyACWC').innerHTML = '<tr><td colspan="11" class="no-data">' + (result.message || 'Data tidak ditemukan') + '</td></tr>';
                    document.getElementById('rekapanBodyBahu').innerHTML = '<tr><td colspan="8" class="no-data">' + (result.message || 'Data tidak ditemukan') + '</td></tr>';
                }
            } catch (error) {
                console.error('Error loading rekapan:', error);
                document.getElementById('rekapanBodyACBC').innerHTML = '<tr><td colspan="11" class="no-data">Error: ' + error.message + '</td></tr>';
                document.getElementById('rekapanBodyACWC').innerHTML = '<tr><td colspan="11" class="no-data">Error: ' + error.message + '</td></tr>';
                document.getElementById('rekapanBodyBahu').innerHTML = '<tr><td colspan="8" class="no-data">Error: ' + error.message + '</td></tr>';
            }
        }
        
        // Render table
        function renderTable() {
            const statusFilter = document.getElementById('statusFilter').value;
            let filteredData = currentData;
            
            if (statusFilter) {
                filteredData = currentData.filter(d => d.status_kesesuaian === statusFilter);
            }
            
            if (filteredData.length === 0) {
                document.getElementById('rekapanBodyACBC').innerHTML = '<tr><td colspan="11" class="no-data">Tidak ada data AC-BC</td></tr>';
                document.getElementById('rekapanBodyACWC').innerHTML = '<tr><td colspan="11" class="no-data">Tidak ada data AC-WC</td></tr>';
                document.getElementById('rekapanBodyBahu').innerHTML = '<tr><td colspan="8" class="no-data">Tidak ada data Bahu Jalan</td></tr>';
                return;
            }
            
            // Filter data for each table
            // AC-BC: jenis_jalan = 'AC-BC'
            const acbcData = filteredData.filter(d => d.jenis_jalan === 'AC-BC');
            // AC-WC: jenis_jalan = 'AC-WC'
            const acwcData = filteredData.filter(d => d.jenis_jalan === 'AC-WC');
            // LPA: jenis_jalan = 'LPA'
            const lpaData = filteredData.filter(d => d.jenis_jalan === 'LPA');
            // Bahu Jalan: has value in any bahu field (lebar_bahu_kiri, tebal_bahu_kiri, lebar_bahu_kanan, tebal_bahu_kanan)
            const bahuData = filteredData.filter(d => 
                (d.lebar_bahu_kiri && d.lebar_bahu_kiri > 0) ||
                (d.tebal_bahu_kiri && d.tebal_bahu_kiri > 0) ||
                (d.lebar_bahu_kanan && d.lebar_bahu_kanan > 0) ||
                (d.tebal_bahu_kanan && d.tebal_bahu_kanan > 0)
            );
            
            // Render AC-BC table
            if (acbcData.length === 0) {
                document.getElementById('rekapanBodyACBC').innerHTML = '<tr><td colspan="12" class="no-data">Tidak ada data AC-BC</td></tr>';
            } else {
                let html = '';
                acbcData.forEach((data, index) => {
                    html += renderRowAC(data, index);
                });
                document.getElementById('rekapanBodyACBC').innerHTML = html;
            }
            
            // Render AC-WC table
            if (acwcData.length === 0) {
                document.getElementById('rekapanBodyACWC').innerHTML = '<tr><td colspan="12" class="no-data">Tidak ada data AC-WC</td></tr>';
            } else {
                let html = '';
                acwcData.forEach((data, index) => {
                    html += renderRowAC(data, index);
                });
                document.getElementById('rekapanBodyACWC').innerHTML = html;
            }
            
            // Render LPA table
            if (lpaData.length === 0) {
                document.getElementById('rekapanBodyLPA').innerHTML = '<tr><td colspan="12" class="no-data">Tidak ada data LPA</td></tr>';
            } else {
                let html = '';
                lpaData.forEach((data, index) => {
                    html += renderRowAC(data, index);
                });
                document.getElementById('rekapanBodyLPA').innerHTML = html;
            }
            
            // Render Bahu Jalan table
            if (bahuData.length === 0) {
                document.getElementById('rekapanBodyBahu').innerHTML = '<tr><td colspan="8" class="no-data">Tidak ada data Bahu Jalan</td></tr>';
            } else {
                let html = '';
                bahuData.forEach((data, index) => {
                    html += renderRowBahu(data, index);
                });
                document.getElementById('rekapanBodyBahu').innerHTML = html;
            }
        }
        
        // Render row for AC-BC and AC-WC tables
        function renderRowAC(data, index) {
            const statusClass = getStatusClass(data.status_kesesuaian);
            const statusText = getStatusText(data.status_kesesuaian);
            
            return `
                <tr data-id="${data.id_rekapan_jalan}">
                    <td>${index + 1}</td>
                    <td>${data.sta || '-'}</td>
                    <td>${data.jenis_jalan || '-'}</td>
                    <td>${data.posisi_jalan || '-'}</td>
                    <td>${formatNumber(data.tebal_1)}</td>
                    <td>${formatNumber(data.tebal_2)}</td>
                    <td>${formatNumber(data.tebal_3)}</td>
                    <td>${formatNumber(data.tebal_4)}</td>
                    <td>${formatNumber(data.lebar_jalan)}</td>
                    <td class="${statusClass}">${statusText}</td>
                    <td class="catatan">${data.catatan || '-'}</td>
                    <td>
                        <button class="btn-action btn-view" onclick="viewData(${data.id_rekapan_jalan})" title="Lihat">
                            <svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        </button>
                        <button class="btn-action btn-edit" onclick="editData(${data.id_rekapan_jalan})" title="Edit">
                            <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <button class="btn-action btn-delete" onclick="deleteData(${data.id_rekapan_jalan})" title="Hapus">
                            <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                        </button>
                    </td>
                </tr>
            `;
        }
        
        // Render row for Bahu Jalan table
        function renderRowBahu(data, index) {
            return `
                <tr data-id="${data.id_rekapan_jalan}">
                    <td>${index + 1}</td>
                    <td>${data.sta || '-'}</td>
                    <td>${formatNumber(data.lebar_bahu_kiri)}</td>
                    <td>${formatNumber(data.tebal_bahu_kiri)}</td>
                    <td>${formatNumber(data.lebar_bahu_kanan)}</td>
                    <td>${formatNumber(data.tebal_bahu_kanan)}</td>
                    <td class="catatan">${data.catatan || '-'}</td>
                    <td>
                        <button class="btn-action btn-view" onclick="viewData(${data.id_rekapan_jalan})" title="Lihat">
                            <svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        </button>
                        <button class="btn-action btn-edit" onclick="editData(${data.id_rekapan_jalan})" title="Edit">
                            <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <button class="btn-action btn-delete" onclick="deleteData(${data.id_rekapan_jalan})" title="Hapus">
                            <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                        </button>
                    </td>
                </tr>
            `;
        }
        
        // Filter data
        function filterData() {
            renderTable();
        }
        
        // Edit data
        function editData(id) {
            window.location.href = `ubah_rekapan_pemeriksaan_jalan.php?id=${id}&id_pekerjaan=${idPekerjaan}` + (idSubPekerjaan ? `&id_sub=${idSubPekerjaan}` : '');
        }
        
        // View data details - redirect to full view page
        function viewData(id) {
            window.location.href = `lihat_rekapan_pemeriksaan_jalan.php?id=${id}&id_pekerjaan=${idPekerjaan}` + (idSubPekerjaan ? `&id_sub=${idSubPekerjaan}` : '');
        }
        
        // Delete data
        async function deleteData(id) {
            const result = await Swal.fire({
                title: 'Anda yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            });
            
            if (result.isConfirmed) {
                try {
                    const response = await fetch(API_URL, {
                        method: 'DELETE',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ type: BM_TYPE, id: id, id_pekerjaan: idPekerjaan })
                    });
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                        loadRekapan();
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                }
            }
        }
        
        // Helper functions
        function getStatusClass(status) {
            if (status === 'sesuai') return 'status-sesuai';
            if (status === 'tidak_sesuai') return 'status-tidak-sesuai';
            return 'status-perbaikan';
        }
        
        function getStatusText(status) {
            if (status === 'sesuai') return 'Sesuai';
            if (status === 'tidak_sesuai') return 'Tidak Sesuai';
            return 'Perlu Perbaikan';
        }
        
        function formatNumber(num) {
            if (!num) return '-';
            return parseFloat(num).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    </script>
</body>
</html>
