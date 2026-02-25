<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.ico">
    <title>KKP Willybrodus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            max-width: 700px;
            margin: 0 auto;
        }

        .header {
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .header h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .form-container {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input::placeholder {
            color: #999;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        button {
            flex: 1;
            padding: 14px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-batal {
            background: #f1f1f1;
            color: #666;
        }

        .btn-batal:hover {
            background: #e1e1e1;
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

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='kertas_kerja_BM.php?id_entitas=' + new URLSearchParams(window.location.search).get('id_entitas')">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Ubah Pekerjaan</h1>
            <p>Formulir untuk mengubah data pekerjaan</p>
        </div>

        <div class="form-container">
            <form id="pekerjaanForm">
                <input type="hidden" id="idPekerjaan" name="idPekerjaan">
                <div class="form-group">
                    <label for="namapekerjaan">Nama Pekerjaan</label>
                    <input type="text" id="namapekerjaan" name="namapekerjaan" placeholder="Peningkatan Jalan Cijeruk-Cibinong" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jenismodal">Jenis Belanja Modal</label>
                        <select id="jenismodal" name="jenismodal" required>
                            <option value="">Pilih Jenis Belanja Modal</option>
                            <option value="BM JIJ">Belanja Modal Jalan, Irigasi, dan Jaringan (BM JIJ)</option>
                            <option value="BM Gedung dan Bangunan">Belanja Modal Gedung dan Bangunan</option>
                            <option value="BM Peralatan Mesin">Belanja Modal Peralatan Mesin</option>
                            <option value="BM Tanah">Belanja Modal Tanah</option>
                            <option value="BM Aset Tetap Lainnya">Belanja Modal Aset Tetap Lainnya</option>
                            <option value="BM Aset Lainnya">Belanja Modal Aset Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="skpd">SKPD</label>
                        <input type="text" id="skpd" name="skpd" placeholder="Dinas PU Provinsi Jawa Barat" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="penyedia">Penyedia</label>
                        <input type="text" id="penyedia" name="penyedia" placeholder="PT Jaya Konstruksi" required>
                    </div>
                    <div class="form-group">
                        <label for="nomorkontrak">Nomor Kontrak</label>
                        <input type="text" id="nomorkontrak" name="nomorkontrak" placeholder="PU/001/2024" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nilaikontrak">Nilai Kontrak (Rp)</label>
                        <input type="number" id="nilaikontrak" name="nilaikontrak" step="0.01" placeholder="5500000000" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggalkontrak">Tanggal Kontrak</label>
                        <input type="date" id="tanggalkontrak" name="tanggalkontrak" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggalmulai">Tanggal Mulai</label>
                        <input type="date" id="tanggalmulai" name="tanggalmulai">
                    </div>
                    <div class="form-group">
                        <label for="tanggalselesai">Tanggal Selesai</label>
                        <input type="date" id="tanggalselesai" name="tanggalselesai">
                    </div>
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" placeholder="Kabupaten Bogor">
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" placeholder="Pekerjaan peningkatan jalan sepanjang 5 km">
                </div>

                <div class="btn-group">
                    <button type="button" class="btn-batal" onclick="window.location.href='kertas_kerja_BM.php?id_entitas=' + new URLSearchParams(window.location.search).get('id_entitas')">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        // Get IDs from URL
        const urlParams = new URLSearchParams(window.location.search);
        const idPekerjaan = urlParams.get('id');
        const idEntitas = urlParams.get('id_entitas');
        
        // Load job data
        async function loadPekerjaan() {
            if (!idPekerjaan) {
                window.location.href = 'kertas_kerja_BM.php' + (idEntitas ? '?id_entitas=' + idEntitas : '');
                return;
            }
            
            try {
                const response = await fetch('api/proses_pekerjaan.php?id=' + idPekerjaan);
                const result = await response.json();
                
                if (result.success && result.data) {
                    const pekerjaan = result.data;
                    document.getElementById('idPekerjaan').value = pekerjaan.id_pekerjaan;
                    document.getElementById('namapekerjaan').value = pekerjaan.nama_pekerjaan || '';
                    document.getElementById('skpd').value = pekerjaan.skpd || '';
                    document.getElementById('jenismodal').value = pekerjaan.inisial_akun_belanja || '';
                    document.getElementById('penyedia').value = pekerjaan.inisial_penyedia || '';
                    document.getElementById('nomorkontrak').value = pekerjaan.nomor_kontrak || '';
                    document.getElementById('nilaikontrak').value = pekerjaan.nilai_kontrak || '';
                    document.getElementById('tanggalkontrak').value = pekerjaan.tanggal_kontrak || '';
                    document.getElementById('tanggalmulai').value = pekerjaan.tanggal_mulai || '';
                    document.getElementById('tanggalselesai').value = pekerjaan.tanggal_selesai || '';
                    document.getElementById('lokasi').value = pekerjaan.lokasi || '';
                    document.getElementById('keterangan').value = pekerjaan.keterangan || '';
                } else {
                    Swal.fire('Error', 'Data pekerjaan tidak ditemukan', 'error')
                        .then(() => window.location.href = 'kertas_kerja_BM.php?id_entitas=' + idEntitas);
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Gagal memuat data pekerjaan', 'error');
            }
        }
        
        // Load data on page load
        loadPekerjaan();
        
        document.getElementById('pekerjaanForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'update');
            formData.append('id_pekerjaan', idPekerjaan);
            formData.append('namapekerjaan', document.getElementById('namapekerjaan').value);
            formData.append('skpd', document.getElementById('skpd').value);
            formData.append('jenismodal', document.getElementById('jenismodal').value);
            formData.append('penyedia', document.getElementById('penyedia').value);
            formData.append('nomorkontrak', document.getElementById('nomorkontrak').value);
            formData.append('nilaikontrak', document.getElementById('nilaikontrak').value);
            formData.append('tanggalkontrak', document.getElementById('tanggalkontrak').value);
            formData.append('tanggalmulai', document.getElementById('tanggalmulai').value);
            formData.append('tanggalselesai', document.getElementById('tanggalselesai').value);
            formData.append('lokasi', document.getElementById('lokasi').value);
            formData.append('keterangan', document.getElementById('keterangan').value);
            
            try {
                const response = await fetch('api/proses_pekerjaan.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pekerjaan berhasil diperbarui',
                        icon: 'success',
                        confirmButtonColor: '#4caf50'
                    }).then(() => {
                        window.location.href = 'kertas_kerja_BM.php?id_entitas=' + idEntitas;
                    });
                } else {
                    Swal.fire('Gagal!', result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan', 'error');
            }
        });
    </script>
</body>
</html>
