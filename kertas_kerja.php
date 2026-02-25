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

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pekerjaan</th>
                        <th>Jenis Belanja Modal</th>
                        <th>SKPD</th>
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
                    renderPekerjaan(result.data || []);
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
                html += '<td data-label="Nama Pekerjaan">' + (pekerjaan.nama_pekerjaan || '-') + '</td>';
                html += '<td data-label="Jenis Belanja Modal">' + (pekerjaan.nama_akun_belanja || '-') + '</td>';
                html += '<td data-label="SKPD">' + (pekerjaan.nama_entitas || '-') + '</td>';
                html += '<td data-label="Penyedia">' + (pekerjaan.nama_penyedia || '-') + '</td>';
                html += '<td data-label="Nomor Kontrak">' + (pekerjaan.nomor_kontrak || '-') + '</td>';
                html += '<td data-label="Nilai Kontrak">' + nilaiKontrak + '</td>';
                html += '<td data-label="Tanggal Kontrak">' + tanggalKontrak + '</td>';
                html += '<td data-label="Aksi">';
                html += '<button class="btn-detail" onclick="window.location.href=\'detail_pekerjaan.php?id_entitas=' + pekerjaan.id_pekerjaan + '\'" title="Detail">';
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
