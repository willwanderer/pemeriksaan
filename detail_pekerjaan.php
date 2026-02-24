<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pekerjaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <style>
        /* Global Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f5f6fa; min-height: 100vh; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: #fff; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; }
        .header h1 { color: #333; font-size: 24px; margin-bottom: 5px; }
        .header p { color: #666; font-size: 14px; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; padding-top: 20px; border-top: 1px solid #eee; }
        .info-item label { display: block; font-size: 12px; color: #999; margin-bottom: 4px; text-transform: uppercase; }
        .info-item span { font-size: 14px; color: #333; font-weight: 500; }
        .status-section { background: #fff; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .status-title { font-size: 18px; font-weight: 700; color: #333; margin-bottom: 20px; }
        .status-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .status-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 20px; color: #fff; }
        .status-card.warning { background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); }
        .status-card.success { background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%); }
        .status-card.danger { background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%); }
        .status-card label { font-size: 12px; opacity: 0.9; display: block; margin-bottom: 8px; }
        .status-card .value { font-size: 24px; font-weight: 700; }
        .status-card .value.late { font-size: 32px; }
        .section { background: #fff; border-radius: 12px; padding: 25px 30px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
        .section-title { font-size: 18px; font-weight: 700; color: #333; }
        .table-container { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        thead th { color: #fff; padding: 12px 15px; text-align: left; font-weight: 600; font-size: 13px; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid #eee; transition: background 0.2s ease; }
        tbody tr:hover { background: #f8f9ff; }
        tbody td { padding: 12px 15px; font-size: 14px; color: #333; }
        .currency { text-align: right; }
        .btn-tambah { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; text-decoration: none; }
        .btn-tambah:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4); }
        .btn-tambah svg { width: 18px; height: 18px; fill: #fff; }
        .btn-action { background: transparent; border: none; padding: 6px; border-radius: 6px; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; justify-content: center; }
        .btn-action svg { width: 18px; height: 18px; }
        .btn-edit { color: #4caf50; }
        .btn-edit:hover { background: #4caf50; }
        .btn-edit:hover svg { fill: #fff; }
        .btn-delete { color: #e74c3c; }
        .btn-delete:hover { background: #e74c3c; }
        .btn-delete:hover svg { fill: #fff; }
        .back-btn { position: fixed; top: 20px; left: 20px; background: #fff; border: none; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; z-index: 100; }
        .back-btn:hover { transform: scale(1.1); }
        .back-btn svg { width: 24px; height: 24px; fill: #333; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; font-size: 14px; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; }
        .form-control:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        select.form-control { background: #fff; cursor: pointer; }
        textarea.form-control { min-height: 100px; resize: vertical; }
        .form-grid, .form-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 30px; }
        .form-actions { display: flex; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid #e2e8f0; margin-top: 10px; }
        .btn-cancel { padding: 14px 28px; border: 2px solid #e2e8f0; border-radius: 12px; background: #fff; color: #64748b; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; }
        .btn-cancel:hover { border-color: #cbd5e0; background: #f8fafc; color: #475569; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
        .btn-submit { padding: 14px 32px; border: none; border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.45); }
        .card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .card-title { font-size: 16px; font-weight: 700; color: #333; margin-bottom: 15px; }
        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .alert-danger { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #e8f5e9; color: #4caf50; }
        .badge-warning { background: #fff3e0; color: #ff9800; }
        .badge-danger { background: #ffebee; color: #f44336; }
        .no-data { text-align: center; padding: 30px; color: #999; }
        .pemeriksaan-table { width: 100%; border-collapse: collapse; }
        .pemeriksaan-table tr { border-bottom: 1px solid #eee; }
        .pemeriksaan-table tr:last-child { border-bottom: none; }
        .pemeriksaan-table td { padding: 15px 20px; vertical-align: middle; }
        .pemeriksaan-label { font-weight: 600; color: #333; font-size: 14px; width: 35%; background: #f8f9fa; }
        .pemeriksaan-value { font-size: 14px; color: #555; }
        .doc-link-table { display: inline-flex; align-items: center; gap: 8px; color: #667eea; text-decoration: none; font-weight: 500; padding: 6px 12px; background: #f0f4ff; border-radius: 6px; transition: all 0.3s ease; }
        .doc-link-table:hover { background: #667eea; color: #fff; }
        .doc-link-table .link-icon { width: 14px; height: 14px; fill: currentColor; }
        .payment-info-table { font-size: 14px; color: #555; }
        .payment-info-table strong { color: #667eea; }
        .switch-container-table { display: flex; align-items: center; gap: 12px; }
        .switch-table { position: relative; display: inline-block; width: 44px; height: 24px; }
        .switch-table input { opacity: 0; width: 0; height: 0; }
        .slider-table { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .3s; border-radius: 24px; }
        .slider-table:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .switch-table input:checked + .slider-table { background-color: #4caf50; }
        .switch-table input:checked + .slider-table:before { transform: translateX(20px); }
        .switch-label-text { font-size: 13px; color: #666; font-weight: 500; }
        .garansi-table-section { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .file-upload-label-table { display: flex; align-items: center; gap: 6px; padding: 6px 12px; background: #667eea; color: #fff; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 13px; transition: all 0.3s ease; }
        .file-upload-label-table:hover { background: #5a6fd6; }
        .file-upload-label-table svg { width: 14px; height: 14px; fill: currentColor; }
        .garansi-table-section input[type="file"] { display: none; }
        .file-name-table { font-size: 12px; color: #666; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .file-info-table { display: flex; align-items: center; gap: 4px; padding: 4px 8px; background: #e8f5e9; border-radius: 4px; font-size: 11px; color: #2e7d32; }
        .file-info-table svg { width: 12px; height: 12px; fill: #2e7d32; }
        .currency-input-table { padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; width: 180px; transition: all 0.3s ease; font-weight: 500; color: #2d3748; background: #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04); }
        .currency-input-table:focus { outline: none; border-color: #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15), 0 0 0 4px rgba(102, 126, 234, 0.1); }
        .catatan-textarea { width: 100%; padding: 12px 14px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; resize: vertical; min-height: 80px; transition: all 0.3s ease; color: #2d3748; background: #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04); }
        .catatan-textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15), 0 0 0 4px rgba(102, 126, 234, 0.1); }
        .btn-simpan-catatan { margin-top: 10px; padding: 8px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; }
        .btn-simpan-catatan:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4); }
        
        /* Switch Button Styles for Modal */
        .switch-modal { position: relative; display: inline-block; width: 44px; height: 24px; }
        .switch-modal input { opacity: 0; width: 0; height: 0; }
        .slider-modal { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .3s; border-radius: 24px; }
        .slider-modal:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .switch-modal input:checked + .slider-modal { background-color: #4caf50; }
        .switch-modal input:checked + .slider-modal:before { transform: translateX(20px); }
        
        @media (max-width: 768px) { .header-top { flex-direction: column; } .section-header { flex-direction: column; align-items: flex-start; } .btn-tambah { width: 100%; justify-content: center; } thead { display: none; } tbody, tr, td { display: block; width: 100%; } tr { margin-bottom: 10px; border: 1px solid #eee; border-radius: 8px; } td { padding: 10px 15px; text-align: right; } td::before { content: attr(data-label); float: left; font-weight: 600; color: #667eea; } .form-grid, .form-row { grid-template-columns: 1fr; gap: 20px; } .form-actions { flex-direction: column-reverse; } .btn-cancel, .btn-submit { width: 100%; justify-content: center; } }
        @media (max-width: 480px) { body { padding: 10px; } .header, .section { padding: 15px; } }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='kertas_kerja_BM.php?id_entitas=' + (pekerjaanData?.id_entitas || '')">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <div class="header-top">
                <div>
                    <h1 id="pekerjaanNama">Memuat...</h1>
                    <p>Detail informasi belanja modal</p>
                </div>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Jenis Belanja Modal</label>
                    <span id="jenisBelanja">-</span>
                </div>
                <div class="info-item">
                    <label>SKPD</label>
                    <span id="skpdNama">-</span>
                </div>
                <div class="info-item">
                    <label>Penyedia</label>
                    <span id="penyediaNama">-</span>
                </div>
                <div class="info-item">
                    <label>Nomor Kontrak</label>
                    <span id="nomorKontrak">-</span>
                </div>
                <div class="info-item">
                    <label>Nilai Kontrak</label>
                    <span id="nilaiKontrak">-</span>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <span id="statusBadge" class="badge badge-warning">-</span>
                </div>
            </div>
        </div>

        <!-- Status Progress -->
        <div class="status-section">
            <h2 class="status-title">Status Progress</h2>
            <div class="status-cards">
                <div class="status-card warning" id="keterlambatanCard">
                    <label>Keterlambatan</label>
                    <div class="value late" id="keterlambatan">0 Hari</div>
                    <a href="#" id="btnHitungDenda" style="display: none; margin-top: 10px; padding: 8px 12px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; color: white; font-size: 12px; cursor: pointer; width: 100%; text-decoration: none; text-align: center; display: block;">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;fill:white;vertical-align:middle;margin-right:5px;"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        Hitung Denda Keterlambatan
                    </a>
                </div>
                <div class="status-card" id="progressCard">
                    <label>Progress Pembayaran</label>
                    <div class="value" id="progressPercent">0%</div>
                    <small style="opacity: 0.8;" id="progressAmount">Rp 0 / Rp 0</small>
                </div>
                <div class="status-card">
                    <label>Dokumen</label>
                    <div class="value" id="docCount">0/0</div>
                    <small style="opacity: 0.8;">terupload</small>
                </div>
            </div>
            <!-- Denda Info in Status Card -->
            <div id="dendaInfo" style="display: none; margin-top: 20px; padding: 15px; background: #fff3e0; border-radius: 8px; border-left: 4px solid #ff9800;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <strong style="color: #e65100;">Total Denda Keterlambatan:</strong>
                        <span id="dendaNilai" style="font-size: 18px; font-weight: 700; color: #e65100;">Rp 0</span>
                        <span id="dendaStatus" style="margin-left: 10px; padding: 2px 8px; border-radius: 4px; font-size: 11px;"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Pekerjaan -->
        <div class="section" id="item-pekerjaan">
            <div class="section-header">
                <h2 class="section-title">Item Pekerjaan</h2>
                <a href="tambah_item_pekerjaan.php" class="btn-tambah" id="btnTambahItem">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Item
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Item Pekerjaan</th>
                        <th>Satuan</th>
                        <th>Volume</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemPekerjaanBody">
                    <tr><td colspan="7" class="no-data">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Addendum -->
        <div class="section" id="addendum">
            <div class="section-header">
                <h2 class="section-title">Addendum</h2>
                <a href="tambah_addendum.php" class="btn-tambah" id="btnTambahAddendum">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Addendum
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Addendum</th>
                        <th>Tanggal Addendum</th>
                        <th>Uraian</th>
                        <th>Tanggal Akhir</th>
                        <th>Nilai Addendum</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="addendumBody">
                    <tr><td colspan="7" class="no-data">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Pembayaran -->
        <div class="section" id="pembayaran">
            <div class="section-header">
                <h2 class="section-title">Pembayaran</h2>
                <a href="tambah_pembayaran.php" class="btn-tambah" id="btnTambahPembayaran">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Pembayaran
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Nomor SP2D</th>
                        <th>Tanggal</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="pembayaranBody">
                    <tr><td colspan="6" class="no-data">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Serah Terima -->
        <div class="section" id="serah-terima">
            <div class="section-header">
                <h2 class="section-title">Serah Terima</h2>
                <a href="tambah_serah_terima.php" class="btn-tambah" id="btnTambahSerahTerima">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Serah Terima
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Nomor Serah Terima</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="serahTerimaBody">
                    <tr><td colspan="6" class="no-data">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Data Pemeriksaan Pekerjaan -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Pemeriksaan Pekerjaan</h2>
            </div>
            
            <table class="pemeriksaan-table">
                <tbody>
                    <tr>
                        <td class="pemeriksaan-label">Dokumen Pendukung</td>
                        <td class="pemeriksaan-value">
                            <a href="pemeriksaan_dokumen.php?id=" class="doc-link-table" id="btnPemeriksaanDokumen">
                                <span id="docUploadedCount">0</span> / <span id="docTotalCount">0</span> dokumen
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="link-icon">
                                    <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pemeriksaan-label">Pekerjaan Diselesaikan Sesuai Periode</td>
                        <td class="pemeriksaan-value">
                            <div class="switch-container-table">
                                <label class="switch-table">
                                    <input type="checkbox" id="switch_periode">
                                    <span class="slider-table"></span>
                                </label>
                                <span class="switch-label-text" id="label_periode">Belum Dicek</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="pemeriksaan-label">Nilai Pembayaran Sesuai Kontrak</td>
                        <td class="pemeriksaan-value">
                            <span class="payment-info-table" id="pembayaranInfo">Belum ada pembayaran</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="pemeriksaan-label">Belanja Dicatat Periode yang Tepat</td>
                        <td class="pemeriksaan-value">
                            <div class="switch-container-table">
                                <label class="switch-table">
                                    <input type="checkbox" id="switch_periode_belanja">
                                    <span class="slider-table"></span>
                                </label>
                                <span class="switch-label-text" id="label_periode_belanja">Belum Dicek</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="pemeriksaan-label">Klasifikasi Akun Belanja Sesuai</td>
                        <td class="pemeriksaan-value">
                            <div class="switch-container-table">
                                <label class="switch-table">
                                    <input type="checkbox" id="switch_klasifikasi">
                                    <span class="slider-table"></span>
                                </label>
                                <span class="switch-label-text" id="label_klasifikasi">Belum Dicek</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="pemeriksaan-label">Pembayaran Retensi Didukung Bank Garansi</td>
                        <td class="pemeriksaan-value">
                            <div class="garansi-table-section">
                                <label for="bank_garansi" class="file-upload-label-table">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                                    </svg>
                                    Upload
                                </label>
                                <input type="file" id="bank_garansi" name="bank_garansi" accept=".pdf,.doc,.docx" onchange="handleBankGaransi(this)">
                                <span id="garansi_file_name" class="file-name-table"></span>
                                <div id="garansi_info" class="file-info-table" style="display: none;">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    OK
                                </div>
                                <input type="text" id="garansi_jumlah" placeholder="Rp 0" class="currency-input-table" onkeyup="formatCurrency(this)">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="pemeriksaan-label">Catatan</td>
                        <td class="pemeriksaan-value">
                            <textarea id="pemeriksaan_catatan" class="catatan-textarea" placeholder="Masukkan catatan pemeriksaan pekerjaan..." rows="3"></textarea>
                            <button type="button" class="btn-simpan-catatan" onclick="savePemeriksaanCatatan()">Simpan Catatan</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Data Pemeriksaan Fisik -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Pemeriksaan Fisik</h2>
                <a href="tambah_sub_pekerjaan.php" class="btn-tambah" id="btnTambahSubPekerjaan">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Sub Pekerjaan
                </a>
            </div>
            
            <!-- Sub Pekerjaan List -->
            <div id="subPekerjaanList" style="display: none;">
                <!-- Sub pekerjaan items will be loaded here -->
            </div>
            
            <p style="color: #999; font-size: 14px; text-align: center; padding: 30px;" id="pemeriksaanFisikInfo">
                Data pemeriksaan fisik belum tersedia. Klik tombol "Tambah Sub Pekerjaan" untuk menambah sub pekerjaan.
            </p>
        </div>
        
        <!-- Data Denda Keterlambatan -->
        <div class="section" id="denda-keterlambatan-section">
            <div class="section-header">
                <h2 class="section-title">Denda Keterlambatan</h2>
                <a href="denda_keterlambatan.php" class="btn-tambah" id="btnTambahDenda">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Denda
                </a>
            </div>
            <table class="data-table" id="dendaTable" style="display: none;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Besaran Denda</th>
                        <th>Dasar Pengenaan</th>
                        <th>Persentase</th>
                        <th>Jumlah Hari</th>
                        <th>Nilai Denda</th>
                        <th>SK Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dendaBody">
                    <tr><td colspan="8" class="no-data">Memuat data...</td></tr>
                </tbody>
            </table>
            <p style="color: #999; font-size: 14px; text-align: center; padding: 30px;" id="dendaInfoKosong">
                Data denda keterlambatan belum tersedia.
            </p>
        </div>
    </div>

    <script>
        let idPekerjaan = null;
        let pekerjaanData = null;

        // Get pekerjaan ID from URL
        function getPekerjaanId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
        }

        // Update link hrefs with pekerjaan ID
        function updateLinks() {
            if (!idPekerjaan) return;
            const baseUrl = '?id=' + idPekerjaan;
            document.getElementById('btnTambahItem').href = 'tambah_item_pekerjaan.php' + baseUrl;
            document.getElementById('btnTambahAddendum').href = 'tambah_addendum.php' + baseUrl;
            document.getElementById('btnTambahPembayaran').href = 'tambah_pembayaran.php' + baseUrl;
            document.getElementById('btnTambahSerahTerima').href = 'tambah_serah_terima.php' + baseUrl;
            document.getElementById('btnTambahDenda').href = 'denda_keterlambatan.php' + baseUrl;
            document.getElementById('btnTambahSubPekerjaan').href = 'tambah_sub_pekerjaan.php' + baseUrl;
            
            // Update links without IDs
            if (document.getElementById('btnPemeriksaanDokumen')) {
                document.getElementById('btnPemeriksaanDokumen').href = 'pemeriksaan_dokumen.php' + baseUrl;
            }
        }
        
        // Get rekapan pemeriksaan URL based on belanja modal type
        function getRekapanUrl(inisialAkunBelanja) {
            const urlMap = {
                'JIJ': 'rekapan_pemeriksaan_jij.php',
                'BG': 'rekapan_pemeriksaan_gedung.php',
                'PM': 'rekapan_pemeriksaan_peralatan.php',
                'TL': 'rekapan_pemeriksaan_tanah.php',
                'ATL': 'rekapan_pemeriksaan_aset_lain.php',
                'AL': 'rekapan_pemeriksaan_aset_lain.php'
            };
            return urlMap[inisialAkunBelanja] || 'rekapan_pemeriksaan_jij.php';
        }

        // Format currency
        function formatRupiah(value) {
            const num = parseFloat(value);
            if (isNaN(num) || num === 0) return 'Rp 0';
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(num);
        }

        // Load pekerjaan details
        async function loadPekerjaanDetails() {
            idPekerjaan = getPekerjaanId();
            
            if (!idPekerjaan) {
                document.getElementById('pekerjaanNama').textContent = 'Pekerjaan Tidak Dipilih';
                return;
            }
            
            updateLinks();
            
            try {
                const response = await fetch('api/proses_pekerjaan.php?id=' + idPekerjaan);
                const result = await response.json();
                
                if (result.success && result.data) {
                    pekerjaanData = result.data;
                    const p = result.data;
                    
                    // Update header info
                    document.getElementById('pekerjaanNama').textContent = p.nama_pekerjaan || '-';
                    document.getElementById('jenisBelanja').textContent = p.nama_akun_belanja || '-';
                    document.getElementById('skpdNama').textContent = p.nama_entitas || '-';
                    document.getElementById('penyediaNama').textContent = p.nama_penyedia || '-';
                    document.getElementById('nomorKontrak').textContent = p.nomor_kontrak || '-';
                    
                    // Update rekapan pemeriksaan link based on belanja modal type
                    if (document.getElementById('btnRekapanPemeriksaan')) {
                        const rekapanUrl = getRekapanUrl(p.inisial_akun_belanja);
                        document.getElementById('btnRekapanPemeriksaan').href = rekapanUrl + '?id=' + idPekerjaan;
                    }
                    
                    const nilaiKontrak = p.nilai_kontrak || p.nilaikontrak || 0;
                    document.getElementById('nilaiKontrak').textContent = formatRupiah(nilaiKontrak);
                    
                    // Status badge - based on PHO
                    const statusBadge = document.getElementById('statusBadge');
                    if (p.pho_date) {
                        // PHO exists - completed
                        statusBadge.textContent = 'Selesai';
                        statusBadge.className = 'badge badge-success';
                    } else {
                        // No PHO - terlambat/late
                        statusBadge.textContent = 'Terlambat';
                        statusBadge.className = 'badge badge-danger';
                    }
                    
                    // Calculate keterlambatan
                    // End date: latest addendum OR contract date
                    // Until date: PHO date OR current date
                    const endDate = p.latest_addendum_end || p.tanggal_selesai || p.tanggal_kontrak;
                    const untilDate = p.pho_date || new Date().toISOString().split('T')[0];
                    
                    keterlambatanHari = 0;
                    if (endDate) {
                        const end = new Date(endDate);
                        const until = new Date(untilDate);
                        const diffTime = until - end;
                        keterlambatanHari = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    }
                    
                    document.getElementById('keterlambatan').textContent = keterlambatanHari + ' Hari';
                    
                    // Set denda button links - both add new denda
                    document.getElementById('btnHitungDenda').href = 'denda_keterlambatan.php?id=' + idPekerjaan;
                    
                    // Show "Hitung Denda" button if there's keterlambatan
                    if (keterlambatanHari > 0) {
                        document.getElementById('btnHitungDenda').style.display = 'block';
                    }
                    
                    // Always check if denda already calculated (regardless of keterlambatan)
                    loadDendaInfo();
                    
                    // Load other data
                    loadItemPekerjaan();
                    loadAddendum();
                    loadPembayaran();
                    loadSerahTerima();
                    loadPemeriksaan();
                    loadSubPekerjaan();
                } else {
                    document.getElementById('pekerjaanNama').textContent = 'Pekerjaan Tidak Ditemukan';
                }
            } catch (error) {
                console.error('Error loading pekerjaan:', error);
                document.getElementById('pekerjaanNama').textContent = 'Error Memuat Data';
            }
        }

        // Load sub pekerjaan
        async function loadSubPekerjaan() {
            try {
                const response = await fetch('api/proses_sub_pekerjaan.php?id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                const container = document.getElementById('subPekerjaanList');
                const infoText = document.getElementById('pemeriksaanFisikInfo');
                
                if (result.success && result.data && result.data.length > 0) {
                    let html = '';
                    result.data.forEach((sub, index) => {
                        const rekapanUrl = getRekapanUrl(sub.kategori_bm || 'JIJ');
                        let detailInfo = '';
                        
                        // Show different info based on kategori_bm
                        if (sub.kategori_bm === 'JIJ') {
                            if (sub.lebar_jalan) {
                                detailInfo += 'Lebar: ' + parseFloat(sub.lebar_jalan).toLocaleString('id-ID') + 'm';
                            }
                            if (sub.panjang) {
                                detailInfo += (detailInfo ? ' | ' : '') + 'Panjang: ' + parseFloat(sub.panjang).toLocaleString('id-ID') + 'm';
                            }
                            if (sub.lebar_bahu_kiri || sub.lebar_bahu_kanan) {
                                detailInfo += (detailInfo ? ' | ' : '') + 'Bahu: ' + (sub.lebar_bahu_kiri || '-') + '/' + (sub.lebar_bahu_kanan || '-') + 'm';
                            }
                        } else {
                            if (sub.panjang) {
                                detailInfo = 'Panjang: ' + parseFloat(sub.panjang).toLocaleString('id-ID') + 'm';
                            }
                        }
                        
                        html += '<div style="background: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 15px; border-left: 4px solid #667eea;">';
                        html += '<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">';
                        html += '<div>';
                        html += '<h3 style="margin: 0 0 5px 0; font-size: 16px; color: #333;">' + (sub.nama_sub_pekerjaan || 'Sub Pekerjaan ' + (index + 1)) + '</h3>';
                        html += '<p style="margin: 0; font-size: 13px; color: #666;">' + detailInfo + '</p>';
                        html += '</div>';
                        html += '<div style="display: flex; gap: 10px;">';
                        html += '<a href="' + rekapanUrl + '?id_pekerjaan=' + idPekerjaan + '&id_sub=' + sub.id_sub_pekerjaan + '" class="btn-tambah" style="padding: 8px 15px; font-size: 13px;">';
                        html += '<svg viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>';
                        html += ' Rekapan</a>';
                        html += '<button class="btn-action btn-delete" onclick="deleteSubPekerjaan(' + sub.id_sub_pekerjaan + ')" title="Hapus">';
                        html += '<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>';
                        html += '</button>';
                        html += '</div></div></div>';
                    });
                    container.innerHTML = html;
                    container.style.display = 'block';
                    infoText.style.display = 'none';
                } else {
                    container.style.display = 'none';
                    infoText.style.display = 'block';
                }
            } catch (error) {
                console.error('Error loading sub pekerjaan:', error);
            }
        }

        // Delete sub pekerjaan
        async function deleteSubPekerjaan(id) {
            const result = await Swal.fire({
                title: 'Anda yakin?',
                text: 'Sub pekerjaan dan semua data pemeriksaan terkait akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            });
            
            if (result.isConfirmed) {
                try {
                    const response = await fetch('api/proses_sub_pekerjaan.php', {
                        method: 'DELETE',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire('Terhapus!', 'Sub pekerjaan berhasil dihapus.', 'success');
                        loadSubPekerjaan();
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Gagal menghapus sub pekerjaan', 'error');
                }
            }
        }

        // Load item pekerjaan
        async function loadItemPekerjaan() {
            try {
                const response = await fetch('api/proses_item_pekerjaan.php?id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                const tbody = document.getElementById('itemPekerjaanBody');
                
                if (result.success && result.data && result.data.length > 0) {
                    let html = '';
                    result.data.forEach((item, index) => {
                        html += '<tr>';
                        html += '<td data-label="No">' + (index + 1) + '</td>';
                        html += '<td data-label="Nama Item">' + (item.nama_item || '-') + '</td>';
                        html += '<td data-label="Satuan">' + (item.satuan || '-') + '</td>';
                        html += '<td data-label="Volume">' + (item.volume || '-') + '</td>';
                        html += '<td class="currency" data-label="Harga">' + formatRupiah(item.harga_satuan) + '</td>';
                        html += '<td class="currency" data-label="Jumlah">' + formatRupiah(item.jumlah_harga) + '</td>';
                        html += '<td data-label="Aksi">';
                        html += '<button class="btn-action btn-delete" title="Hapus" onclick="deleteItem(' + item.id_item_pekerjaan + ', \'item\')">';
                        html += '<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>';
                        html += '</button>';
                        html += '</td></tr>';
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" class="no-data">Belum ada item pekerjaan</td></tr>';
                }
            } catch (error) {
                console.error('Error loading item pekerjaan:', error);
                document.getElementById('itemPekerjaanBody').innerHTML = '<tr><td colspan="7" class="no-data">Error memuat data</td></tr>';
            }
        }

        // Load addendum
        async function loadAddendum() {
            try {
                // Get pekerjaan data for comparison
                const nilaiKontrak = pekerjaanData ? (pekerjaanData.nilai_kontrak || pekerjaanData.nilaikontrak || 0) : 0;
                const tanggalAkhirKontrak = pekerjaanData ? (pekerjaanData.tanggal_selesai || pekerjaanData.tanggal_kontrak || '') : '';
                
                const response = await fetch('api/proses_addendum.php?id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                const tbody = document.getElementById('addendumBody');
                
                if (result.success && result.data && result.data.length > 0) {
                    let html = '';
                    result.data.forEach((item, index) => {
                        // Check if dates/values are unchanged
                        const isTanggalAkhirSame = item.tanggal_selesai_baru === tanggalAkhirKontrak;
                        const isNilaiSame = parseFloat(item.nilai_addendum) === parseFloat(nilaiKontrak);
                        
                        html += '<tr>';
                        html += '<td data-label="No">' + (index + 1) + '</td>';
                        html += '<td data-label="Nomor">' + (item.nomor_addendum || '-') + '</td>';
                        html += '<td data-label="Tanggal Addendum">' + (item.tanggal_addendum || '-') + '</td>';
                        html += '<td data-label="Uraian">' + (item.uraian_perubahan || '-') + '</td>';
                        
                        // Tanggal Akhir - show badge if unchanged
                        if (isTanggalAkhirSame) {
                            html += '<td data-label="Tanggal Akhir"><span class="badge badge-success">Tetap</span></td>';
                        } else {
                            html += '<td data-label="Tanggal Akhir">' + (item.tanggal_selesai_baru || '-') + '</td>';
                        }
                        
                        // Nilai Addendum - show badge if unchanged
                        if (isNilaiSame) {
                            html += '<td data-label="Nilai"><span class="badge badge-success">Tetap</span></td>';
                        } else {
                            html += '<td class="currency" data-label="Nilai">' + formatRupiah(item.nilai_addendum) + '</td>';
                        }
                        
                        html += '<td data-label="Aksi">';
                        html += '<button class="btn-action btn-delete" title="Hapus" onclick="deleteItem(' + item.id_addendum + ', \'addendum\')">';
                        html += '<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>';
                        html += '</button>';
                        html += '</td></tr>';
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" class="no-data">Belum ada addendum</td></tr>';
                }
            } catch (error) {
                console.error('Error loading addendum:', error);
                document.getElementById('addendumBody').innerHTML = '<tr><td colspan="7" class="no-data">Error memuat data</td></tr>';
            }
        }

        // Load pembayaran
        async function loadPembayaran() {
            try {
                // Get nilai compare: latest addendum value or contract value
                let nilaiCompare = 0;
                
                // First try getting from pekerjaan API directly to ensure we have the value
                try {
                    const pkResponse = await fetch('api/proses_pekerjaan.php?id=' + idPekerjaan);
                    const pkResult = await pkResponse.json();
                    if (pkResult.success && pkResult.data) {
                        nilaiCompare = Number(pkResult.data.nilai_kontrak) || 0;
                    }
                } catch (e) {
                    console.log('Error loading pekerjaan:', e);
                }
                
                // Check if there's a latest addendum and use its value instead
                try {
                    const addendumResponse = await fetch('api/proses_addendum.php?id_pekerjaan=' + idPekerjaan);
                    const addendumResult = await addendumResponse.json();
                    if (addendumResult.success && addendumResult.data && addendumResult.data.length > 0) {
                        const addNilai = Number(addendumResult.data[0].nilai_addendum);
                        if (addNilai > 0) {
                            nilaiCompare = addNilai;
                        }
                    }
                } catch (e) {
                    console.log('Error loading addendum:', e);
                }
                
                const response = await fetch('api/proses_pembayaran.php?id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                const tbody = document.getElementById('pembayaranBody');
                
                let totalPembayaran = 0;
                
                if (result.success && result.data && result.data.length > 0) {
                    let html = '';
                    result.data.forEach((item, index) => {
                        const jumlah = Number(item.jumlah_pembayaran) || 0;
                        totalPembayaran += jumlah;
                        html += '<tr>';
                        html += '<td data-label="No">' + (index + 1) + '</td>';
                        html += '<td data-label="Jenis">Termin ' + (item.termin || '-') + '</td>';
                        html += '<td data-label="Nomor SP2D">' + (item.nomor_pembayaran || '-') + '</td>';
                        html += '<td data-label="Tanggal">' + (item.tanggal_pembayaran || '-') + '</td>';
                        html += '<td class="currency" data-label="Nilai">' + formatRupiah(jumlah) + '</td>';
                        html += '<td data-label="Aksi">';
                        html += '<button class="btn-action btn-delete" title="Hapus" onclick="deleteItem(' + item.id_pembayaran + ', \'pembayaran\')">';
                        html += '<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>';
                        html += '</button>';
                        html += '</td></tr>';
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="no-data">Belum ada pembayaran</td></tr>';
                }
                
                // Update progress - show 2 decimal places
                const percent = (nilaiCompare > 0) ? ((totalPembayaran / nilaiCompare) * 100).toFixed(2) : '0.00';
                const terisa = nilaiCompare - totalPembayaran;
                const terisaPercent = (nilaiCompare > 0) ? ((terisa / nilaiCompare) * 100).toFixed(2) : '0.00';
                document.getElementById('progressPercent').textContent = percent + '%';
                document.getElementById('progressAmount').textContent = formatRupiah(totalPembayaran) + ' / ' + formatRupiah(nilaiCompare);
                document.getElementById('pembayaranInfo').innerHTML = 'Terbayarkan <strong>' + formatRupiah(totalPembayaran) + '</strong> dari <strong>' + formatRupiah(nilaiCompare) + '</strong> (Terisa <strong>' + formatRupiah(terisa) + '</strong> / ' + terisaPercent + '%)';
                
                // Update progress card color
                const progressCard = document.getElementById('progressCard');
                const percentNum = parseFloat(percent);
                if (percentNum >= 100) {
                    progressCard.className = 'status-card success';
                } else if (percentNum > 0) {
                    progressCard.className = 'status-card warning';
                } else {
                    progressCard.className = 'status-card';
                }
            } catch (error) {
                console.error('Error loading pembayaran:', error);
                document.getElementById('pembayaranBody').innerHTML = '<tr><td colspan="6" class="no-data">Error memuat data</td></tr>';
            }
        }

        // Load serah terima
        async function loadSerahTerima() {
            try {
                const response = await fetch('api/proses_serah_terima.php?id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                const tbody = document.getElementById('serahTerimaBody');
                
                if (result.success && result.data && result.data.length > 0) {
                    let html = '';
                    result.data.forEach((item, index) => {
                        html += '<tr>';
                        html += '<td data-label="No">' + (index + 1) + '</td>';
                        html += '<td data-label="Jenis">' + (item.jenis_serah_terima || '-') + '</td>';
                        html += '<td data-label="Nomor">' + (item.nomor_berita_acara || '-') + '</td>';
                        html += '<td data-label="Tanggal">' + (item.tanggal_serah_terima || '-') + '</td>';
                        html += '<td data-label="Keterangan">' + (item.catatan || '-') + '</td>';
                        html += '<td data-label="Aksi">';
                        html += '<button class="btn-action btn-delete" title="Hapus" onclick="deleteItem(' + item.id_serah_terima + ', \'serah_terima\')">';
                        html += '<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>';
                        html += '</button>';
                        html += '</td></tr>';
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="no-data">Belum ada serah terima</td></tr>';
                }
            } catch (error) {
                console.error('Error loading serah terima:', error);
                document.getElementById('serahTerimaBody').innerHTML = '<tr><td colspan="6" class="no-data">Error memuat data</td></tr>';
            }
        }

        // Load pemeriksaan pekerjaan
        async function loadPemeriksaan() {
            try {
                const response = await fetch('api/proses_pemeriksaan_pekerjaan.php?id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                
                if (result.success) {
                    // Load document counts
                    const docTotal = result.dokumen?.total || 0;
                    const docUploaded = result.dokumen?.terupload || 0;
                    document.getElementById('docTotalCount').textContent = docTotal;
                    document.getElementById('docUploadedCount').textContent = docUploaded;
                    
                    const pemeriksaan = result.data;
                    
                    // Load Catatan Pemeriksaan Pekerjaan
                    if (pemeriksaan && pemeriksaan.catatan) {
                        document.getElementById('pemeriksaan_catatan').value = pemeriksaan.catatan;
                    }
                    
                    // Load Pekerjaan Diselesaikan Sesuai Periode
                    if (pemeriksaan) {
                        if (pemeriksaan.pekerjaan_selesai_periode !== null) {
                            const switchPeriode = document.getElementById('switch_periode');
                            switchPeriode.checked = pemeriksaan.pekerjaan_selesai_periode == 1;
                            document.getElementById('label_periode').textContent = pemeriksaan.pekerjaan_selesai_periode == 1 ? 'Ya' : 'Tidak';
                        }
                        
                        // Load Belanja Dicatat Periode yang Tepat
                        if (pemeriksaan.belanja_periode_tepat !== null) {
                            const switchBelanja = document.getElementById('switch_periode_belanja');
                            switchBelanja.checked = pemeriksaan.belanja_periode_tepat == 1;
                            document.getElementById('label_periode_belanja').textContent = pemeriksaan.belanja_periode_tepat == 1 ? 'Ya' : 'Tidak';
                        }
                        
                        // Load Klasifikasi Akun Belanja Sesuai
                        if (pemeriksaan.klasifikasi_akun_sesuai !== null) {
                            const switchKlasifikasi = document.getElementById('switch_klasifikasi');
                            switchKlasifikasi.checked = pemeriksaan.klasifikasi_akun_sesuai == 1;
                            document.getElementById('label_klasifikasi').textContent = pemeriksaan.klasifikasi_akun_sesuai == 1 ? 'Ya' : 'Tidak';
                        }
                        
                        // Load Pembayaran Retensi Didukung Bank Garansi
                        if (pemeriksaan.retensi_nilai > 0) {
                            document.getElementById('garansi_jumlah').value = 'Rp ' + parseInt(pemeriksaan.retensi_nilai).toLocaleString('id-ID');
                        }
                        if (pemeriksaan.retensi_file_path) {
                            const fileName = pemeriksaan.retensi_file_path.split('/').pop();
                            document.getElementById('garansi_file_name').textContent = fileName;
                            document.getElementById('garansi_info').style.display = 'flex';
                        }
                    }
                    
                    // Check if work completed on time (compare PHO date with contract end date)
                    const pekerjaan = result.pekerjaan;
                    if (pekerjaan && pekerjaan.tanggal_selesai && pekerjaan.pho_date) {
                        const endDate = new Date(pekerjaan.tanggal_selesai);
                        const phoDate = new Date(pekerjaan.pho_date);
                        // If PHO date <= end date, work completed on time
                        const onTime = phoDate <= endDate;
                        
                        // Auto-check the switch if not manually set
                        if (!pemeriksaan || pemeriksaan.pekerjaan_selesai_periode === null) {
                            const switchPeriode = document.getElementById('switch_periode');
                            switchPeriode.checked = onTime;
                            document.getElementById('label_periode').textContent = onTime ? 'Ya' : 'Tidak';
                            
                            // Save auto-detection result
                            savePemeriksaan('save_periode', onTime ? 'true' : 'false', onTime ? 'Otomatis: Selesai sesuai periode' : 'Otomatis: Terlambat');
                        }
                    }
                }
            } catch (error) {
                console.error('Error loading pemeriksaan:', error);
            }
        }

        // Save pemeriksaan data to database
        async function savePemeriksaan(action, value, catatan = '') {
            try {
                const formData = new FormData();
                formData.append('action', action);
                formData.append('id_pekerjaan', idPekerjaan);
                formData.append('value', value);
                if (catatan) {
                    formData.append('catatan', catatan);
                }
                
                const response = await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                return result.success;
            } catch (error) {
                console.error('Error saving pemeriksaan:', error);
                return false;
            }
        }
        
        // Save catatan for Pemeriksaan Pekerjaan
        async function savePemeriksaanCatatan() {
            const catatan = document.getElementById('pemeriksaan_catatan').value;
            try {
                const formData = new FormData();
                formData.append('action', 'save_catatan');
                formData.append('id_pekerjaan', idPekerjaan);
                formData.append('catatan', catatan);
                
                const response = await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Catatan berhasil disimpan',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menyimpan catatan: ' + result.message
                    });
                }
            } catch (error) {
                console.error('Error saving catatan:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error menyimpan catatan'
                });
            }
        }

        // Edit item
        function editItem(id, type) {
            const baseUrl = '?id=' + id + '&id_pekerjaan=' + idPekerjaan;
            let url = '';
            switch(type) {
                case 'item': url = 'ubah_item_pekerjaan.php' + baseUrl; break;
                case 'addendum': url = 'ubah_addendum.php' + baseUrl; break;
                case 'pembayaran': url = 'ubah_pembayaran.php' + baseUrl; break;
                case 'serah_terima': url = 'ubah_serah_terima.php' + baseUrl; break;
            }
            if (url) window.location.href = url;
        }

        // Delete item
        async function deleteItem(id, type) {
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
                    let apiUrl = '';
                    let paramName = '';
                    switch(type) {
                        case 'item': 
                            apiUrl = 'api/proses_item_pekerjaan.php'; 
                            paramName = 'id_item_pekerjaan';
                            break;
                        case 'addendum': 
                            apiUrl = 'api/proses_addendum.php'; 
                            paramName = 'id_addendum';
                            break;
                        case 'pembayaran': 
                            apiUrl = 'api/proses_pembayaran.php'; 
                            paramName = 'id_pembayaran';
                            break;
                        case 'serah_terima': 
                            apiUrl = 'api/proses_serah_terima.php'; 
                            paramName = 'id_serah_terima';
                            break;
                    }
                    
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append(paramName, id);

                    const response = await fetch(apiUrl, {
                        method: 'POST',
                        body: formData
                    });
                    
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success')
                            .then(() => {
                                // Reload the appropriate section
                                switch(type) {
                                    case 'item': loadItemPekerjaan(); break;
                                    case 'addendum': loadAddendum(); break;
                                    case 'pembayaran': loadPembayaran(); break;
                                    case 'serah_terima': loadSerahTerima(); break;
                                }
                            });
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                }
            }
        }

        function handleBankGaransi(input) {
            var file = input.files[0];
            if (file) {
                document.getElementById('garansi_file_name').textContent = file.name;
                document.getElementById('garansi_info').style.display = 'flex';
                Swal.fire(
                    'Berhasil!',
                    'Bank garansi berhasil diupload.',
                    'success'
                );
            }
        }

        function formatCurrency(input) {
            var value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
            }
            input.value = value ? 'Rp ' + value : '';
        }

        // Handle switch toggle changes
        document.addEventListener('DOMContentLoaded', function() {
            var switchPeriode = document.getElementById('switch_periode');
            var switchPeriodeBelanja = document.getElementById('switch_periode_belanja');
            var switchKlasifikasi = document.getElementById('switch_klasifikasi');
            
            if (switchPeriode) {
                switchPeriode.addEventListener('change', function() {
                    var value = this.checked ? 'true' : 'false';
                    document.getElementById('label_periode').textContent = this.checked ? 'Ya' : 'Tidak';
                    // Save to database
                    savePemeriksaan('save_periode', value, 'Pemeriksaan manual');
                });
            }
            
            if (switchPeriodeBelanja) {
                switchPeriodeBelanja.addEventListener('change', function() {
                    var value = this.checked ? 'true' : 'false';
                    document.getElementById('label_periode_belanja').textContent = this.checked ? 'Ya' : 'Tidak';
                    // Save to database
                    savePemeriksaan('save_belanja_periode', value, 'Pemeriksaan manual');
                });
            }
            
            if (switchKlasifikasi) {
                switchKlasifikasi.addEventListener('change', function() {
                    var value = this.checked ? 'true' : 'false';
                    document.getElementById('label_klasifikasi').textContent = this.checked ? 'Ya' : 'Tidak';
                    // Save to database
                    savePemeriksaan('save_klasifikasi', value, 'Pemeriksaan manual');
                });
            }
            
            // Handle bank garansi upload
            var garansiInput = document.getElementById('bank_garansi');
            if (garansiInput) {
                garansiInput.addEventListener('change', async function() {
                    var file = this.files[0];
                    if (file) {
                        var nilai = document.getElementById('garansi_jumlah').value.replace(/[^0-9]/g, '');
                        
                        var formData = new FormData();
                        formData.append('action', 'save_garansi');
                        formData.append('id_pekerjaan', idPekerjaan);
                        formData.append('value', 'true');
                        formData.append('nilai', nilai || '0');
                        formData.append('file', file);
                        
                        try {
                            var response = await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                                method: 'POST',
                                body: formData
                            });
                            var result = await response.json();
                            
                            if (result.success) {
                                document.getElementById('garansi_file_name').textContent = file.name;
                                document.getElementById('garansi_info').style.display = 'flex';
                                Swal.fire('Berhasil!', 'Bank garansi berhasil disimpan.', 'success');
                            } else {
                                Swal.fire('Error', result.message, 'error');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Gagal menyimpan data', 'error');
                        }
                    }
                });
            }
            
            // Handle garansi jumlah change
            var garansiJumlah = document.getElementById('garansi_jumlah');
            if (garansiJumlah) {
                garansiJumlah.addEventListener('blur', async function() {
                    var nilai = this.value.replace(/[^0-9]/g, '');
                    if (nilai && idPekerjaan) {
                        var formData = new FormData();
                        formData.append('action', 'save_garansi');
                        formData.append('id_pekerjaan', idPekerjaan);
                        formData.append('value', 'true');
                        formData.append('nilai', nilai);
                        
                        await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                            method: 'POST',
                            body: formData
                        });
                    }
                });
            }
            
            // Load all data
            loadPekerjaanDetails();
        });

        // Denda Keterlambatan Functions
        let dendaData = null;
        let keterlambatanHari = 0;

        // Load Denda Info for display
        async function loadDendaInfo() {
            if (!idPekerjaan) return;
            
            try {
                const response = await fetch('api/proses_pemeriksaan_pekerjaan.php?action=get_all_denda&id_pekerjaan=' + idPekerjaan);
                const result = await response.json();
                
                const tbody = document.getElementById('dendaBody');
                const table = document.getElementById('dendaTable');
                const emptyMsg = document.getElementById('dendaInfoKosong');
                
                if (result.success && result.data && result.data.length > 0) {
                    // Show table, hide empty message
                    table.style.display = 'table';
                    emptyMsg.style.display = 'none';
                    
                    let html = '';
                    let totalDenda = 0;
                    
                    result.data.forEach((denda, index) => {
                        const nilaiDenda = parseFloat(denda.nilai_denda) || 0;
                        totalDenda += nilaiDenda;
                        
                        html += '<tr>';
                        html += '<td data-label="No">' + (index + 1) + '</td>';
                        html += '<td data-label="Besaran Denda">' + (parseFloat(denda.besaran_denda) || 0.001) + '</td>';
                        html += '<td data-label="Dasar Pengenaan">' + formatRupiah(parseFloat(denda.dasar_pengenaan) || 0) + '</td>';
                        html += '<td data-label="Persentase">' + (parseFloat(denda.persentase) || 100) + '%</td>';
                        html += '<td data-label="Jumlah Hari">' + (parseInt(denda.jumlah_hari_keterlambatan) || 0) + '</td>';
                        html += '<td data-label="Nilai Denda" style="font-weight: 700; color: #e65100;">' + formatRupiah(nilaiDenda) + '</td>';
                        
                        if (denda.sk_denda_ditetapkan == 1) {
                            html += '<td data-label="SK Denda"><span style="background: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 4px; font-size: 11px;">Ditetapkan</span></td>';
                        } else {
                            html += '<td data-label="SK Denda"><span style="background: #fff3e0; color: #e65100; padding: 2px 8px; border-radius: 4px; font-size: 11px;">Belum</span></td>';
                        }
                        
                        html += '<td data-label="Aksi">';
                        html += '<a href="denda_keterlambatan.php?id=' + idPekerjaan + '&edit=' + denda.id_denda + '" class="btn-action btn-edit" title="Edit">';
                        html += '<svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>';
                        html += '</a>';
                        html += '<button class="btn-action btn-delete" title="Hapus" onclick="deleteDenda(' + denda.id_denda + ')">';
                        html += '<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>';
                        html += '</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    
                    // Add total row
                    html += '<tr style="background: #f5f5f5; font-weight: 700;">';
                    html += '<td data-label="No" colspan="5" style="text-align: right;">TOTAL DENDA:</td>';
                    html += '<td data-label="Total" style="color: #e65100; font-size: 16px;">' + formatRupiah(totalDenda) + '</td>';
                    html += '<td data-label="SK Denda" colspan="2"></td>';
                    html += '</tr>';
                    
                    tbody.innerHTML = html;
                    
                    // Also show in status card
                    document.getElementById('dendaInfo').style.display = 'block';
                    document.getElementById('dendaNilai').textContent = formatRupiah(totalDenda);
                    
                    // Update status badge - show based on whether all have SK
                    const allSkDitetapkan = result.data.every(d => d.sk_denda_ditetapkan == 1);
                    const statusSpan = document.getElementById('dendaStatus');
                    if (allSkDitetapkan) {
                        statusSpan.textContent = 'SK Denda Ditetapkan';
                        statusSpan.style.background = '#e8f5e9';
                        statusSpan.style.color = '#2e7d32';
                    } else {
                        statusSpan.textContent = 'Belum Ditetapkan';
                        statusSpan.style.background = '#fff3e0';
                        statusSpan.style.color = '#e65100';
                    }
                } else {
                    // No data - hide table, show empty message
                    table.style.display = 'none';
                    emptyMsg.style.display = 'block';
                    document.getElementById('dendaInfo').style.display = 'none';
                }
            } catch (error) {
                console.error('Error loading denda info:', error);
            }
        }
        
        // Delete Denda
        async function deleteDenda(idDenda) {
            const result = await Swal.fire({
                title: 'Anda yakin?',
                text: 'Data denda akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            });
            
            if (!result.isConfirmed) return;
            
            try {
                const formData = new FormData();
                formData.append('action', 'delete_denda');
                formData.append('id_denda', idDenda);
                
                const response = await fetch('api/proses_pemeriksaan_pekerjaan.php', {
                    method: 'POST',
                    body: formData
                });
                const resultData = await response.json();
                
                if (resultData.success) {
                    Swal.fire('Terhapus!', 'Data denda berhasil dihapus', 'success');
                    loadDendaInfo();
                } else {
                    Swal.fire('Gagal', resultData.message || 'Gagal menghapus data denda', 'error');
                }
            } catch (error) {
                console.error('Error deleting denda:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menghapus data', 'error');
            }
        }

        // Parse Rupiah to number
        function parseRupiah(str) {
            return parseInt(str.replace(/[^0-9]/g, '')) || 0;
        }
    </script>
</body>
</html>
