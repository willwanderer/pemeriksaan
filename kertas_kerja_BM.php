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

        .search-box {
            display: flex;
            align-items: center;
            background: #f5f6fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 15px;
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-box:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-box svg {
            width: 20px;
            height: 20px;
            fill: #999;
            margin-right: 10px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            width: 100%;
            color: #333;
        }

        .search-box input::placeholder {
            color: #aaa;
        }

        .job-name-cell {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .job-name-cell .job-name {
            font-weight: 600;
            color: #333;
        }

        .job-badges {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .job-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .job-badge.jenis {
            background: #e3f2fd;
            color: #1565c0;
        }

        .job-badge.skpd {
            background: #f3e5f5;
            color: #7b1fa2;
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
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background 0;
        }

        tbody tr:hover {
            background: #f8f9ff;
        }

        tbody td {
            padding: 15px;
            font-size: 14px;
            color: #333;
            vertical-align: top;
        }

        .category-cell {
            vertical-align: top !important;
            width: 200px;
            background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
        }

        .category-header {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .category-title {
            font-weight: 700;
            font-size: 15px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .category-count {
            font-size: 12px;
            color: #666;
        }

        .category-total {
            font-weight: 600;
            color: #667eea;
            font-size: 13px;
            margin-top: 5px;
        }

        .expand-btn {
            cursor: pointer;
            color: #667eea;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
            background: none;
            border: none;
        }

        .expand-btn:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .expand-icon {
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .expand-icon.expanded {
            transform: rotate(90deg);
        }

        .child-row {
            display: none;
        }

        .child-row.show {
            display: table-row;
        }

        .child-row td {
            background: #fafbfc;
            border-top: 1px dashed #e0e0e0;
        }

        .category-row td {
            padding: 12px 15px;
            border-bottom: 2px solid #667eea;
        }

        .detail-btn {
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

        .detail-btn svg {
            width: 18px;
            height: 18px;
        }

        .detail-btn.edit {
            color: #667eea;
        }

        .detail-btn.edit:hover {
            background: #667eea;
        }

        .detail-btn.edit:hover svg {
            fill: #fff;
        }

        .detail-btn.view {
            color: #38ef7d;
        }

        .detail-btn.view:hover {
            background: #38ef7d;
        }

        .detail-btn.view:hover svg {
            fill: #fff;
        }

        .detail-btn.delete {
            color: #e74c3c;
        }

        .detail-btn.delete:hover {
            background: #e74c3c;
        }

        .detail-btn.delete:hover svg {
            fill: #fff;
        }

        .badge-tanah { background: #fff3e0; color: #e65100; }
        .badge-peralatan { background: #e3f2fd; color: #1565c0; }
        .badge-jij { background: #e8f5e9; color: #2e7d32; }
        .badge-gedung { background: #f3e5f5; color: #7b1fa2; }
        .badge-atl { background: #fff8e1; color: #f57f17; }
        .badge-al { background: #fce4ec; color: #c2185b; }

        .no-data {
            text-align: center;
            padding: 50px;
            color: #999;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .grand-total-section {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(56, 239, 125, 0.3);
        }

        .grand-total-section h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .grand-total-section .grand-total-value {
            font-size: 24px;
            font-weight: 700;
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

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-tambah {
                width: 100%;
                justify-content: center;
            }

            thead {
                display: none;
            }

            tbody, tr, td {
                display: block;
                width: 100%;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #eee;
                border-radius: 8px;
            }

            td {
                padding: 10px 15px;
                text-align: right;
            }

            td::before {
                content: attr(data-label);
                float: left;
                font-weight: 600;
                color: #667eea;
            }
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='menu.php?id_entitas=' + new URLSearchParams(window.location.search).get('id_entitas')">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <div class="header-left">
                <h1>Kertas Kerja Belanja Modal</h1>
                <p id="entityInfo">Daftar belanja modal yang terdaftar</p>
                <br>
                <div class="search-box">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari data..." oninput="filterData()">
                </div>
            </div>
            <button class="btn-tambah" onclick="window.location.href='tambah_pekerjaan.php?id_entitas=' + getEntityId()">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Tambah Pekerjaan
            </button>
        </div>

        <div id="categorySections">
            <!-- Single table will be rendered here -->
        </div>

        <div class="grand-total-section" id="grandTotalSection" style="display: none;">
            <h3>Total Keseluruhan</h3>
            <div class="grand-total-value" id="grandTotalValue">Rp 0</div>
        </div>
    </div>

    <script>
        // Get entity ID from URL
        function getEntityId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id_entitas') || '';
        }

        // Store original data for filtering
        let allPekerjaanData = [];

        // Category configuration
        const categoryConfig = {
            'TL': { name: 'Tanah', class: 'badge-tanah', icon: '🌍' },
            'PM': { name: 'Peralatan dan Mesin', class: 'badge-peralatan', icon: '⚙️' },
            'JIJ': { name: 'Jalan, Irigasi, dan Jaringan', class: 'badge-jij', icon: '🛣️' },
            'BG': { name: 'Gedung dan Bangunan', class: 'badge-gedung', icon: '🏢' },
            'ATL': { name: 'Aset Tetap Lainnya', class: 'badge-atl', icon: '📦' },
            'AL': { name: 'Aset Lainnya', class: 'badge-al', icon: '📋' }
        };

        // Filter data based on search input
        function filterData() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            
            console.log('Search term:', searchTerm);
            
            if (!searchTerm) {
                console.log('No search term, rendering all data');
                renderPekerjaan(allPekerjaanData, true); // Show all data when search is empty
                return;
            }
            
            const filteredData = allPekerjaanData.filter(pekerjaan => {
                // Search in multiple fields
                const searchableFields = [
                    pekerjaan.nama_pekerjaan || '',
                    pekerjaan.nomor_kontrak || '',
                    pekerjaan.nama_penyedia || '',
                    pekerjaan.nama_akun_belanja || '',
                    pekerjaan.inisial_akun_belanja || '',
                    pekerjaan.skpd || '',
                    pekerjaan.tanggal_kontrak || '',
                    pekerjaan.tanggalkontrak || ''
                ];
                
                return searchableFields.some(field => 
                    field.toString().toLowerCase().includes(searchTerm)
                );
            });
            
            console.log('Filtered data count:', filteredData.length, 'expandAll: true');
            renderPekerjaan(filteredData, true); // Expand all when searching
        }

        // Load pekerjaan from database
        async function loadPekerjaan() {
            try {
                const idEntitas = getEntityId();
                
                // Load entity info if available
                if (idEntitas) {
                    const entitasResponse = await fetch('api/proses_entitas.php?id=' + idEntitas);
                    const entitasResult = await entitasResponse.json();
                    if (entitasResult.success && entitasResult.data) {
                        document.getElementById('entityInfo').textContent = entitasResult.data.nama_entitas + ' - ' + (entitasResult.data.level || '');
                    }
                }
                
                let apiUrl = 'api/proses_pekerjaan.php';
                if (idEntitas) {
                    apiUrl += '?id_entitas=' + idEntitas;
                }
                
                console.log('Fetching from:', apiUrl);
                
                const response = await fetch(apiUrl);
                const result = await response.json();
                
                console.log('API result:', result);
                
                if (result.success) {
                    allPekerjaanData = result.data || [];
                    console.log('Loaded data count:', allPekerjaanData.length);
                    if (allPekerjaanData.length > 0) {
                        console.log('First item sample:', JSON.stringify(allPekerjaanData[0]));
                    }
                    renderPekerjaan(allPekerjaanData);
                } else {
                    console.error('API error:', result.message);
                }
            } catch (error) {
                console.error('Error loading pekerjaan:', error);
            }
        }

        function renderPekerjaan(pekerjaanList, expandAll = true) {
            try {
                const container = document.getElementById('categorySections');
                const grandTotalSection = document.getElementById('grandTotalSection');
                
                console.log('Rendering pekerjaan:', pekerjaanList);
                
                if (!pekerjaanList || pekerjaanList.length === 0) {
                    container.innerHTML = '<div class="no-data">Tidak ada data pekerjaan</div>';
                    grandTotalSection.style.display = 'none';
                    return;
                }
                
                // Add OTH to category config
                categoryConfig['OTH'] = { name: 'Lainnya', class: '', icon: '📄' };
                
                // Group pekerjaan by category
                const groupedData = {};
                pekerjaanList.forEach(pekerjaan => {
                    let category = pekerjaan.inisial_akun_belanja || 'OTH';
                    // Map to predefined categories or use OTH for others
                    if (!['TL', 'PM', 'JIJ', 'BG', 'ATL', 'AL'].includes(category)) {
                        category = 'OTH'; // Other
                    }
                    if (!groupedData[category]) {
                        groupedData[category] = [];
                    }
                    groupedData[category].push(pekerjaan);
                });
                
                console.log('Grouped data:', groupedData);
                
                // Calculate grand total
                let grandTotal = 0;
                
                // Define category order
                const categoryOrder = ['TL', 'PM', 'JIJ', 'BG', 'ATL', 'AL', 'OTH'];
                
                // Build table - each category header as separate row, followed by its pekerjaan
                let html = '<div class="table-container"><table id="kertasKerjaTable"><thead><tr>';
                html += '<th style="width:50px;">No</th>';
                html += '<th>Jenis Belanja Modal</th>';
                html += '<th>Nama Pekerjaan</th>';
                html += '<th>Status</th>';
                html += '<th>Penyedia</th>';
                html += '<th>Nomor Kontrak</th>';
                html += '<th>Nilai Kontrak</th>';
                html += '<th>Tanggal Kontrak</th>';
                html += '<th>Aksi</th>';
                html += '</tr></thead><tbody>';
                
                let rowNumber = 1;
                
                categoryOrder.forEach((category) => {
                    if (!groupedData[category] || groupedData[category].length === 0) return;
                    
                    const categoryData = groupedData[category];
                    const config = categoryConfig[category] || { name: 'Lainnya', class: '', icon: '📄' };
                    
                    // Calculate category total
                    let categoryTotal = 0;
                    categoryData.forEach(pekerjaan => {
                        categoryTotal += parseFloat(pekerjaan.nilai_kontrak || pekerjaan.nilaikontrak || 0);
                    });
                    grandTotal += categoryTotal;
                    
                    const formattedTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(categoryTotal);
                    const categoryId = 'cat-' + category;
                    
                    // First row - Category header (standalone row)
                    const iconDisplay = expandAll ? '▼' : '▶';
                    html += '<tr class="category-row" style="background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);">';
                    html += '<td data-label="No" style="text-align:center;">';
                    html += '<button class="expand-btn" onclick="toggleCategory(\'' + categoryId + '\')" title="Expand/Collapse">';
                    html += '<span class="expand-icon" id="icon-' + categoryId + '">' + iconDisplay + '</span>';
                    html += '</button>';
                    html += '</td>';
                    html += '<td data-label="Jenis Belanja Modal" colspan="8" style="padding:12px 15px;">';
                    html += '<div style="display:flex;flex-wrap:nowrap;justify-content:space-between;align-items:center;width:100%;">';
                    html += '<span style="font-size:15px;font-weight:700;white-space:nowrap;margin-right:15px;">' + config.icon + ' ' + config.name + ' (' + categoryData.length + ' pekerjaan)</span>';
                    html += '<span style="font-weight:600;color:#667eea;white-space:nowrap;">Total: ' + formattedTotal + '</span>';
                    html += '</div>';
                    html += '</td></tr>';
                    
                    // Each pekerjaan as separate row
                    categoryData.forEach((pekerjaan, index) => {
                        const nilaiKontrak = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(pekerjaan.nilai_kontrak || pekerjaan.nilaikontrak || 0);
                        const tanggalKontrak = pekerjaan.tanggal_kontrak || pekerjaan.tanggalkontrak || '-';
                        
                        // When searching (expandAll=true), show all rows; otherwise show only first one
                        const displayStyle = (expandAll || index === 0) ? 'style="display:table-row;"' : 'style="display:none;"';
                        
                        html += '<tr class="child-row ' + categoryId + '"' + displayStyle + '>';
                        html += '<td data-label="No" style="text-align:center;">' + rowNumber + '</td>';
                        html += '<td data-label="Jenis Belanja Modal" style="color:#667eea;font-weight:500;">' + config.name + '</td>';
                        html += '<td data-label="Nama Pekerjaan">';
                        html += '<div class="job-name-cell">';
                        html += '<span class="job-name">' + (pekerjaan.nama_pekerjaan || '-') + '</span>';
                        if (pekerjaan.skpd) {
                            html += '<span class="job-badge skpd" style="margin-top:4px;">' + pekerjaan.skpd + '</span>';
                        }
                        html += '</div></td>';
                        
                        // Status
                        const endDate = pekerjaan.latest_addendum_end || pekerjaan.tanggal_selesai || pekerjaan.tanggal_kontrak;
                        const untilDate = pekerjaan.pho_date || new Date().toISOString().split('T')[0];
                        let keterlambatan = 0;
                        if (endDate) {
                            const end = new Date(endDate);
                            const until = new Date(untilDate);
                            const diffTime = until - end;
                            keterlambatan = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        }
                        const isCompleted = !!pekerjaan.pho_date;
                        html += '<td data-label="Status">';
                        if (isCompleted) {
                            html += '<span class="job-badge" style="background:#e8f5e9;color:#2e7d32;">Selesai</span>';
                        } else {
                            html += '<span class="job-badge" style="background:#ffebee;color:#c62828;">Terlambat ' + keterlambatan + ' hari</span>';
                        }
                        html += '</td>';
                        
                        html += '<td data-label="Penyedia">' + (pekerjaan.nama_penyedia || '-') + '</td>';
                        html += '<td data-label="Nomor Kontrak">' + (pekerjaan.nomor_kontrak || '-') + '</td>';
                        html += '<td data-label="Nilai Kontrak">' + nilaiKontrak + '</td>';
                        html += '<td data-label="Tanggal Kontrak">' + tanggalKontrak + '</td>';
                        html += '<td data-label="Aksi">';
                        html += '<button class="detail-btn edit" onclick="window.location.href=\'ubah_pekerjaan.php?id=' + pekerjaan.id_pekerjaan + '&id_entitas=' + pekerjaan.id_entitas + '\'" title="Edit">';
                        html += '<svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>';
                        html += '</button>';
                        html += '<button class="detail-btn view" onclick="window.location.href=\'detail_pekerjaan.php?id=' + pekerjaan.id_pekerjaan + '\'" title="Detail">';
                        html += '<svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>';
                        html += '</button>';
                        html += '<button class="detail-btn delete" onclick="deletePekerjaan(' + pekerjaan.id_pekerjaan + ', \'' + (pekerjaan.nama_pekerjaan || '') + '\')" title="Hapus">';
                        html += '<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>';
                        html += '</button>';
                        html += '</td></tr>';
                        
                        rowNumber++;
                    });
                });
                
                html += '</tbody></table></div>';
                
                // If no categories were rendered, show message
                if (rowNumber === 1) {
                    container.innerHTML = '<div class="no-data">Tidak ada data pekerjaan</div>';
                    grandTotalSection.style.display = 'none';
                    return;
                }
                
                container.innerHTML = html;
                
                // Show grand total
                if (grandTotal > 0) {
                    grandTotalSection.style.display = 'block';
                    document.getElementById('grandTotalValue').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(grandTotal);
                } else {
                    grandTotalSection.style.display = 'none';
                }
            } catch (error) {
                console.error('Error rendering:', error);
                const container = document.getElementById('categorySections');
                container.innerHTML = '<div class="no-data">Error rendering data: ' + error.message + '</div>';
            }
        }

        // Toggle category expand/collapse
        function toggleCategory(categoryId) {
            const icon = document.getElementById('icon-' + categoryId);
            const childRows = document.querySelectorAll('.' + categoryId);
            
            // Check current state by looking at first child row
            const firstChild = childRows[0];
            const isExpanded = firstChild.style.display !== 'none' && firstChild.style.display !== '';
            
            childRows.forEach(row => {
                if (isExpanded) {
                    row.style.display = 'none';
                    if (icon) {
                        icon.textContent = '▶';
                        icon.classList.remove('expanded');
                    }
                } else {
                    row.style.display = 'table-row';
                    if (icon) {
                        icon.textContent = '▼';
                        icon.classList.add('expanded');
                    }
                }
            });
        }

        // Delete pekerjaan
        async function deletePekerjaan(id, nama) {
            const result = await Swal.fire({
                title: 'Anda yakin?',
                text: 'Pekerjaan "' + nama + '" akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                try {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id_pekerjaan', id);

                    const response = await fetch('api/proses_pekerjaan.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire('Terhapus!', 'Pekerjaan berhasil dihapus.', 'success')
                            .then(() => loadPekerjaan());
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                }
            }
        }

        // Load on page load
        document.addEventListener('DOMContentLoaded', loadPekerjaan);

        function deleteRow(btn) {
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var row = btn.closest('tr');
                    row.remove();
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil dihapus.',
                        'success'
                    );
                }
            });
        }
    </script>
</body>
</html>
