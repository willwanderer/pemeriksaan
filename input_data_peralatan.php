<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Peralatan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f5f6fa; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .container { background: #fff; border-radius: 12px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2); padding: 40px; width: 100%; max-width: 700px; }
        .header { text-align: center; margin-bottom: 35px; }
        .header h1 { color: #333; font-size: 28px; margin-bottom: 8px; }
        .header p { color: #666; font-size: 14px; }
        .form-group { margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 12px 15px; border: 2px solid #e1e1e1; border-radius: 8px; font-size: 14px; transition: all 0.3s ease; background: #fff; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .section-title { font-size: 16px; font-weight: 700; color: #667eea; margin: 25px 0 15px 0; padding-bottom: 8px; border-bottom: 2px solid #667eea; }
        .btn-group { display: flex; gap: 15px; margin-top: 30px; }
        button { flex: 1; padding: 14px 25px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .btn-submit { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4); }
        .btn-reset { background: #f1f1f1; color: #666; }
        .btn-reset:hover { background: #e1e1e1; }
        .back-btn { position: fixed; top: 20px; left: 20px; background: #fff; border: none; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); z-index: 100; }
        .back-btn:hover { transform: scale(1.1); }
        .back-btn svg { width: 24px; height: 24px; fill: #333; }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='rekapan_pemeriksaan_peralatan.php?id=' + new URLSearchParams(window.location.search).get('id_pekerjaan')">
        <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Input Data Peralatan</h1>
            <p>Formulir untuk memasukkan data peralatan mesin</p>
        </div>

        <form id="peralatanDataForm">
            <div class="section-title">Data Utama</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nama_peralatan">Nama Peralatan</label>
                    <input type="text" id="nama_peralatan" name="nama_peralatan" required>
                </div>
                <div class="form-group">
                    <label for="jenis_peralatan">Jenis Peralatan</label>
                    <input type="text" id="jenis_peralatan" name="jenis_peralatan">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="merk">Merk</label>
                    <input type="text" id="merk" name="merk">
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" id="model" name="model">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nomor_seri">Nomor Seri</label>
                    <input type="text" id="nomor_seri" name="nomor_seri">
                </div>
                <div class="form-group">
                    <label for="tahun_pembuatan">Tahun Pembuatan</label>
                    <input type="number" id="tahun_pembuatan" name="tahun_pembuatan" min="1900" max="2100">
                </div>
            </div>

            <div class="section-title">Kondisi Peralatan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="kondisi_umum">Kondisi Umum</label>
                    <select id="kondisi_umum" name="kondisi_umum">
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_sedang">Rusak Sedang</option>
                        <option value="rusak_berat">Rusak Berat</option>
                        <option value="tidak_fungsi">Tidak Berfungsi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kondisi_mesin">Kondisi Mesin</label>
                    <select id="kondisi_mesin" name="kondisi_mesin">
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_sedang">Rusak Sedang</option>
                        <option value="rusak_berat">Rusak Berat</option>
                        <option value="tidak_fungsi">Tidak Berfungsi</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="hasil_test_run">Hasil Test Run</label>
                    <select id="hasil_test_run" name="hasil_test_run">
                        <option value="berfungsi">Berfungsi</option>
                        <option value="tidak_berfungsi">Tidak Berfungsi</option>
                        <option value="sebagian_fungsi">Sebagian Berfungsi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelengkapan_dokumen">Kelengkapan Dokumen</label>
                    <select id="kelengkapan_dokumen" name="kelengkapan_dokumen">
                        <option value="lengkap">Lengkap</option>
                        <option value="tidak_lengkap">Tidak Lengkap</option>
                    </select>
                </div>
            </div>

            <div class="section-title">Catatan</div>
            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea id="catatan" name="catatan" rows="3"></textarea>
            </div>

            <div class="btn-group">
                <button type="reset" class="btn-reset">Reset</button>
                <button type="submit" class="btn-submit">Simpan Data</button>
            </div>
        </form>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const idPekerjaan = urlParams.get('id_pekerjaan');

        document.getElementById('peralatanDataForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!idPekerjaan) {
                Swal.fire('Error', 'ID Pekerjaan tidak ditemukan!', 'error');
                return;
            }
            
            const formData = new FormData(this);
            const data = {
                type: 'peralatan',
                id_pekerjaan: idPekerjaan,
                nama_peralatan: formData.get('nama_peralatan'),
                jenis_peralatan: formData.get('jenis_peralatan') || null,
                merk: formData.get('merk') || null,
                model: formData.get('model') || null,
                nomor_seri: formData.get('nomor_seri') || null,
                tahun_pembuatan: formData.get('tahun_pembuatan') || null,
                kondisi_umum: formData.get('kondisi_umum') || 'baik',
                kondisi_mesin: formData.get('kondisi_mesin') || 'baik',
                hasil_test_run: formData.get('hasil_test_run') || 'berfungsi',
                kelengkapan_dokumen: formData.get('kelengkapan_dokumen') || 'lengkap',
                catatan: formData.get('catatan') || null,
                status_kesesuaian: 'sesuai'
            };
            
            try {
                const response = await fetch('api/proses_rekapan.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire('Berhasil', 'Data berhasil disimpan!', 'success').then(() => {
                        window.location.href = 'rekapan_pemeriksaan_peralatan.php?id=' + idPekerjaan;
                    });
                } else {
                    Swal.fire('Gagal', result.message || 'Gagal menyimpan data', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        });
    </script>
</body>
</html>
