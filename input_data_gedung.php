<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.ico">
    <title>KKP Willybrodus</title>
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
    <button class="back-btn" onclick="window.location.href='rekapan_pemeriksaan_gedung.php?id=' + new URLSearchParams(window.location.search).get('id_pekerjaan')">
        <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Input Data Gedung</h1>
            <p>Formulir untuk memasukkan data gedung dan bangunan</p>
        </div>

        <form id="gedungDataForm">
            <div class="section-title">Data Utama</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nama_bangunan">Nama Bangunan</label>
                    <input type="text" id="nama_bangunan" name="nama_bangunan" required>
                </div>
                <div class="form-group">
                    <label for="lokasi_bangunan">Lokasi Bangunan</label>
                    <input type="text" id="lokasi_bangunan" name="lokasi_bangunan">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="lantai">Lantai</label>
                    <input type="number" id="lantai" name="lantai" min="0">
                </div>
                <div class="form-group">
                    <label for="luas_bangunan">Luas Bangunan (m²)</label>
                    <input type="number" id="luas_bangunan" name="luas_bangunan" step="0.01">
                </div>
            </div>

            <div class="section-title">Kondisi Bangunan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="kondisi_struktur">Kondisi Struktur</label>
                    <select id="kondisi_struktur" name="kondisi_struktur">
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_sedang">Rusak Sedang</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kondisi_atap">Kondisi Atap</label>
                    <select id="kondisi_atap" name="kondisi_atap">
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_sedang">Rusak Sedang</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="kondisi_lantai">Kondisi Lantai</label>
                    <select id="kondisi_lantai" name="kondisi_lantai">
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_sedang">Rusak Sedang</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kondisi_dinding">Kondisi Dinding</label>
                    <select id="kondisi_dinding" name="kondisi_dinding">
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_sedang">Rusak Sedang</option>
                        <option value="rusak_berat">Rusak Berat</option>
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

        document.getElementById('gedungDataForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!idPekerjaan) {
                Swal.fire('Error', 'ID Pekerjaan tidak ditemukan!', 'error');
                return;
            }
            
            const formData = new FormData(this);
            const data = {
                type: 'gedung',
                id_pekerjaan: idPekerjaan,
                nama_bangunan: formData.get('nama_bangunan'),
                lokasi_bangunan: formData.get('lokasi_bangunan') || null,
                lantai: formData.get('lantai') || null,
                luas_bangunan: formData.get('luas_bangunan') || null,
                kondisi_struktur: formData.get('kondisi_struktur') || 'baik',
                kondisi_atap: formData.get('kondisi_atap') || 'baik',
                kondisi_lantai: formData.get('kondisi_lantai') || 'baik',
                kondisi_dinding: formData.get('kondisi_dinding') || 'baik',
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
                        window.location.href = 'rekapan_pemeriksaan_gedung.php?id=' + idPekerjaan;
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
