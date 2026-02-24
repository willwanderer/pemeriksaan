<?php
/**
 * Proses Pemeriksaan Pekerjaan - Simpan/Load Data Pemeriksaan
 * Handles examination/inspection data for each job
 * 
 * Examination items:
 * - Dokumen Pendukung (Supporting Documents)
 * - Pekerjaan Diselesaikan Sesuai Periode (Work Completed on Time)
 * - Belanja Dicatat Periode yang Tepat (Expenses Recorded in Correct Period)
 * - Klasifikasi Akun Belanja Sesuai (Expense Account Classification)
 * - Pembayaran Retensi Didukung Bank Garansi (Retention Payment with Bank Guarantee)
 */

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/folder_helper.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

// Get existing examination data
if ($method === 'GET') {
    // Skip to action-specific handlers if action is specified
    if (isset($_GET['action'])) {
        // Let action-specific handlers process this request - do nothing here
    } else {
        $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
        
        if (!$id_pekerjaan) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan diperlukan'
            ]);
            exit;
        }
        
        try {
            // Get examination data
            $pemeriksaan = getRow(
                "SELECT * FROM pemeriksaan_pekerjaan WHERE id_pekerjaan = ?",
                [$id_pekerjaan]
            );
            
            // Get document counts
            $dokumenCounts = getRow(
                "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'sudah_upload' THEN 1 ELSE 0 END) as terupload
                 FROM dokumen WHERE id_pekerjaan = ?",
                [$id_pekerjaan]
            );
            
            // Get total required documents
            $dokumenTotal = getRow(
                "SELECT COUNT(*) as total FROM dokumen WHERE id_pekerjaan = ?",
                [$id_pekerjaan]
            );
            
            // Get serah_terima data for bank guarantee info
            $serahTerima = getRow(
                "SELECT nilai_garansi_bank, file_garansi_bank FROM serah_terima 
                 WHERE id_pekerjaan = ? AND jenis_serah_terima = 'FHO'",
                [$id_pekerjaan]
            );
            
            // Get pekerjaan data for period comparison
            $pekerjaan = getRow(
                "SELECT tanggal_selesai, pho_date FROM (
                    SELECT p.tanggal_selesai, MAX(st.tanggal_serah_terima) as pho_date
                    FROM pekerjaan p
                    LEFT JOIN serah_terima st ON p.id_pekerjaan = st.id_pekerjaan 
                        AND st.jenis_serah_terima = 'FHO'
                    WHERE p.id_pekerjaan = ?
                    GROUP BY p.id_pekerjaan, p.tanggal_selesai
                ) as subquery",
                [$id_pekerjaan]
            );
            
            echo json_encode([
                'success' => true,
                'data' => $pemeriksaan,
                'dokumen' => [
                    'total' => $dokumenTotal['total'] ?? 0,
                    'terupload' => $dokumenCounts['terupload'] ?? 0
                ],
                'serah_terima' => $serahTerima,
                'pekerjaan' => $pekerjaan
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}

// Save/update examination data
if ($method === 'POST') {
    $action = $_POST['action'] ?? 'save';
    
    // Handle delete_denda action - no need for id_pekerjaan
    if ($action === 'delete_denda') {
        header('Content-Type: application/json');
        $id_denda = $_POST['id_denda'] ?? null;
        
        if (!$id_denda) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Denda diperlukan'
            ]);
            exit;
        }
        
        try {
            $result = deleteRecord('denda_keterlambatan', 'id_denda = ?', [$id_denda]);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Data denda berhasil dihapus'
                ]);
            } else {
                throw new Exception('Gagal menghapus data denda');
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // For other actions, id_pekerjaan is required
    $id_pekerjaan = $_POST['id_pekerjaan'] ?? null;
    
    // Handle save_denda action
    if ($action === 'save_denda') {
        $id_pekerjaan = $_POST['id_pekerjaan'] ?? null;
        $id_denda = $_POST['id_denda'] ?? null;
        
        if (!$id_pekerjaan) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan diperlukan'
            ]);
            exit;
        }
        
        try {
            // Prepare data - no more jenis_ketentuan
            $data = [
                'sk_denda_ditetapkan' => $_POST['sk_denda_ditetapkan'] ?? 0,
                'catatan' => $_POST['catatan'] ?? '',
                'besaran_denda' => $_POST['besaran_denda'] ?? 0.001,
                'dasar_pengenaan' => $_POST['dasar_pengenaan'] ?? 0,
                'persentase' => $_POST['persentase'] ?? 100,
                'jumlah_hari_keterlambatan' => $_POST['jumlah_hari_keterlambatan'] ?? 0,
                'nilai_denda' => $_POST['nilai_denda'] ?? 0
            ];
            
            // Handle kertas kerja file upload
            if (isset($_FILES['kertas_kerja']) && $_FILES['kertas_kerja']['error'] === UPLOAD_ERR_OK) {
                // Get pekerjaan folder info
                $pekerjaan = getRow(
                    "SELECT p.folder_name, e.folder_name as entity_folder 
                     FROM pekerjaan p 
                     LEFT JOIN entitas e ON p.id_entitas = e.id_entitas 
                     WHERE p.id_pekerjaan = ?",
                    [$id_pekerjaan]
                );
                
                if ($pekerjaan) {
                    $uploadDir = BASE_DOCUMENT_PATH . $pekerjaan['entity_folder'] . '/' . $pekerjaan['folder_name'] . '/Dokumen/Denda';
                    
                    // Create directory if not exists
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $fileExt = pathinfo($_FILES['kertas_kerja']['name'], PATHINFO_EXTENSION);
                    $fileName = 'Kertas_Kerja_Denda_' . date('Ymd_His') . '.' . $fileExt;
                    $filePath = $uploadDir . '/' . $fileName;
                    
                    if (move_uploaded_file($_FILES['kertas_kerja']['tmp_name'], $filePath)) {
                        $data['kertas_kerja_path'] = $filePath;
                    }
                }
            }
            
            $idDenda = null;
            
            if ($id_denda) {
                // Update existing record by id_denda
                $result = updateRecord('denda_keterlambatan', $data, 'id_denda = ?', [$id_denda]);
                $idDenda = $id_denda;
                if ($result === false) {
                    throw new Exception('Gagal mengupdate data denda');
                }
                $result = true;
            } else {
                // Insert new record
                $data['id_pekerjaan'] = $id_pekerjaan;
                $idDenda = insertRecord('denda_keterlambatan', $data);
                $result = $idDenda ? true : false;
            }
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Data denda berhasil disimpan',
                    'id_denda' => $idDenda,
                    'nilai_denda' => $data['nilai_denda']
                ]);
            } else {
                throw new Exception('Gagal menyimpan data denda');
            }
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Handle upload_dokumen action separately (needs file handling)
    if ($action === 'upload_dokumen') {
        $doc_id = $_POST['doc_id'] ?? null;
        
        error_log("Upload request - id_pekerjaan: " . $id_pekerjaan . ", doc_id: " . $doc_id);
        
        if (!$id_pekerjaan || !$doc_id) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan dan ID Dokumen diperlukan'
            ]);
            exit;
        }
        
        try {
            // Check if file was uploaded
            if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                $error = isset($_FILES['file']) ? $_FILES['file']['error'] : 'No file uploaded';
                error_log("File upload error: " . $error);
                throw new Exception('Gagal mengupload file. Error code: ' . $error);
            }
            
            // Get pekerjaan folder info with inisial for file naming
            $pekerjaan = getRow(
                "SELECT p.folder_name, p.inisial_akun_belanja, p.inisial_penyedia, e.folder_name as entity_folder 
                 FROM pekerjaan p 
                 LEFT JOIN entitas e ON p.id_entitas = e.id_entitas 
                 WHERE p.id_pekerjaan = ?",
                [$id_pekerjaan]
            );
            
            error_log("Pekerjaan data: " . print_r($pekerjaan, true));
            
            if (!$pekerjaan) {
                throw new Exception('Pekerjaan tidak ditemukan');
            }
            
            // Handle file upload
            $uploadDir = BASE_DOCUMENT_PATH;
            
            // Document configuration: name, subfolder, jenis_dokumen
            $docConfig = [
                // Dokumen Umum (doc1-doc9)
                'doc1' => ['name' => 'Kontrak_Surat_Pemesanan', 'subfolder' => 'Dokumen/Umum', 'jenis' => 'umum'],
                'doc2' => ['name' => 'SPMK', 'subfolder' => 'Dokumen/Umum', 'jenis' => 'umum'],
                'doc3' => ['name' => 'Gambar_Rencana', 'subfolder' => 'Gambar', 'jenis' => 'umum'],
                'doc4' => ['name' => 'Gambar_Pelaksanaan', 'subfolder' => 'Gambar', 'jenis' => 'umum'],
                'doc5' => ['name' => 'Backup_Data_Quantity', 'subfolder' => 'Dokumen/Umum', 'jenis' => 'umum'],
                'doc6' => ['name' => 'Monthly_Certificate', 'subfolder' => 'Dokumen/Umum', 'jenis' => 'umum'],
                'doc7' => ['name' => 'Foto', 'subfolder' => 'Foto', 'jenis' => 'umum'],
                'doc8' => ['name' => 'BA_Hasil_Pemeriksaan', 'subfolder' => 'Dokumen/Umum', 'jenis' => 'umum'],
                'doc9' => ['name' => 'PHO', 'subfolder' => 'Serah_Terima', 'jenis' => 'umum'],
                // Dokumen Tanah (doc10-doc15)
                'doc10' => ['name' => 'BA_Pengadaan_Pelepasan_Tanah', 'subfolder' => 'Dokumen/Tanah', 'jenis' => 'tanah'],
                'doc11' => ['name' => 'Surat_Keterangan_Penjualan_Tanah', 'subfolder' => 'Dokumen/Tanah', 'jenis' => 'tanah'],
                'doc12' => ['name' => 'Surat_Persetujuan_Pemilik_Tanah', 'subfolder' => 'Dokumen/Tanah', 'jenis' => 'tanah'],
                'doc13' => ['name' => 'Surat_Pernyataan_Pemilik_Tanah', 'subfolder' => 'Dokumen/Tanah', 'jenis' => 'tanah'],
                'doc14' => ['name' => 'Sertifikat_Tanah_Pemilik', 'subfolder' => 'Dokumen/Tanah', 'jenis' => 'tanah'],
                'doc15' => ['name' => 'Dokumen_Apraisal_Tanah', 'subfolder' => 'Dokumen/Tanah', 'jenis' => 'tanah']
            ];
            
            // Get document config
            $config = $docConfig[$doc_id] ?? ['name' => 'Dokumen', 'subfolder' => 'Dokumen/Umum', 'jenis' => 'umum'];
            $docName = $config['name'];
            $subfolder = $config['subfolder'];
            $jenisDokumen = $config['jenis'];
            
            // Use entity_folder if available, otherwise use just folder_name
            $entityFolder = $pekerjaan['entity_folder'] ?? '';
            $jobFolder = $pekerjaan['folder_name'] ?? '';
            $inisialAkun = $pekerjaan['inisial_akun_belanja'] ?? '';
            $inisialPenyedia = $pekerjaan['inisial_penyedia'] ?? '';
            
            if (empty($entityFolder)) {
                // Fallback: assume folder_name already contains entity prefix
                $targetDir = $uploadDir . $jobFolder . '/' . $subfolder . '/';
                $relativePath = 'dokumen_pemeriksaan/' . $jobFolder . '/' . $subfolder . '/';
            } else {
                $targetDir = $uploadDir . $entityFolder . '/' . $jobFolder . '/' . $subfolder . '/';
                $relativePath = 'dokumen_pemeriksaan/' . $entityFolder . '/' . $jobFolder . '/' . $subfolder . '/';
            }
            
            // Generate filename: {NamaDokumen}_{InisialAkun}_{InisialPenyedia}.{ext}
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if (!empty($inisialAkun) && !empty($inisialPenyedia)) {
                $fileName = $docName . '_' . $inisialAkun . '_' . $inisialPenyedia . '.' . $extension;
            } else {
                $fileName = $docName . '_' . time() . '.' . $extension;
            }
            
            $targetPath = $targetDir . $fileName;
            
            error_log("Target directory: " . $targetDir);
            error_log("Target path: " . $targetPath);
            
            // Ensure directory exists
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    throw new Exception('Gagal membuat direktori: ' . $targetDir);
                }
            }
            
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                // Use correct relative path (include filename)
                $relativePathSave = $relativePath . $fileName;
                
                error_log("File uploaded successfully to: " . $targetPath);
                error_log("Relative path: " . $relativePathSave);
                
                // Save to database - check if record exists
                $existingDokumen = getRow(
                    "SELECT id_dokumen FROM dokumen WHERE id_pekerjaan = ? AND doc_id = ?",
                    [$id_pekerjaan, $doc_id]
                );
                
                if ($existingDokumen) {
                    // Update existing
                    $data = [
                        'file_path' => $relativePathSave,
                        'nama_dokumen_asli' => $_FILES['file']['name'],
                        'nama_dokumen' => $docName,
                        'jenis_dokumen' => $jenisDokumen,
                        'status' => 'sudah_upload',
                        'uploaded_at' => date('Y-m-d H:i:s')
                    ];
                    $result = updateRecord('dokumen', $data, 'id_dokumen = ?', [$existingDokumen['id_dokumen']]);
                    error_log("Update result: " . ($result ? 'success' : 'failed'));
                } else {
                    // Insert new
                    $data = [
                        'id_pekerjaan' => $id_pekerjaan,
                        'doc_id' => $doc_id,
                        'nama_dokumen' => $docName,
                        'nama_dokumen_asli' => $_FILES['file']['name'],
                        'jenis_dokumen' => $jenisDokumen,
                        'file_path' => $relativePathSave,
                        'status' => 'sudah_upload',
                        'uploaded_at' => date('Y-m-d H:i:s'),
                        'kategori_dokumen' => $jenisDokumen
                    ];
                    $result = insertRecord('dokumen', $data);
                    error_log("Insert result: " . ($result ? 'success (ID: ' . $result . ')' : 'failed'));
                }
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Dokumen berhasil diupload',
                    'file_path' => $relativePathSave,
                    'file_name' => $_FILES['file']['name'],
                    'saved_name' => $fileName
                ]);
            } else {
                throw new Exception('Gagal memindahkan file yang diupload');
            }
            
        } catch (Exception $e) {
            error_log("Upload error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Handle delete_dokumen action
    if ($action === 'delete_dokumen') {
        $doc_id = $_POST['doc_id'] ?? null;
        
        error_log("Delete request - id_pekerjaan: " . $id_pekerjaan . ", doc_id: " . $doc_id);
        
        if (!$id_pekerjaan || !$doc_id) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan dan ID Dokumen diperlukan'
            ]);
            exit;
        }
        
        try {
            // Get document info
            $dokumen = getRow(
                "SELECT id_dokumen, file_path FROM dokumen WHERE id_pekerjaan = ? AND doc_id = ?",
                [$id_pekerjaan, $doc_id]
            );
            
            if (!$dokumen) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Dokumen tidak ditemukan'
                ]);
                exit;
            }
            
            // Delete file from filesystem
            $filePath = __DIR__ . '/../' . $dokumen['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
                error_log("File deleted: " . $filePath);
            }
            
            // Delete from database
            $result = deleteRecord('dokumen', 'id_dokumen = ?', [$dokumen['id_dokumen']]);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Dokumen berhasil dihapus'
                ]);
            } else {
                throw new Exception('Gagal menghapus dokumen dari database');
            }
            
        } catch (Exception $e) {
            error_log("Delete error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Handle add_dokumen_lainnya action - create new entry
    if ($action === 'add_dokumen_lainnya') {
        $nama_dokumen = $_POST['nama_dokumen'] ?? null;
        
        if (!$id_pekerjaan || !$nama_dokumen) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan dan Nama Dokumen diperlukan'
            ]);
            exit;
        }
        
        try {
            // Insert new dokumen lainnya entry
            $data = [
                'id_pekerjaan' => $id_pekerjaan,
                'doc_id' => 'lainnya_' . time(),
                'nama_dokumen' => $nama_dokumen,
                'jenis_dokumen' => 'lainnya',
                'kategori_dokumen' => 'lainnya',
                'status' => 'belum_upload',
                'is_required' => 0
            ];
            
            $result = insertRecord('dokumen', $data);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Entry dokumen berhasil ditambahkan',
                    'id_dokumen' => $result
                ]);
            } else {
                throw new Exception('Gagal menambahkan entry dokumen');
            }
            
        } catch (Exception $e) {
            error_log("Add dokumen lainnya error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Handle upload_dokumen_lainnya action
    if ($action === 'upload_dokumen_lainnya') {
        $id_dokumen = $_POST['id_dokumen'] ?? null;
        
        if (!$id_pekerjaan || !$id_dokumen) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan dan ID Dokumen diperlukan'
            ]);
            exit;
        }
        
        try {
            // Check if file was uploaded
            if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                $error = isset($_FILES['file']) ? $_FILES['file']['error'] : 'No file uploaded';
                throw new Exception('Gagal mengupload file. Error code: ' . $error);
            }
            
            // Get pekerjaan folder info
            $pekerjaan = getRow(
                "SELECT p.folder_name, p.inisial_akun_belanja, p.inisial_penyedia, e.folder_name as entity_folder 
                 FROM pekerjaan p 
                 LEFT JOIN entitas e ON p.id_entitas = e.id_entitas 
                 WHERE p.id_pekerjaan = ?",
                [$id_pekerjaan]
            );
            
            if (!$pekerjaan) {
                throw new Exception('Pekerjaan tidak ditemukan');
            }
            
            // Get dokumen info
            $dokumen = getRow(
                "SELECT * FROM dokumen WHERE id_dokumen = ? AND id_pekerjaan = ?",
                [$id_dokumen, $id_pekerjaan]
            );
            
            if (!$dokumen) {
                throw new Exception('Dokumen tidak ditemukan');
            }
            
            // Handle file upload
            $uploadDir = BASE_DOCUMENT_PATH;
            $subfolder = 'Dokumen/Lainnya';
            
            $entityFolder = $pekerjaan['entity_folder'] ?? '';
            $jobFolder = $pekerjaan['folder_name'] ?? '';
            $inisialAkun = $pekerjaan['inisial_akun_belanja'] ?? '';
            $inisialPenyedia = $pekerjaan['inisial_penyedia'] ?? '';
            
            if (empty($entityFolder)) {
                $targetDir = $uploadDir . $jobFolder . '/' . $subfolder . '/';
                $relativePath = 'dokumen_pemeriksaan/' . $jobFolder . '/' . $subfolder . '/';
            } else {
                $targetDir = $uploadDir . $entityFolder . '/' . $jobFolder . '/' . $subfolder . '/';
                $relativePath = 'dokumen_pemeriksaan/' . $entityFolder . '/' . $jobFolder . '/' . $subfolder . '/';
            }
            
            // Generate filename
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $docName = preg_replace('/[^A-Za-z0-9]/', '_', $dokumen['nama_dokumen']);
            $fileName = $docName . '_' . time() . '.' . $extension;
            
            $targetPath = $targetDir . $fileName;
            
            // Ensure directory exists
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    throw new Exception('Gagal membuat direktori: ' . $targetDir);
                }
            }
            
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                $relativePathSave = $relativePath . $fileName;
                
                // Update dokumen record
                $updateData = [
                    'file_path' => $relativePathSave,
                    'nama_dokumen_asli' => $_FILES['file']['name'],
                    'status' => 'sudah_upload',
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];
                $result = updateRecord('dokumen', $updateData, 'id_dokumen = ?', [$id_dokumen]);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Dokumen berhasil diupload',
                    'file_path' => $relativePathSave,
                    'file_name' => $_FILES['file']['name']
                ]);
            } else {
                throw new Exception('Gagal memindahkan file yang diupload');
            }
            
        } catch (Exception $e) {
            error_log("Upload dokumen lainnya error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Handle delete_dokumen_lainnya action (delete file only, keep entry)
    if ($action === 'delete_dokumen_lainnya') {
        $id_dokumen = $_POST['id_dokumen'] ?? null;
        
        if (!$id_pekerjaan || !$id_dokumen) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan dan ID Dokumen diperlukan'
            ]);
            exit;
        }
        
        try {
            // Get document info
            $dokumen = getRow(
                "SELECT id_dokumen, file_path FROM dokumen WHERE id_pekerjaan = ? AND id_dokumen = ?",
                [$id_pekerjaan, $id_dokumen]
            );
            
            if (!$dokumen) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Dokumen tidak ditemukan'
                ]);
                exit;
            }
            
            // Delete file from filesystem
            if ($dokumen['file_path']) {
                $filePath = __DIR__ . '/../' . $dokumen['file_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            // Update database - reset to belum_upload
            $updateData = [
                'file_path' => null,
                'nama_dokumen_asli' => null,
                'status' => 'belum_upload',
                'uploaded_at' => null
            ];
            $result = updateRecord('dokumen', $updateData, 'id_dokumen = ?', [$id_dokumen]);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'File dokumen berhasil dihapus'
                ]);
            } else {
                throw new Exception('Gagal mengupdate status dokumen');
            }
            
        } catch (Exception $e) {
            error_log("Delete dokumen lainnya error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Handle remove_dokumen_lainnya action (delete entry completely)
    if ($action === 'remove_dokumen_lainnya') {
        $id_dokumen = $_POST['id_dokumen'] ?? null;
        
        if (!$id_pekerjaan || !$id_dokumen) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan dan ID Dokumen diperlukan'
            ]);
            exit;
        }
        
        try {
            // Get document info
            $dokumen = getRow(
                "SELECT id_dokumen, file_path FROM dokumen WHERE id_pekerjaan = ? AND id_dokumen = ?",
                [$id_pekerjaan, $id_dokumen]
            );
            
            if (!$dokumen) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Dokumen tidak ditemukan'
                ]);
                exit;
            }
            
            // Delete file from filesystem
            if ($dokumen['file_path']) {
                $filePath = __DIR__ . '/../' . $dokumen['file_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            // Delete from database
            $result = deleteRecord('dokumen', 'id_dokumen = ?', [$id_dokumen]);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Entry dokumen berhasil dihapus'
                ]);
            } else {
                throw new Exception('Gagal menghapus entry dokumen');
            }
            
        } catch (Exception $e) {
            error_log("Remove dokumen lainnya error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    if (!$id_pekerjaan) {
        echo json_encode([
            'success' => false,
            'message' => 'ID Pekerjaan diperlukan'
        ]);
        exit;
    }
    
    try {
        // Check if examination record exists
        $existing = getRow(
            "SELECT id_pemeriksaan FROM pemeriksaan_pekerjaan WHERE id_pekerjaan = ?",
            [$id_pekerjaan]
        );
        
        // Prepare data based on action type
        if ($action === 'save_periode') {
            // Pekerjaan Diselesaikan Sesuai Periode
            $data = [
                'pekerjaan_selesai_periode' => $_POST['value'] === 'true' ? 1 : 0,
                'pekerjaan_periode_tanggal' => date('Y-m-d'),
                'pekerjaan_periode_catatan' => $_POST['catatan'] ?? null,
                'status_pemeriksaan' => 'sedang_cek',
                'tanggal_pemeriksaan' => date('Y-m-d')
            ];
        } elseif ($action === 'save_belanja_periode') {
            // Belanja Dicatat Periode yang Tepat
            $data = [
                'belanja_periode_tepat' => $_POST['value'] === 'true' ? 1 : 0,
                'belanja_periode_tanggal' => date('Y-m-d'),
                'belanja_periode_catatan' => $_POST['catatan'] ?? null,
                'status_pemeriksaan' => 'sedang_cek',
                'tanggal_pemeriksaan' => date('Y-m-d')
            ];
        } elseif ($action === 'save_klasifikasi') {
            // Klasifikasi Akun Belanja Sesuai
            $data = [
                'klasifikasi_akun_sesuai' => $_POST['value'] === 'true' ? 1 : 0,
                'klasifikasi_akun_tanggal' => date('Y-m-d'),
                'klasifikasi_akun_catatan' => $_POST['catatan'] ?? null,
                'status_pemeriksaan' => 'sedang_cek',
                'tanggal_pemeriksaan' => date('Y-m-d')
            ];
        } elseif ($action === 'save_garansi') {
            // Pembayaran Retensi Didukung Bank Garansi
            $data = [
                'retensi_ada_bank_garansi' => $_POST['value'] === 'true' ? 1 : 0,
                'retensi_nilai' => str_replace(['.', ','], '', $_POST['nilai'] ?? '0'),
                'retensi_tanggal' => date('Y-m-d'),
                'retensi_catatan' => $_POST['catatan'] ?? null,
                'status_pemeriksaan' => 'sedang_cek',
                'tanggal_pemeriksaan' => date('Y-m-d')
            ];
            
            // Handle file upload if provided
            if (!empty($_FILES['file']['name'])) {
                $uploadDir = __DIR__ . '/../dokumen_pemeriksaan/';
                
                // Get folder name for this job
                $pekerjaan = getRow(
                    "SELECT folder_name FROM pekerjaan WHERE id_pekerjaan = ?",
                    [$id_pekerjaan]
                );
                
                if ($pekerjaan) {
                    $targetDir = $uploadDir . $pekerjaan['folder_name'] . '/Retensi/';
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true);
                    }
                    
                    $fileName = 'Bank_Garansi_' . time() . '_' . basename($_FILES['file']['name']);
                    $targetPath = $targetDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                        $data['retensi_file_path'] = 'dokumen_pemeriksaan/' . $pekerjaan['folder_name'] . '/Retensi/' . $fileName;
                    }
                }
            }
        } elseif ($action === 'save_dokumen') {
            // Dokumen Pendukung status update
            $dokumenTotal = $_POST['dokumen_total'] ?? 0;
            $dokumenTerupload = $_POST['dokumen_terupload'] ?? 0;
            
            $status = 'belum_lengkap';
            if ($dokumenTerupload >= $dokumenTotal && $dokumenTotal > 0) {
                $status = 'lengkap';
            }
            
            $data = [
                'dokumen_total' => $dokumenTotal,
                'dokumen_terupload' => $dokumenTerupload,
                'dokumen_status' => $status,
                'dokumen_catatan' => $_POST['catatan'] ?? null,
                'status_pemeriksaan' => 'sedang_cek',
                'tanggal_pemeriksaan' => date('Y-m-d')
            ];
        } elseif ($action === 'save_catatan') {
            // Catatan Umum Pemeriksaan Pekerjaan
            $data = [
                'catatan' => $_POST['catatan'] ?? null,
                'status_pemeriksaan' => 'sedang_cek',
                'tanggal_pemeriksaan' => date('Y-m-d')
            ];
        } else {
            // General save - update status only
            $data = [
                'status_pemeriksaan' => 'selesai_cek',
                'tanggal_pemeriksaan' => date('Y-m-d')
            ];
        }
        
        if ($existing) {
            // Update existing record
            $result = updateRecord('pemeriksaan_pekerjaan', $data, 'id_pekerjaan = ?', [$id_pekerjaan]);
        } else {
            // Insert new record
            $data['id_pekerjaan'] = $id_pekerjaan;
            $result = insertRecord('pemeriksaan_pekerjaan', $data);
        }
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data pemeriksaan berhasil disimpan'
            ]);
        } else {
            throw new Exception('Gagal menyimpan data');
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Handle GET request for denda data (single by id_denda or latest by id_pekerjaan)
if (isset($_GET['action']) && $_GET['action'] === 'get_denda') {
        $id_denda = $_GET['id_denda'] ?? null;
        $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
        
        try {
            if ($id_denda) {
                // Get single record by id_denda
                $denda = getRow(
                    "SELECT * FROM denda_keterlambatan WHERE id_denda = ?",
                    [$id_denda]
                );
            } elseif ($id_pekerjaan) {
                // Get latest record by id_pekerjaan
                $denda = getRow(
                    "SELECT * FROM denda_keterlambatan WHERE id_pekerjaan = ? ORDER BY created_at DESC LIMIT 1",
                    [$id_pekerjaan]
                );
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID Denda atau ID Pekerjaan diperlukan'
                ]);
                exit;
            }
            
            echo json_encode([
                'success' => true,
                'data' => $denda
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Handle GET request for all denda data (multiple records)
    if (isset($_GET['action']) && $_GET['action'] === 'get_all_denda') {
        $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
        
        if (!$id_pekerjaan) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Pekerjaan diperlukan'
            ]);
            exit;
        }
        
        try {
            $denda = getRows(
                "SELECT * FROM denda_keterlambatan WHERE id_pekerjaan = ? ORDER BY created_at DESC",
                [$id_pekerjaan]
            );
            
            echo json_encode([
                'success' => true,
                'data' => $denda
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }

// Default response
echo json_encode([
    'success' => false,
    'message' => 'Method tidak valid'
]);
