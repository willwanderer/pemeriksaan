<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kontak</title>
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
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: #fff;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.4);
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
            <h1>Tambah Kontak</h1>
            <p>Tambahkan kontak baru</p>
        </div>

        <form id="kontakForm">

            <div class="form-group">
                <label for="namakontak">Nama Lengkap</label>
                <input type="text" id="namakontak" name="namakontak" placeholder="Ahmad Supardi, ST, MT" required>
            </div>

            <div class="form-group">
                <label for="skpd">SKPD</label>
                <input type="text" id="skpd" name="skpd" placeholder="Dinas Pendidikan" required>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" placeholder="Kepala Dinas" required>
            </div>

            <div class="form-group">
                <label for="telepon">Nomor Telepon</label>
                <input type="tel" id="telepon" name="telepon" placeholder="0812-3456-7890" required>
            </div>

            <div class="form-group">
                <label for="email">Email (Opsional)</label>
                <input type="email" id="email" name="email" placeholder="email@dinas.go.id">
            </div>

            <div class="btn-group">
                <button type="button" class="btn-batal" onclick="window.location.href='kontak.php'">Batal</button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        // Get ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const idEntitas = urlParams.get('id_entitas');
        
        document.getElementById('kontakForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'create');
            formData.append('id_entitas', idEntitas);
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
                        text: 'Kontak berhasil ditambahkan',
                        icon: 'success',
                        confirmButtonColor: '#4caf50',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'kontak.php?id_entitas=' + idEntitas;
                    });
                } else {
                    Swal.fire('Gagal!', result.message || 'Gagal menyimpan kontak', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan', 'error');
            }
        });
    </script>
</body>
</html>
