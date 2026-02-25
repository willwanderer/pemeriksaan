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
            max-width: 1200px;
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
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: #f8f9ff;
        }

        tbody td {
            padding: 15px;
            font-size: 14px;
            color: #333;
        }

        .btn-detail, .btn-delete {
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

        .btn-detail svg, .btn-delete svg {
            width: 18px;
            height: 18px;
        }

        .btn-detail {
            color: #667eea;
        }

        .btn-detail:hover {
            background: #667eea;
        }

        .btn-detail:hover svg {
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

        .no-data {
            text-align: center;
            padding: 50px;
            color: #999;
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
            </div>
            <button class="btn-tambah" onclick="window.location.href='tambah_pekerjaan.php?id_entitas=' + getEntityId()">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Tambah Pekerjaan
            </button>
        </div>
        <div class="header">
            <div class="search-box">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari data..." oninput="filterData()">
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pekerjaan</th>
                        <th>Status</th>
                        <th>Penyedia</th>
                        <th>Nomor Kontrak</th>
                        <th>Nilai Kontrak</th>
                        <th>Tanggal Kontrak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="pekerjaanTableBody">
                    <!-- Data will be loaded from database -->
                </tbody>
                            
                </tbody>
            </table>
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

        // Filter data based on search input
        function filterData() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            
            if (!searchTerm) {
                renderPekerjaan(allPekerjaanData);
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
            
            renderPekerjaan(filteredData);
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
                
                const response = await fetch(apiUrl);
                const result = await response.json();
                
                if (result.success) {
                    allPekerjaanData = result.data || [];
                    renderPekerjaan(allPekerjaanData);
                }
            } catch (error) {
                console.error('Error loading pekerjaan:', error);
            }
        }

        function renderPekerjaan(pekerjaanList) {
            const tbody = document.getElementById('pekerjaanTableBody');
            
            if (pekerjaanList.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 30px;">Tidak ada data pekerjaan</td></tr>';
                return;
            }
            
            let html = '';
            pekerjaanList.forEach((pekerjaan, index) => {
                const nilaiKontrak = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(pekerjaan.nilai_kontrak || pekerjaan.nilaikontrak || 0);
                const tanggalKontrak = pekerjaan.tanggal_kontrak || pekerjaan.tanggalkontrak || '-';
                
                html += '<tr>';
                html += '<td data-label="No">' + (index + 1) + '</td>';
                html += '<td data-label="Nama Pekerjaan">';
                html += '<div class="job-name-cell">';
                html += '<span class="job-name">' + (pekerjaan.nama_pekerjaan || '-') + '</span>';
                html += '<div class="job-badges">';
                if (pekerjaan.nama_akun_belanja || pekerjaan.inisial_akun_belanja) {
                    html += '<span class="job-badge jenis">' + (pekerjaan.nama_akun_belanja || pekerjaan.inisial_akun_belanja || '') + '</span>';
                }
                if (pekerjaan.skpd) {
                    html += '<span class="job-badge skpd">' + pekerjaan.skpd + '</span>';
                }
                html += '</div></div></td>';
                
                // Status badge - based on PHO
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
                html += '<button class="btn-detail" onclick="window.location.href=\'ubah_pekerjaan.php?id=' + pekerjaan.id_pekerjaan + '&id_entitas=' + pekerjaan.id_entitas + '\'" title="Edit">';
                html += '<svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>';
                html += '</button>';
                html += '<button class="btn-detail" onclick="window.location.href=\'detail_pekerjaan.php?id=' + pekerjaan.id_pekerjaan + '\'" title="Detail">';
                html += '<svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>';
                html += '</button>';
                html += '<button class="btn-delete" onclick="deletePekerjaan(' + pekerjaan.id_pekerjaan + ', \'' + (pekerjaan.nama_pekerjaan || '') + '\')" title="Hapus">';
                html += '<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>';
                html += '</button>';
                html += '</td></tr>';
            });
            
            tbody.innerHTML = html;
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
