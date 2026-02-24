<?php
/**
 * Contoh Penggunaan Folder Helper pada Aplikasi
 * ==============================================
 * 
 * Include file ini di awal setiap file PHP yang perlu membuat folder:
 * require_once 'includes/db_connect.php';
 * require_once 'includes/folder_helper.php';
 */


/**
 * ============================================================
 * CONTOH: Proses Simpan Entitas Baru (tambah_entitas.php)
 * ============================================================
 */

function prosesSimpanEntitas($data) {
    // $data = array dari form
    // $data['namaentitas'], $data['level'], $data['daerah'], etc.
    
    try {
        // 1. Buat folder untuk entitas
        $folderName = createEntityFolder($data['namaentitas']);
        
        // 2. Siapkan data untuk disimpan ke database
        $entitasData = [
            'nama_entitas' => $data['namaentitas'],
            'level' => $data['level'],
            'daerah' => $data['daerah'],
            'alamat' => $data['alamat'],
            'telepon' => $data['telepon'],
            'folder_name' => $folderName
        ];
        
        // 3. Simpan ke database
        $entitasId = insertRecord('entitas', $entitasData);
        
        if ($entitasId) {
            // 4. Handle logo upload jika ada
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $fullPath = BASE_DOCUMENT_PATH . $folderName;
                
                // Ensure folder exists
                if (!is_dir($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                $fullLogoPath = $fullPath . '/logo.' . 
                           pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                $logoRelativePath = RELATIVE_DOCUMENT_PATH . $folderName . '/logo.' . 
                           pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $fullLogoPath)) {
                    // Save RELATIVE path to database (portable)
                    updateRecord('entitas', ['logo' => $logoRelativePath], 'id_entitas = ?', [$entitasId]);
                }
            }
            
            return [
                'success' => true,
                'message' => 'Entitas berhasil ditambahkan dan folder dibuat',
                'folder' => $folderName,
                'id' => $entitasId
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Gagal menyimpan entitas'
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}


/**
 * ============================================================
 * CONTOH: Proses Simpan Pekerjaan Baru (tambah_pekerjaan.php)
 * ============================================================
 */

function prosesSimpanPekerjaan($data) {
    // $data = array dari form
    // $data['namapekerjaan'], $data['jenismodal'], $data['penyedia'], etc.
    
    try {
        // 1. Dapatkan ID dan folder entitas (misalnya dari dropdown)
        $entitasId = $data['id_entitas'];
        $entitas = getRow("SELECT * FROM entitas WHERE id_entitas = ?", [$entitasId]);
        
        if (!$entitas) {
            throw new Exception('Entitas tidak ditemukan');
        }
        
        // 2. Dapatkan atau buat record penyedia
        $penyediaNama = $data['penyedia'];
        $penyedia = getRow("SELECT * FROM penyedia WHERE nama_penyedia = ?", [$penyediaNama]);
        
        if (!$penyedia) {
            // Buat penyedia baru dengan inisial generated
            $inisialPenyedia = getPenyediaInitial($penyediaNama);
            $penyediaId = insertRecord('penyedia', [
                'nama_penyedia' => $penyediaNama,
                'inisial' => $inisialPenyedia
            ]);
            $penyedia = ['id_penyedia' => $penyediaId, 'inisial' => $inisialPenyedia];
        }
        
        // 3. Dapatkan inisial akun belanja
        $inisialAkunBelanja = getAkunBelanjaInitial($data['jenismodal']);
        
        // 4. Dapatkan ID akun belanja dari database
        $akunBelanja = getRow("SELECT * FROM akun_belanja WHERE inisial = ?", [$inisialAkunBelanja]);
        
        // 5. Buat folder untuk pekerjaan
        $jobFolderName = createJobFolder(
            $entitas['folder_name'],
            $inisialAkunBelanja,
            $penyedia['inisial']
        );
        
        // 6. Siapkan data pekerjaan
        $pekerjaanData = [
            'id_entitas' => $entitasId,
            'id_akun_belanja' => $akunBelanja['id_akun_belanja'],
            'id_penyedia' => $penyedia['id_penyedia'],
            'nama_pekerjaan' => $data['namapekerjaan'],
            'nomor_kontrak' => $data['nomorkontrak'],
            'nilai_kontrak' => $data['nilaikontrak'],
            'tanggal_kontrak' => $data['tanggalkontrak'],
            'tanggal_mulai' => $data['tanggalmulai'],
            'tanggal_selesai' => $data['tanggalselesai'],
            'lokasi' => $data['lokasi'],
            'keterangan' => $data['keterangan'],
            'folder_name' => $jobFolderName,
            'inisial_akun_belanja' => $inisialAkunBelanja,
            'inisial_penyedia' => $penyedia['inisial'],
            'status' => 'planning'
        ];
        
        // 7. Simpan ke database
        $pekerjaanId = insertRecord('pekerjaan', $pekerjaanData);
        
        if ($pekerjaanId) {
            // 8. Buat records dokumen otomatis berdasarkan tipe
            $inisialPekerjaan = $inisialAkunBelanja . '_' . $penyedia['inisial'];
            $dokumenTypes = [
                ['Kontrak_Pekerjaan', 'Kontrak/Surat Pemesanan', 'umum'],
                ['SPMK', 'SPMK', 'umum'],
                ['Gambar_Rencana', 'Gambar Rencana', 'umum'],
                ['Gambar_Pelaksanaan', 'Gambar Pelaksanaan', 'umum'],
                ['Backup_Data_Qty', 'Backup Data Quantity', 'umum'],
                ['Monthly_Certificate', 'Monthly Certificate', 'umum'],
                ['Foto', 'Foto (0%, 50% dan 100%)', 'umum'],
                ['BA_Hasil_Pemeriksaan', 'Berita Acara Hasil Pemeriksaan Pekerjaan', 'umum'],
                ['PHO', 'PHO (Provisional Hand Over)', 'umum']
            ];
            
            foreach ($dokumenTypes as $doc) {
                $namaDokumen = $doc[0] . '_' . $inisialPekerjaan;
                insertRecord('dokumen', [
                    'id_pekerjaan' => $pekerjaanId,
                    'nama_dokumen' => $namaDokumen,
                    'jenis_dokumen' => $doc[2],
                    'tipe_dokumen' => $doc[1],
                    'status' => 'belum_upload',
                    'is_required' => true
                ]);
            }
            
            return [
                'success' => true,
                'message' => 'Pekerjaan berhasil ditambahkan',
                'folder' => $entitas['folder_name'] . '/' . $jobFolderName,
                'id' => $pekerjaanId
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Gagal menyimpan pekerjaan'
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}


/**
 * ============================================================
 * CONTOH: Upload Dokumen (pemeriksaan_dokumen.php)
 * ============================================================
 */

function prosesUploadDokumen($idDokumen, $file) {
    try {
        // 1. Dapatkan info dokumen dan pekerjaan
        $dokumen = getRow("SELECT d.*, p.folder_name as job_folder, e.folder_name as entity_folder,
                          p.inisial_akun_belanja, p.inisial_penyedia 
                          FROM dokumen d 
                          JOIN pekerjaan p ON d.id_pekerjaan = p.id_pekerjaan 
                          JOIN entitas e ON p.id_entitas = e.id_entitas 
                          WHERE d.id_dokumen = ?", [$idDokumen]);
        
        if (!$dokumen) {
            throw new Exception('Dokumen tidak ditemukan');
        }
        
        // 2. Tentukan folder tujuan
        $tipeDokumen = strtolower(str_replace(' ', '_', $dokumen['tipe_dokumen']));
        $targetDir = getDocumentPath(
            $dokumen['entity_folder'],
            $dokumen['job_folder'],
            'Dokumen/Umum'
        );
        
        // 3. Generate nama file dengan format: {nama_dokumen}_{inisial_pekerjaan}.{ext}
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = formatDocumentName(
            $dokumen['tipe_dokumen'],
            $dokumen['inisial_akun_belanja'],
            $dokumen['inisial_penyedia'],
            $extension
        );
        
        // 4. Upload file
        $targetPath = $targetDir . '/' . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // 5. Update database
            updateRecord('dokumen', [
                'status' => 'sudah_upload',
                'file_path' => $targetPath,
                'file_size' => $file['size'],
                'uploaded_at' => date('Y-m-d H:i:s')
            ], 'id_dokumen = ?', [$idDokumen]);
            
            return [
                'success' => true,
                'message' => 'Dokumen berhasil diupload',
                'path' => $targetPath
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Gagal upload dokumen'
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}


/**
 * ============================================================
 * CARA MENGGUNAKAN DI FILE PHP ANDA
 * ============================================================
 * 
 * 1. Di awal file tambah_entitas.php atau tambah_pekerjaan.php:
 * 
 * <?php
 * require_once 'includes/db_connect.php';
 * require_once 'includes/folder_helper.php';
 * ?>
 * 
 * 2. Di bagian proses simpan (JavaScript fetch/AJAX):
 * 
 * document.getElementById('entitasForm').addEventListener('submit', function(e) {
 *     e.preventDefault();
 *     
 *     const formData = new FormData(this);
 *     
 *     fetch('proses_entitas.php', {
 *         method: 'POST',
 *         body: formData
 *     })
 *     .then(response => response.json())
 *     .then(data => {
 *         if (data.success) {
 *             Swal.fire({
 *                 title: 'Berhasil!',
 *                 text: 'Entitas berhasil ditambahkan.\nFolder dibuat: ' + data.folder,
 *                 icon: 'success'
 *             }).then(() => {
 *                 window.location.href = 'index.php';
 *             });
 *         } else {
 *             Swal.fire('Gagal', data.message, 'error');
 *         }
 *     });
 * });
 * 
 * 3. Buat file proses_entitas.php untuk menangani penyimpanan:
 * 
 * <?php
 * require_once 'includes/db_connect.php';
 * require_once 'includes/folder_helper.php';
 * 
 * header('Content-Type: application/json');
 * 
 * $data = [
 *     'namaentitas' => $_POST['namaentitas'],
 *     'level' => $_POST['level'],
 *     'daerah' => $_POST['daerah'],
 *     'alamat' => $_POST['alamat'],
 *     'telepon' => $_POST['telepon']
 * ];
 * 
 * $result = prosesSimpanEntitas($data);
 * echo json_encode($result);
 * ?>
 */
