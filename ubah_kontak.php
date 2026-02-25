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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 14px;
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
            background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
            color: #fff;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(245, 124, 0, 0.4);
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

        @media (max-width: 500px) {
            .container {
                padding: 30px 20px;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='kontak.php?id_entitas=' + new URLSearchParams(window.location.search).get('id_entitas')">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Ubah Kontak</h1>
            <p>Edit informasi kontak</p>
        </div>

        <form id="kontakForm">
            <input type="hidden" id="idkontak" name="idkontak" value="1">
            
            <div class="form-group">
                <label for="skpd">SKPD</label>
                <select id="skpd" name="skpd" required>
                    <option value="">Pilih SKPD</option>
                    <option value="dinas pu" selected>Dinas Pekerjaan Umum Provinsi Jawa Barat</option>
                    <option value="bina marga">Dinas Bina Marga</option>
                    <option value="sumber daya air">Dinas Sumber Daya Air</option>
                    <option value="cipta karya">Dinas Cipta Karya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="namakontak">Nama Lengkap</label>
                <input type="text" id="namakontak" name="namakontak" value="Ahmad Supardi, ST, MT" required>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" value="Kepala Dinas" required>
            </div>

            <div class="form-group">
                <label for="telepon">Nomor Telepon</label>
                <input type="tel" id="telepon" name="telepon" value="0812-3456-7890" required>
            </div>

            <div class="form-group">
                <label for="email">Email (Opsional)</label>
                <input type="email" id="email" name="email" value="ahmad.supardi@dinaspu.go.id">
            </div>

            <div class="btn-group">
                <button type="button" class="btn-batal" onclick="window.location.href='kontak.php'">Batal</button>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        // Get URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const kontakId = urlParams.get('id');
        const idEntitas = urlParams.get('id_entitas');
        
        // Load contact data
        async function loadKontak() {
            if (!kontakId) {
                window.location.href = 'kontak.php' + (idEntitas ? '?id_entitas=' + idEntitas : '');
                return;
            }
            
            try {
                const response = await fetch('api/proses_kontak.php?id=' + kontakId);
                const result = await response.json();
                
                if (result.success && result.data) {
                    const kontak = result.data;
                    document.getElementById('idkontak').value = kontak.id_kontak;
                    document.getElementById('namakontak').value = kontak.nama || '';
                    document.getElementById('jabatan').value = kontak.posisi || '';
                    document.getElementById('telepon').value = kontak.telepon || '';
                    document.getElementById('email').value = kontak.email || '';
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Gagal memuat data kontak', 'error');
            }
        }
        
        // Load data on page load
        loadKontak();
        
        document.getElementById('kontakForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'update');
            formData.append('id_kontak', kontakId);
            formData.append('nama', document.getElementById('namakontak').value);
            formData.append('posisi', document.getElementById('jabatan').value);
            formData.append('telepon', document.getElementById('telepon').value);
            formData.append('email', document.getElementById('email').value);
            
            try {
                const response = await fetch('api/proses_kontak.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Kontak berhasil diperbarui',
                        icon: 'success',
                        confirmButtonColor: '#f57c00',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'kontak.php?id_entitas=' + idEntitas;
                    });
                } else {
                    Swal.fire('Gagal!', result.message || 'Gagal memperbarui kontak', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan', 'error');
            }
        });
    </script>
</body>
</html>
