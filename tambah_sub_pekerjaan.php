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
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 600px;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
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

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
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

        .btn-cancel {
            background: #f1f1f1;
            color: #666;
        }

        .btn-cancel:hover {
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
    <button class="back-btn" onclick="window.history.back()">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
    </button>

    <div class="container">
        <div class="header">
            <h1>Tambah Sub Pekerjaan</h1>
            <p id="pekerjaanName">Formulir untuk menambah sub pekerjaan</p>
        </div>

        <form id="subPekerjaanForm">
            <input type="hidden" id="idPekerjaan" name="idPekerjaan">
            
            <div class="form-group">
                <label for="namaSubPekerjaan">Nama Sub Pekerjaan *</label>
                <input type="text" id="namaSubPekerjaan" name="namaSubPekerjaan" placeholder="Contoh: Seksi 1 - Jalan Utama" required>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <input type="text" id="catatan" name="catatan" placeholder="Catatan optional">
            </div>

            <div class="btn-group">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Batal</button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        // Set hidden values and load pekerjaan
        const urlParams = new URLSearchParams(window.location.search);
        const idPekerjaan = urlParams.get('id');
        
        document.getElementById('idPekerjaan').value = idPekerjaan;
        
        // Load pekerjaan name
        async function loadPekerjaanName() {
            try {
                const response = await fetch('api/get_pekerjaan.php?id=' + idPekerjaan);
                const result = await response.json();
                
                if (result.success && result.data) {
                    document.getElementById('pekerjaanName').textContent = result.data.nama_pekerjaan || 'Pekerjaan #' + idPekerjaan;
                }
            } catch (error) {
                console.error('Error loading pekerjaan:', error);
            }
        }
        
        if (idPekerjaan) {
            loadPekerjaanName();
        }
        
        // Form submit
        document.getElementById('subPekerjaanForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {
                id_pekerjaan: formData.get('idPekerjaan'),
                nama_sub_pekerjaan: formData.get('namaSubPekerjaan'),
                catatan: formData.get('catatan') || null
            };
            
            try {
                const response = await fetch('api/proses_sub_pekerjaan.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Sub pekerjaan berhasil ditambahkan',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'detail_pekerjaan.php?id=' + idPekerjaan;
                    });
                } else {
                    Swal.fire('Gagal', result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        });
    </script>
</body>
</html>
