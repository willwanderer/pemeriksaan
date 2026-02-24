<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapan Pemeriksaan Peralatan Mesin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f5f6fa; min-height: 100vh; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { background: #fff; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .header-left h1 { color: #333; font-size: 24px; margin-bottom: 5px; }
        .header-left p { color: #666; font-size: 14px; }
        .btn-tambah { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; padding: 12px 25px; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; text-decoration: none; }
        .btn-tambah:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4); }
        .btn-action { background: transparent; border: none; padding: 6px; border-radius: 6px; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; justify-content: center; }
        .btn-action svg { width: 18px; height: 18px; }
        .btn-edit { color: #4caf50; }
        .btn-edit:hover { background: #4caf50; }
        .btn-edit:hover svg { fill: #fff; }
        .btn-delete { color: #e74c3c; }
        .btn-delete:hover { background: #e74c3c; }
        .btn-delete:hover svg { fill: #fff; }
        .table-container { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 1200px; }
        thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        thead th { color: #fff; padding: 12px 10px; text-align: center; font-weight: 600; font-size: 12px; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid #eee; transition: background 0.2s ease; }
        tbody tr:hover { background: #f8f9ff; }
        tbody td { padding: 12px 10px; font-size: 13px; color: #333; text-align: center; white-space: nowrap; }
        .catatan { text-align: left; max-width: 200px; }
        .status-sesuai { color: #4caf50; font-weight: 600; }
        .status-tidak-sesuai { color: #e74c3c; font-weight: 600; }
        .status-perbaikan { color: #ff9800; font-weight: 600; }
        .back-btn { position: fixed; top: 20px; left: 20px; background: #fff; border: none; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; z-index: 100; }
        .back-btn:hover { transform: scale(1.1); }
        .back-btn svg { width: 24px; height: 24px; fill: #333; }
        .filter-section { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .filter-row { display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end; }
        .filter-group { flex: 1; min-width: 200px; }
        .filter-group label { display: block; margin-bottom: 5px; color: #666; font-size: 12px; font-weight: 600; }
        .filter-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='detail_pekerjaan.php?id=' + new URLSearchParams(window.location.search).get('id')">
        <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </button>

    <div class="container">
        <div class="header">
            <div class="header-left">
                <h1>Rekapan Pemeriksaan Peralatan Mesin</h1>
                <p id="pekerjaanInfo">Belanja Modal Peralatan Mesin</p>
            </div>
            <a href="#" id="btnTambahData" class="btn-tambah">
                <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Tambah Data
            </a>
        </div>

        <div class="filter-section">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Pilih Pekerjaan</label>
                    <select id="pekerjaanSelect" onchange="loadRekapan()">
                        <option value="">-- Pilih Pekerjaan --</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Status</label>
                    <select id="statusFilter" onchange="filterData()">
                        <option value="">Semua Status</option>
                        <option value="sesuai">Sesuai</option>
                        <option value="tidak_sesuai">Tidak Sesuai</option>
                        <option value="perlu_perbaikan">Perlu Perbaikan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peralatan</th>
                        <th>Merk/Model</th>
                        <th>No. Seri</th>
                        <th>Jenis</th>
                        <th>Kondisi Umum</th>
                        <th>Kondisi Mesin</th>
                        <th>Hasil Test Run</th>
                        <th>Kesesuaian</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="rekapanBody">
                    <tr><td colspan="11" style="text-align:center;padding:50px;color:#999;">Pilih pekerjaan terlebih dahulu</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const BM_TYPE = 'peralatan';
        const API_URL = 'api/proses_rekapan.php';
        let currentData = [];
        let idPekerjaan = null;
        let idSubPekerjaan = null;
        let pekerjaanData = null;
        let subPekerjaanData = null;

        const urlParams = new URLSearchParams(window.location.search);
        idPekerjaan = urlParams.get('id');
        idSubPekerjaan = urlParams.get('id_sub');

        document.addEventListener('DOMContentLoaded', function() {
            loadPekerjaan();
            if (idPekerjaan) {
                document.getElementById('pekerjaanSelect').value = idPekerjaan;
                loadRekapan();
            }
        });

        async function loadPekerjaan() {
            try {
                const response = await fetch('api/get_pekerjaan.php?type=peralatan');
                const result = await response.json();
                if (result.success) {
                    const select = document.getElementById('pekerjaanSelect');
                    result.data.forEach(p => {
                        const option = document.createElement('option');
                        option.value = p.id_pekerjaan;
                        option.textContent = p.nama_pekerjaan;
                        select.appendChild(option);
                    });
                    
                    if (idPekerjaan) {
                        const selectedOption = select.querySelector(`option[value="${idPekerjaan}"]`);
                        if (selectedOption) {
                            loadPekerjaanDetail(idPekerjaan);
                        }
                    }
                }
            } catch (error) { console.error('Error:', error); }
        }
        
        async function loadPekerjaanDetail(id) {
            try {
                const response = await fetch('api/get_pekerjaan.php?id=' + id);
                const result = await response.json();
                if (result.success && result.data) {
                    pekerjaanData = result.data;
                    updateHeader();
                }
            } catch (error) { console.error('Error:', error); }
        }
        
        function updateHeader() {
            const headerDesc = document.getElementById('pekerjaanInfo');
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
        
        async function loadSubPekerjaanDetail(id) {
            try {
                const response = await fetch('api/proses_sub_pekerjaan.php?id=' + id);
                const result = await response.json();
                if (result.success && result.data) {
                    subPekerjaanData = result.data;
                    updateHeader();
                }
            } catch (error) { console.error('Error:', error); }
        }

        async function loadRekapan() {
            idPekerjaan = document.getElementById('pekerjaanSelect').value;
            idSubPekerjaan = urlParams.get('id_sub');
            
            // Load pekerjaan detail for header
            if (idPekerjaan) {
                loadPekerjaanDetail(idPekerjaan);
                
                // If id_sub is provided, load sub pekerjaan detail
                if (idSubPekerjaan) {
                    loadSubPekerjaanDetail(idSubPekerjaan);
                    document.getElementById('btnTambahData').href = 'input_data_peralatan.php?id_pekerjaan=' + idPekerjaan + '&id_sub_pekerjaan=' + idSubPekerjaan;
                } else {
                    document.getElementById('btnTambahData').href = 'input_data_peralatan.php?id_pekerjaan=' + idPekerjaan;
                }
            } else {
                document.getElementById('btnTambahData').href = '#';
            }
            
            if (!idPekerjaan) {
                document.getElementById('rekapanBody').innerHTML = '<tr><td colspan="11" style="text-align:center;padding:50px;color:#999;">Pilih pekerjaan terlebih dahulu</td></tr>';
                return;
            }
            try {
                const response = await fetch(`${API_URL}?type=${BM_TYPE}&id_pekerjaan=${idPekerjaan}`);
                const result = await response.json();
                if (result.success) {
                    currentData = result.data;
                    renderTable();
                }
            } catch (error) { console.error('Error:', error); }
        }

        function renderTable() {
            const statusFilter = document.getElementById('statusFilter').value;
            let filteredData = currentData;
            if (statusFilter) filteredData = currentData.filter(d => d.status_kesesuaian === statusFilter);

            if (filteredData.length === 0) {
                document.getElementById('rekapanBody').innerHTML = '<tr><td colspan="11" style="text-align:center;padding:50px;color:#999;">Belum ada data</td></tr>';
                return;
            }

            let html = '';
            filteredData.forEach((data, index) => {
                const statusClass = data.status_kesesuaian === 'sesuai' ? 'status-sesuai' : (data.status_kesesuaian === 'tidak_sesuai' ? 'status-tidak-sesuai' : 'status-perbaikan');
                const statusText = data.status_kesesuaian === 'sesuai' ? 'Sesuai' : (data.status_kesesuaian === 'tidak_sesuai' ? 'Tidak Sesuai' : 'Perlu Perbaikan');
                
                html += `<tr>
                    <td>${index + 1}</td>
                    <td>${data.nama_peralatan || '-'}</td>
                    <td>${data.merk || '-'}/${data.model || '-'}</td>
                    <td>${data.nomor_seri || '-'}</td>
                    <td>${data.jenis_peralatan || '-'}</td>
                    <td>${data.kondisi_umum || '-'}</td>
                    <td>${data.kondisi_mesin || '-'}</td>
                    <td>${data.hasil_test_run || '-'}</td>
                    <td class="${statusClass}">${statusText}</td>
                    <td class="catatan">${data.catatan || '-'}</td>
                    <td>
                        <button class="btn-action btn-edit" onclick="editData(${data.id_rekapan_peralatan})"><svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg></button>
                        <button class="btn-action btn-delete" onclick="deleteData(${data.id_rekapan_peralatan})"><svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg></button>
                    </td>
                </tr>`;
            });
            document.getElementById('rekapanBody').innerHTML = html;
        }

        function filterData() { renderTable(); }
        
        function editData(id) { window.location.href = `ubah_rekapan_peralatan.php?id=${id}&id_pekerjaan=${idPekerjaan}`; }

        async function deleteData(id) {
            const result = await Swal.fire({ title: 'Anda yakin?', text: 'Data yang dihapus tidak dapat dikembalikan!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#e74c3c', cancelButtonColor: '#3085d6', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' });
            if (result.isConfirmed) {
                try {
                    const response = await fetch(API_URL, { method: 'DELETE', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ type: BM_TYPE, id: id, id_pekerjaan: idPekerjaan }) });
                    const res = await response.json();
                    if (res.success) { Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success'); loadRekapan(); }
                    else Swal.fire('Gagal', res.message, 'error');
                } catch (error) { Swal.fire('Error', 'Gagal menghapus data', 'error'); }
            }
        }
    </script>
</body>
</html>
