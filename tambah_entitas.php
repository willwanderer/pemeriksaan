<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .logo-upload {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f1f1f1;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            overflow: hidden;
        }

        .logo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-preview svg {
            width: 40px;
            height: 40px;
            fill: #ccc;
        }

        .file-input {
            display: none;
        }

        .upload-label {
            display: inline-block;
            padding: 10px 20px;
            background: #f1f1f1;
            color: #666;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .upload-label:hover {
            background: #e1e1e1;
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
    <button class="back-btn" onclick="window.location.href='index.php'">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Tambah Entitas</h1>
            <p>Daftarkan organisasi/dinas baru</p>
        </div>

        <form id="entitasForm">
            <div class="logo-upload">
                <div class="logo-preview" id="logoPreview">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-4.86 8.86l-3 3.87L9 13.14 6 17h12l-3.86-5.14z"/>
                    </svg>
                </div>
                <label for="logo" class="upload-label">Pilih Logo</label>
                <input type="file" id="logo" name="logo" class="file-input" accept="image/*">
            </div>

            <div class="form-group">
                <label for="namaentitas">Nama Entitas</label>
                <input type="text" id="namaentitas" name="nama_entitas" placeholder="Dinas Pekerjaan Umum" required>
            </div>

            <div class="form-group">
                <label for="level">Level</label>
                <select id="level" name="level" required>
                    <option value="">Pilih Level</option>
                    <option value="provinsi">Provinsi</option>
                    <option value="kabupaten">Kabupaten/Kota</option>
                    <option value="kecamatan">Kecamatan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="daerah">Daerah</label>
                <input type="text" id="daerah" name="daerah" placeholder="Provinsi Jawa Barat">
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" placeholder="Jl. Braga No. 45, Bandung">
            </div>

            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="tel" id="telepon" name="telepon" placeholder="(022) 1234567">
            </div>

            <div class="btn-group">
                <button type="button" class="btn-batal" onclick="window.location.href='index.php'">Batal</button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        // Logo preview
        const logoInput = document.getElementById('logo');
        const logoPreview = document.getElementById('logoPreview');

        logoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    logoPreview.innerHTML = '<img src="' + e.target.result + '" alt="Logo">';
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('entitasForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'create');
            formData.append('nama_entitas', document.getElementById('namaentitas').value);
            formData.append('level', document.getElementById('level').value);
            formData.append('daerah', document.getElementById('daerah').value);
            formData.append('alamat', document.getElementById('alamat').value);
            formData.append('telepon', document.getElementById('telepon').value);
            
            try {
                const response = await fetch('api/proses_entitas.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Entitas berhasil ditambahkan',
                        icon: 'success',
                        confirmButtonColor: '#667eea',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';
                        }
                    });
                } else {
                    Swal.fire('Gagal', result.message || 'Gagal menyimpan entitas', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        });
    </script>
</body>
</html>
