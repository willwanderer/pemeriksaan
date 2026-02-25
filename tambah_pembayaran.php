<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.ico">
    <title>KKP Willybrodus</title>
    <!-- SweetAlert CSS -->
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
            max-width: 600px;
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

        .pekerjaan-info {
            background: #e8eaf6;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }

        .pekerjaan-info strong {
            color: #333;
        }

        .pekerjaan-info span {
            color: #666;
        }

        .kontrak-info {
            background: #fff3e0;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid #ff9800;
        }

        .kontrak-info strong {
            color: #333;
        }

        .kontrak-info span {
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
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='detail_pekerjaan.php?id=' + getIdPekerjaan()">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Tambah Pembayaran</h1>
            <p>Formulir untuk mencatat pembayaran</p>
        </div>

        <div class="pekerjaan-info" id="pekerjaanInfo">
            <strong>Belanja Modal:</strong> <span>Memuat data...</span>
        </div>

        <div class="kontrak-info" id="kontrakInfo">
            <strong>Nilai Kontrak:</strong> <span>Memuat data...</span>
        </div>

        <div class="form-container">
            <form id="pembayaranForm">
                <div class="form-group">
                    <label for="jenispembayaran">Jenis Pembayaran</label>
                    <select id="jenispembayaran" name="jenispembayaran" required>
                        <option value="">Pilih Jenis</option>
                        <option value="termin1">Uang Muka</option>
                        <option value="termin2">Pembayaran Termin 1</option>
                        <option value="termin3">Pembayaran Termin 2</option>
                        <option value="termin4">Pembayaran Termin 3</option>
                        <option value="retensi">Retensi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nomorsp2d">Nomor SP2D</label>
                    <input type="text" id="nomorsp2d" name="nomorsp2d" placeholder="SP2D/001/2024" required>
                </div>

                <div class="form-group">
                    <label for="tanggalpembayaran">Tanggal Pembayaran</label>
                    <input type="date" id="tanggalpembayaran" name="tanggalpembayaran" required>
                </div>

                <div class="form-group">
                    <label for="nilaipembayaran">Nilai Pembayaran (Rp)</label>
                    <input type="number" id="nilaipembayaran" name="nilaipembayaran" step="0.01" placeholder="1375000000" required>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" placeholder="Pembayaran termin 1 25%">
                </div>

                <div class="btn-group">
                    <button type="button" class="btn-batal" onclick="window.location.href='detail_pekerjaan.php?id=' + getIdPekerjaan()">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        function getIdPekerjaan() {
            return new URLSearchParams(window.location.search).get('id') || '';
        }
        
        // Load pekerjaan info
        async function loadPekerjaanInfo() {
            const idPekerjaan = getIdPekerjaan();
            if (!idPekerjaan) return;
            
            try {
                const response = await fetch('api/proses_pekerjaan.php?id=' + idPekerjaan);
                const result = await response.json();
                
                if (result.success && result.data) {
                    const p = result.data;
                    const nilaiKontrak = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(p.nilai_kontrak || 0);
                    document.getElementById('pekerjaanInfo').innerHTML = 
                        '<strong>Belanja Modal:</strong> <span>' + (p.nama_pekerjaan || '-') + '</span>';
                    document.getElementById('kontrakInfo').innerHTML = 
                        '<strong>Nilai Kontrak:</strong> <span>' + nilaiKontrak + '</span>';
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
        
        loadPekerjaanInfo();
        
        document.getElementById('pembayaranForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'create');
            formData.append('id_pekerjaan', getIdPekerjaan());
            formData.append('nomor_pembayaran', document.getElementById('nomorsp2d').value);
            formData.append('termin', document.getElementById('jenispembayaran').value.replace('termin', '').replace('uangmuka', '0') || '1');
            formData.append('tanggal_pembayaran', document.getElementById('tanggalpembayaran').value);
            formData.append('jumlah_pembayaran', document.getElementById('nilaipembayaran').value);
            formData.append('persentase_pekerjaan', '0');
            formData.append('status_pembayaran', 'paid');
            formData.append('keterangan', document.getElementById('keterangan').value);
            
            try {
                const response = await fetch('api/proses_pembayaran.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pembayaran berhasil dicatat',
                        icon: 'success',
                        confirmButtonColor: '#667eea'
                    }).then(() => {
                        window.location.href = 'detail_pekerjaan.php?id=' + getIdPekerjaan();
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
