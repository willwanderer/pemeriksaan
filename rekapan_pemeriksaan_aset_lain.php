<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapan Pemeriksaan Aset Tetap Lainnya</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f5f6fa; min-height: 100vh; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { background: #fff; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .header-left h1 { color: #333; font-size: 24px; margin-bottom: 5px; }
        .header-left p { color: #666; font-size: 14px; }
        .btn-tambah { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; padding: 12px 25px; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .btn-action { background: transparent; border: none; padding: 6px; cursor: pointer; }
        .btn-action svg { width: 18px; height: 18px; }
        .btn-edit { color: #4caf50; }
        .btn-delete { color: #e74c3c; }
        .table-container { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        thead th { color: #fff; padding: 12px; text-align: center; font-weight: 600; font-size: 12px; }
        tbody tr { border-bottom: 1px solid #eee; }
        tbody tr:hover { background: #f8f9ff; }
        tbody td { padding: 12px; font-size: 13px; color: #333; text-align: center; }
        .catatan { text-align: left; max-width: 200px; }
        .status-sesuai { color: #4caf50; font-weight: 600; }
        .status-tidak-sesuai { color: #e74c3c; font-weight: 600; }
        .back-btn { position: fixed; top: 20px; left: 20px; background: #fff; border: none; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); z-index: 100; }
        .back-btn svg { width: 24px; height: 24px; fill: #333; }
        .filter-section { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .filter-row { display: flex; gap: 15px; }
        .filter-group { flex: 1; }
        .filter-group label { display: block; margin-bottom: 5px; color: #666; font-size: 12px; }
        .filter-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='detail_pekerjaan.php?id=' + new URLSearchParams(window.location.search).get('id')"><svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg></button>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <h1>Rekapan Pemeriksaan Aset Tetap Lainnya</h1>
                <p>Belanja Modal Aset Tetap Lainnya (ATL)</p>
            </div>
            <a href="#" id="btnTambahData" class="btn-tambah"><svg viewBox="0 0 24 24" width="20" height="20"><path fill="#fff" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Tambah Data</a>
        </div>
        <div class="filter-section">
            <div class="filter-row">
                <div class="filter-group"><label>Pilih Pekerjaan</label><select id="pekerjaanSelect" onchange="loadRekapan()"><option value="">-- Pilih Pekerjaan --</option></select></div>
                <div class="filter-group"><label>Status</label><select id="statusFilter" onchange="filterData()"><option value="">Semua</option><option value="sesuai">Sesuai</option><option value="tidak_sesuai">Tidak Sesuai</option></select></div>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead><tr><th>No</th><th>Nama Aset</th><th>Kode/Merk</th><th>Jenis</th><th>Kondisi</th><th>Fungsi</th><th>Kelengkapan</th><th>Kesesuaian</th><th>Catatan</th><th>Aksi</th></tr></thead>
                <tbody id="rekapanBody"><tr><td colspan="10" style="text-align:center;padding:50px;color:#999;">Pilih pekerjaan</td></tr></tbody>
            </table>
        </div>
    </div>
    <script>
        const BM_TYPE = 'aset_lain'; const API_URL = 'api/proses_rekapan.php'; let currentData = []; let idPekerjaan = null; let idSubPekerjaan = null; let pekerjaanData = null; let subPekerjaanData = null;
        const urlParams = new URLSearchParams(window.location.search); idPekerjaan = urlParams.get('id'); idSubPekerjaan = urlParams.get('id_sub');
        document.addEventListener('DOMContentLoaded', function() { loadPekerjaan(); if(idPekerjaan){document.getElementById('pekerjaanSelect').value=idPekerjaan;loadRekapan();}});
        async function loadPekerjaan(){try{const r=await fetch('api/get_pekerjaan.php?type=aset_lain');const rs=await r.json();if(rs.success){const s=document.getElementById('pekerjaanSelect');rs.data.forEach(p=>{const o=document.createElement('option');o.value=p.id_pekerjaan;o.textContent=p.nama_pekerjaan;s.appendChild(o);}); if (idPekerjaan) { const selectedOption = s.querySelector(`option[value="${idPekerjaan}"]`); if (selectedOption) { loadPekerjaanDetail(idPekerjaan); } } }}catch(e){console.error(e);}}
        async function loadPekerjaanDetail(id) { try { const response = await fetch('api/get_pekerjaan.php?id=' + id); const result = await response.json(); if (result.success && result.data) { pekerjaanData = result.data; updateHeader(); } } catch (e) { console.error(e); } }
        function updateHeader() { const headerDesc = document.querySelector('.header-left p'); if (headerDesc) { let title = ''; if (subPekerjaanData) { title = subPekerjaanData.nama_sub_pekerjaan || 'Sub Pekerjaan'; } else if (pekerjaanData) { title = pekerjaanData.nama_pekerjaan || pekerjaanData.nama_entitas || 'Pekerjaan'; } headerDesc.textContent = title; } }
        async function loadSubPekerjaanDetail(id) { try { const response = await fetch('api/proses_sub_pekerjaan.php?id=' + id); const result = await response.json(); if (result.success && result.data) { subPekerjaanData = result.data; updateHeader(); } } catch (e) { console.error(e); } }
        async function loadRekapan(){
            idPekerjaan=document.getElementById('pekerjaanSelect').value;
            idSubPekerjaan = urlParams.get('id_sub');
            
            if (idPekerjaan) {
                loadPekerjaanDetail(idPekerjaan);
                if (idSubPekerjaan) {
                    loadSubPekerjaanDetail(idSubPekerjaan);
                    document.getElementById('btnTambahData').href = 'input_data_aset_lain.php?id_pekerjaan=' + idPekerjaan + '&id_sub_pekerjaan=' + idSubPekerjaan;
                } else {
                    document.getElementById('btnTambahData').href = 'input_data_aset_lain.php?id_pekerjaan=' + idPekerjaan;
                }
            } else {
                document.getElementById('btnTambahData').href = '#';
            }
            
            if(!idPekerjaan){document.getElementById('rekapanBody').innerHTML='<tr><td colspan="10" style="text-align:center;">Pilih pekerjaan</td></tr>';return;}try{const r=await fetch(`${API_URL}?type=${BM_TYPE}&id_pekerjaan=${idPekerjaan}`);const rs=await r.json();if(rs.success){currentData=rs.data;renderTable();}}catch(e){console.error(e);}
        }
        function renderTable(){const sf=document.getElementById('statusFilter').value;const fd=sf?currentData.filter(d=>d.status_kesesuaian===sf):currentData;if(fd.length===0){document.getElementById('rekapanBody').innerHTML='<tr><td colspan="10">Belum ada data</td></tr>';return;}let h='';fd.forEach((d,i)=>{const sc=d.status_kesesuaian==='sesuai'?'status-sesuai':'status-tidak-sesuai';const st=d.status_kesesuaian==='sesuai'?'Sesuai':'Tidak Sesuai';h+=`<tr><td>${i+1}</td><td>${d.nama_aset||'-'}</td><td>${d.kode_aset||'-'}/${d.merk||'-'}</td><td>${d.jenis_aset||'-'}</td><td>${d.kondisi_umum||'-'}</td><td>${d.kondisi_fungsi||'-'}</td><td>${d.kelengkapan||'-'}</td><td class="${sc}">${st}</td><td class="catatan">${d.catatan||'-'}</td><td><button class="btn-action btn-edit" onclick="editData(${d.id_rekapan_aset_lain})"><svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg></button><button class="btn-action btn-delete" onclick="deleteData(${d.id_rekapan_aset_lain})"><svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg></button></td></tr>`;});document.getElementById('rekapanBody').innerHTML=h;}
        function filterData(){renderTable();}function editData(id){window.location.href=`ubah_rekapan_aset_lain.php?id=${id}&id_pekerjaan=${idPekerjaan}`;}
        async function deleteData(id){const r=await Swal.fire({title:'Yakin?',text:'Data dihapus tdk dpt dikembalikan!',icon:'warning',showCancelButton:true,confirmButtonText:'Hapus',cancelButtonText:'Batal'});if(r.isConfirmed){try{const rs=await fetch(API_URL,{method:'DELETE',headers:{'Content-Type':'application/json'},body:JSON.stringify({type:BM_TYPE,id:id,id_pekerjaan:idPekerjaan})});const res=await rs.json();if(res.success){Swal.fire('Terhapus','Data dihapus','success');loadRekapan();}else{Swal.fire('Gagal',res.message,'error');}}catch(e){Swal.fire('Error','Gagal menghapus','error');}}}
    </script>
</body>
</html>
