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
        /* Global Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f5f6fa; min-height: 100vh; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: #fff; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .header h1 { color: #333; font-size: 24px; margin-bottom: 5px; }
        .header p { color: #666; font-size: 14px; }
        
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; padding-top: 20px; border-top: 1px solid #eee; margin-top: 15px; }
        .info-item label { display: block; font-size: 12px; color: #999; margin-bottom: 4px; text-transform: uppercase; }
        .info-item span { font-size: 14px; color: #333; font-weight: 500; }
        
        .card { background: #fff; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .card-title { font-size: 18px; font-weight: 700; color: #333; margin-bottom: 20px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; font-size: 14px; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; }
        .form-control:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        select.form-control { background: #fff; cursor: pointer; }
        textarea.form-control { min-height: 100px; resize: vertical; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .form-actions { display: flex; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid #e2e8f0; margin-top: 20px; }
        .btn-cancel { padding: 12px 24px; border: 2px solid #e2e8f0; border-radius: 8px; background: #fff; color: #64748b; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-cancel:hover { border-color: #cbd5e0; background: #f8fafc; }
        .btn-submit { padding: 12px 24px; border: none; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.45); }
        
        .back-btn { position: fixed; top: 20px; left: 20px; background: #fff; border: none; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; z-index: 100; }
        .back-btn:hover { transform: scale(1.1); }
        .back-btn svg { width: 24px; height: 24px; fill: #333; }
        
        /* Switch Button Styles */
        .switch-container { display: flex; align-items: center; gap: 12px; }
        .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .3s; border-radius: 24px; }
        .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .switch input:checked + .slider { background-color: #4caf50; }
        .switch input:checked + .slider:before { transform: translateX(20px); }
        
        .keterlambatan-info { background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); border-radius: 12px; padding: 20px; color: #fff; margin-bottom: 20px; }
        .keterlambatan-info label { font-size: 12px; opacity: 0.9; display: block; margin-bottom: 8px; }
        .keterlambatan-info .value { font-size: 32px; font-weight: 700; }
        
        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column-reverse; }
            .btn-cancel, .btn-submit { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='detail_pekerjaan.php?id=' + idPekerjaan">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1 id="pageTitle">Tambah Denda Keterlambatan</h1>
            <p>Hitung denda keterlambatan pekerjaan</p>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nama Pekerjaan</label>
                    <span id="pekerjaanNama">-</span>
                </div>
                <div class="info-item">
                    <label>Nomor Kontrak</label>
                    <span id="nomorKontrak">-</span>
                </div>
                <div class="info-item">
                    <label>Penyedia</label>
                    <span id="penyediaNama">-</span>
                </div>
                <div class="info-item">
                    <label>Nilai Kontrak</label>
                    <span id="nilaiKontrak">-</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="keterlambatan-info">
                <label>Keterlambatan</label>
                <div class="value" id="keterlambatanHari">0 Hari</div>
            </div>

            <form id="dendaForm">
                <!-- Form untuk Keseluruhan Nilai Kontrak -->
                <div class="form-grid">
                    <div class="form-group">
                        <label>Besaran Denda (per hari)</label>
                        <input type="number" id="besaran_denda" class="form-control" value="0.001" step="0.0001" min="0" onchange="calculateDenda()">
                        <small style="color: #666; font-size: 11px;">Default 1/1000 = 0.001</small>
                    </div>
                    <div class="form-group">
                        <label>Dasar Pengenaan (Rp)</label>
                        <input type="text" id="dasar_pengenaan" class="form-control" onchange="calculateDenda()" onkeyup="formatCurrency(this)">
                        <small style="color: #666; font-size: 11px;">Nilai kontrak atau addendum terakhir</small>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Persentase (%)</label>
                        <input type="number" id="persentase" class="form-control" value="100" min="0" max="100" onchange="calculateDenda()">
                    </div>
                    <div class="form-group">
                        <label>Jumlah Hari Keterlambatan</label>
                        <input type="number" id="jumlah_hari" class="form-control" min="0" onchange="calculateDenda()">
                    </div>
                </div>
                <div class="form-group">
                    <label>Nilai Denda (Rp)</label>
                    <input type="text" id="nilai_denda" class="form-control" readonly style="background: #e8f5e9; font-weight: 700; font-size: 18px; color: #2e7d32;">
                </div>
                
                <div class="form-group" style="margin-top: 20px;">
                    <div class="switch-container">
                        <label>SK Denda Sudah Ditetapkan</label>
                        <label class="switch">
                            <input type="checkbox" id="sk_denda_ditetapkan" onchange="updateSkStatusText()">
                            <span class="slider"></span>
                        </label>
                        <span id="sk_status_text" style="font-weight: normal; color: #666;">Belum</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Upload Kertas Kerja</label>
                    <input type="file" id="kertas_kerja" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx">
                    <div id="kertas_kerja_info" style="margin-top: 8px; display: none;">
                        <span id="kertas_kerja_name" style="font-size: 12px; color: #667eea;"></span>
                        <button type="button" onclick="removeKertasKerja()" style="margin-left: 10px; color: #dc3545; background: none; border: none; cursor: pointer; font-size: 12px;">Hapus</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea id="catatan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                </div>
                
                <div class="form-actions">
                    <a href="#" id="btnBatal" class="btn-cancel">Batal</a>
                    <button type="button" class="btn-submit" onclick="saveDenda()">Simpan Denda</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let idPekerjaan = null;
        let idDenda = null; // For edit mode
        let pekerjaanData = null;
        let keterlambatanHari = 0;
        
        // Get pekerjaan ID and denda ID from URL
        function getUrlParams() {
            const urlParams = new URLSearchParams(window.location.search);
            return {
                id_pekerjaan: urlParams.get('id'),
                id_denda: urlParams.get('edit')
            };
        }
        
        // Format currency
        function formatRupiah(value) {
            const num = parseFloat(value);
            if (isNaN(num) || num === 0) return 'Rp 0';
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(num);
        }
        
        // Parse Rupiah to number
        function parseRupiah(str) {
            if (!str) return 0;
            return parseInt(str.replace(/[^0-9]/g, '')) || 0;
        }
        
        // Format currency input
        function formatCurrency(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
            }
            input.value = value;
        }
        
        // Load pekerjaan details
        async function loadPekerjaanDetails() {
            const params = getUrlParams();
            idPekerjaan = params.id_pekerjaan;
            idDenda = params.id_denda;
            
            if (!idPekerjaan) {
                Swal.fire('Error', 'ID Pekerjaan tidak ditemukan', 'error');
                return;
            }
            
            // Update back button link
            document.getElementById('btnBatal').href = 'detail_pekerjaan.php?id=' + idPekerjaan;
            
            try {
                const response = await fetch('api/proses_pekerjaan.php?id=' + idPekerjaan);
                const result = await response.json();
                
                if (result.success && result.data) {
                    pekerjaanData = result.data;
                    const p = result.data;
                    
                    // Update header info
                    document.getElementById('pekerjaanNama').textContent = p.nama_pekerjaan || '-';
                    document.getElementById('nomorKontrak').textContent = p.nomor_kontrak || '-';
                    document.getElementById('penyediaNama').textContent = p.nama_penyedia || '-';
                    document.getElementById('nilaiKontrak').textContent = formatRupiah(p.nilai_kontrak || p.nilaikontrak || 0);
                    
                    // Calculate keterlambatan
                    const endDate = p.latest_addendum_end || p.tanggal_selesai || p.tanggal_kontrak;
                    const untilDate = p.pho_date || new Date().toISOString().split('T')[0];
                    
                    keterlambatanHari = 0;
                    if (endDate) {
                        const end = new Date(endDate);
                        const until = new Date(untilDate);
                        const diffTime = until - end;
                        keterlambatanHari = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    }
                    
                    document.getElementById('keterlambatanHari').textContent = keterlambatanHari + ' Hari';
                    document.getElementById('jumlah_hari').value = keterlambatanHari > 0 ? keterlambatanHari : 0;
                    
                    // Check if denda already exists for this pekerjaan
                    // If exists, use database data. If not, use addendum/contract data
                    await checkExistingDenda();
                } else {
                    Swal.fire('Error', 'Pekerjaan tidak ditemukan', 'error');
                }
            } catch (error) {
                console.error('Error loading pekerjaan:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat memuat data', 'error');
            }
        }
        
        // Check if denda already exists for this pekerjaan
        async function checkExistingDenda() {
            try {
                const response = await fetch('api/proses_pemeriksaan_pekerjaan.php?action=get_denda&id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                
                if (result.success && result.data) {
                    // Denda already exists - use database data
                    console.log('Existing denda found:', result.data);
                    loadDendaFromDatabase(result.data);
                } else {
                    // No existing denda - use addendum/contract defaults
                    console.log('No existing denda, using defaults');
                    loadDendaDefaults();
                }
            } catch (error) {
                console.error('Error checking existing denda:', error);
                // On error, try to use defaults
                loadDendaDefaults();
            }
        }
        
        // Load denda data from database (for reference/pre-population, not for editing)
        function loadDendaFromDatabase(denda) {
            // Keep page title as "Tambah" to allow adding new records
            // document.getElementById('pageTitle').textContent = 'Edit Denda Keterlambatan';
            
            // Do NOT set idDenda - this allows saving as new record
            // idDenda = denda.id_denda;
            
            // Fill form with existing data as reference
            document.getElementById('besaran_denda').value = denda.besaran_denda || 0.001;
            document.getElementById('dasar_pengenaan').value = parseFloat(denda.dasar_pengenaan || 0).toLocaleString('id-ID');
            document.getElementById('persentase').value = denda.persentase || 100;
            document.getElementById('jumlah_hari').value = denda.jumlah_hari_keterlambatan || 0;
            document.getElementById('nilai_denda').value = formatRupiah(denda.nilai_denda || 0);
            document.getElementById('sk_denda_ditetapkan').checked = denda.sk_denda_ditetapkan == 1;
            document.getElementById('catatan').value = denda.catatan || '';
            
            updateSkStatusText();
            
            // Show kertas kerja info if exists
            if (denda.kertas_kerja_path) {
                document.getElementById('kertas_kerja_info').style.display = 'block';
                document.getElementById('kertas_kerja_name').textContent = denda.kertas_kerja_path.split('/').pop();
            }
            
            // Show info message
            Swal.fire({
                title: 'Denda Sudah Ada',
                text: 'Data denda sebelumnya telah dimuat. Simpan untuk menambahkan denda baru.',
                icon: 'info',
                timer: 3000,
                showConfirmButton: false
            });
        }
        
        // Load default values from addendum or contract
        function loadDendaDefaults() {
            // Use nilai from addendum if exists, otherwise use nilai kontrak
            let nilaiDasar = 0;
            if (pekerjaanData.latest_addendum_nilai && parseFloat(pekerjaanData.latest_addendum_nilai) > 0) {
                nilaiDasar = parseFloat(pekerjaanData.latest_addendum_nilai);
            } else {
                nilaiDasar = pekerjaanData.nilai_kontrak || pekerjaanData.nilaikontrak || 0;
            }
            
            document.getElementById('dasar_pengenaan').value = nilaiDasar.toLocaleString('id-ID');
            calculateDenda();
        }
        
        // Calculate Denda
        function calculateDenda() {
            const besaranDenda = parseFloat(document.getElementById('besaran_denda').value) || 0.001;
            const dasarPengenaan = parseRupiah(document.getElementById('dasar_pengenaan').value) || 0;
            const persentase = parseFloat(document.getElementById('persentase').value) || 100;
            const hari = parseInt(document.getElementById('jumlah_hari').value) || 0;
            
            // Nilai denda = Besaran x Dasar Pengenaan x (Persentase/100) x Jumlah Hari
            const nilaiDenda = besaranDenda * dasarPengenaan * (persentase / 100) * hari;
            
            // Update display
            document.getElementById('nilai_denda').value = formatRupiah(nilaiDenda);
        }
        
        // Update SK Status Text
        function updateSkStatusText() {
            const isChecked = document.getElementById('sk_denda_ditetapkan').checked;
            document.getElementById('sk_status_text').textContent = isChecked ? 'Sudah' : 'Belum';
        }
        
        // Remove Kertas Kerja
        function removeKertasKerja() {
            document.getElementById('kertas_kerja').value = '';
            document.getElementById('kertas_kerja_info').style.display = 'none';
            document.getElementById('kertas_kerja_name').textContent = '';
        }
        
        // Save Denda
        async function saveDenda() {
            if (!idPekerjaan) {
                Swal.fire('Error', 'ID Pekerjaan tidak ditemukan', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'save_denda');
            formData.append('id_pekerjaan', idPekerjaan);
            
            if (idDenda) {
                formData.append('id_denda', idDenda);
            }
            
            formData.append('besaran_denda', document.getElementById('besaran_denda').value || '0.001');
            formData.append('dasar_pengenaan', parseRupiah(document.getElementById('dasar_pengenaan').value));
            formData.append('persentase', document.getElementById('persentase').value);
            formData.append('jumlah_hari_keterlambatan', document.getElementById('jumlah_hari').value);
            formData.append('nilai_denda', parseRupiah(document.getElementById('nilai_denda').value));
            formData.append('sk_denda_ditetapkan', document.getElementById('sk_denda_ditetapkan').checked ? '1' : '0');
            formData.append('catatan', document.getElementById('catatan').value);
            
            // Append file if selected
            const kertasKerja = document.getElementById('kertas_kerja');
            if (kertasKerja.files.length > 0) {
                formData.append('kertas_kerja', kertasKerja.files[0]);
            }
            
            try {
                Swal.fire({
                    title: 'Menyimpan...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                const response = await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                
                console.log('Save Denda Result:', result);
                
                if (result.success) {
                    Swal.fire('Berhasil!', 'Data denda berhasil disimpan', 'success').then(() => {
                        window.location.href = 'detail_pekerjaan.php?id=' + idPekerjaan;
                    });
                } else {
                    Swal.fire('Error', result.message || 'Gagal menyimpan data denda', 'error');
                }
            } catch (error) {
                console.error('Error saving denda:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadPekerjaanDetails();
        });
    </script>
</body>
</html>
