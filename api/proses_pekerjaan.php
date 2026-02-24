<?php
/**
 * Proses Pekerjaan - Simpan/Edit/Hapus Pekerjaan/Proyek
 */

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/folder_helper.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? 'create';
    
    if ($action === 'create') {
        try {
            // Get entity info
            $entitas = getRow("SELECT * FROM entitas WHERE id_entitas = ?", [$_POST['id_entitas']]);
            if (!$entitas) {
                throw new Exception('Entitas tidak ditemukan');
            }
            
            // Get or create penyedia
            $penyediaNama = $_POST['penyedia'];
            $penyedia = getRow("SELECT * FROM penyedia WHERE nama_penyedia = ?", [$penyediaNama]);
            
            if (!$penyedia) {
                $inisialPenyedia = getPenyediaInitial($penyediaNama);
                $penyediaId = insertRecord('penyedia', [
                    'nama_penyedia' => $penyediaNama,
                    'inisial' => $inisialPenyedia
                ]);
                $penyedia = ['id_penyedia' => $penyediaId, 'inisial' => $inisialPenyedia];
            }
            
            // Get akun belanja
            $inisialAkunBelanja = getAkunBelanjaInitial($_POST['jenismodal']);
            $akunBelanja = getRow("SELECT * FROM akun_belanja WHERE inisial = ?", [$inisialAkunBelanja]);
            
            // Create job folder
            $jobFolderName = createJobFolder(
                $entitas['folder_name'],
                $inisialAkunBelanja,
                $penyedia['inisial']
            );
            
            // Save to database
            $data = [
                'id_entitas' => $_POST['id_entitas'],
                'id_akun_belanja' => $akunBelanja['id_akun_belanja'],
                'id_penyedia' => $penyedia['id_penyedia'],
                'nama_pekerjaan' => $_POST['namapekerjaan'],
                'skpd' => $_POST['skpd'] ?? null,
                'nomor_kontrak' => $_POST['nomorkontrak'],
                'nilai_kontrak' => str_replace(['.', ','], '', $_POST['nilaikontrak']),
                'tanggal_kontrak' => $_POST['tanggalkontrak'],
                'tanggal_mulai' => $_POST['tanggalmulai'] ?? null,
                'tanggal_selesai' => $_POST['tanggalselesai'] ?? null,
                'lokasi' => $_POST['lokasi'],
                'keterangan' => $_POST['keterangan'] ?? null,
                'folder_name' => $jobFolderName,
                'inisial_akun_belanja' => $inisialAkunBelanja,
                'inisial_penyedia' => $penyedia['inisial'],
                'status' => 'planning'
            ];
            
            $id = insertRecord('pekerjaan', $data);
            
            if ($id) {
                // Auto-create document records
                $inisialPekerjaan = $inisialAkunBelanja . '_' . $penyedia['inisial'];
                $dokumenTypes = [
                    ['Kontrak_Pekerjaan', 'Kontrak/Surat Pemesanan', 'umum'],
                    ['SPMK', 'SPMK', 'umum'],
                    ['Gambar_Rencana', 'Gambar Rencana', 'umum'],
                    ['Gambar_Pelaksanaan', 'Gambar Pelaksanaan', 'umum'],
                    ['Backup_Data_Qty', 'Backup Data Quantity', 'umum'],
                    ['Monthly_Certificate', 'Monthly Certificate', 'umum'],
                    ['Foto', 'Foto (0%, 50% dan 100%)', 'umum'],
                    ['BA_Hasil_Pemeriksaan', 'BA Hasil Pemeriksaan', 'umum'],
                    ['PHO', 'PHO (Provisional Hand Over)', 'umum']
                ];
                
                foreach ($dokumenTypes as $doc) {
                    $namaDokumen = $doc[0] . '_' . $inisialPekerjaan;
                    insertRecord('dokumen', [
                        'id_pekerjaan' => $id,
                        'nama_dokumen' => $namaDokumen,
                        'jenis_dokumen' => $doc[2],
                        'tipe_dokumen' => $doc[1],
                        'status' => 'belum_upload',
                        'is_required' => true
                    ]);
                }
                
                jsonResponse([
                    'success' => true,
                    'message' => 'Pekerjaan berhasil ditambahkan',
                    'folder' => $entitas['folder_name'] . '/' . $jobFolderName,
                    'id' => $id
                ]);
            } else {
                throw new Exception('Gagal menyimpan pekerjaan');
            }
        } catch (Exception $e) {
            jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
        }
        
    } elseif ($action === 'update') {
        $id = $_POST['id_pekerjaan'];
        
        $data = [
            'nama_pekerjaan' => $_POST['namapekerjaan'],
            'skpd' => $_POST['skpd'] ?? null,
            'nomor_kontrak' => $_POST['nomorkontrak'],
            'nilai_kontrak' => str_replace(['.', ','], '', $_POST['nilaikontrak']),
            'tanggal_kontrak' => $_POST['tanggalkontrak'],
            'tanggal_mulai' => $_POST['tanggalmulai'] ?? null,
            'tanggal_selesai' => $_POST['tanggalselesai'] ?? null,
            'lokasi' => $_POST['lokasi'],
            'keterangan' => $_POST['keterangan'] ?? null,
            'catatan' => $_POST['catatan'] ?? null,
            'status' => $_POST['status'] ?? 'planning'
        ];
        
        $result = updateRecord('pekerjaan', $data, 'id_pekerjaan = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Pekerjaan berhasil diperbarui']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui pekerjaan'], 500);
        }
        
    } elseif ($action === 'delete') {
        $id = $_POST['id_pekerjaan'];
        
        // Get folder name
        $pekerjaan = getRow("SELECT p.folder_name, e.folder_name as entity_folder 
                            FROM pekerjaan p 
                            JOIN entitas e ON p.id_entitas = e.id_entitas 
                            WHERE p.id_pekerjaan = ?", [$id]);
        
        $result = deleteRecord('pekerjaan', 'id_pekerjaan = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Pekerjaan berhasil dihapus']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menghapus pekerjaan'], 500);
        }
    }
}

// GET - Fetch pekerjaan
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    $id_entitas = $_GET['id_entitas'] ?? null;
    
    if ($id) {
        $sql = "SELECT p.*, e.nama_entitas, ab.nama_akun as nama_akun_belanja, 
                pen.nama_penyedia, pen.inisial as inisial_penyedia,
                (SELECT MAX(tanggal_selesai_baru) FROM addendum WHERE id_pekerjaan = p.id_pekerjaan) as latest_addendum_end,
                (SELECT tanggal_serah_terima FROM serah_terima WHERE id_pekerjaan = p.id_pekerjaan AND jenis_serah_terima = 'PHO' AND status_serah_terima = 'completed' ORDER BY tanggal_serah_terima DESC LIMIT 1) as pho_date,
                (SELECT nilai_addendum FROM addendum WHERE id_pekerjaan = p.id_pekerjaan ORDER BY tanggal_addendum DESC, id_addendum DESC LIMIT 1) as latest_addendum_nilai
                FROM pekerjaan p
                JOIN entitas e ON p.id_entitas = e.id_entitas
                JOIN akun_belanja ab ON p.id_akun_belanja = ab.id_akun_belanja
                JOIN penyedia pen ON p.id_penyedia = pen.id_penyedia
                WHERE p.id_pekerjaan = ?";
        $data = getRow($sql, [$id]);
    } else {
        $sql = "SELECT p.*, e.nama_entitas, ab.nama_akun as nama_akun_belanja, 
                pen.nama_penyedia,
                (SELECT MAX(tanggal_selesai_baru) FROM addendum WHERE id_pekerjaan = p.id_pekerjaan) as latest_addendum_end,
                (SELECT tanggal_serah_terima FROM serah_terima WHERE id_pekerjaan = p.id_pekerjaan AND jenis_serah_terima = 'PHO' AND status_serah_terima = 'completed' ORDER BY tanggal_serah_terima DESC LIMIT 1) as pho_date
                FROM pekerjaan p
                JOIN entitas e ON p.id_entitas = e.id_entitas
                JOIN akun_belanja ab ON p.id_akun_belanja = ab.id_akun_belanja
                JOIN penyedia pen ON p.id_penyedia = pen.id_penyedia
                WHERE 1=1";
        $params = [];
        
        if ($id_entitas) {
            $sql .= " AND p.id_entitas = ?";
            $params[] = $id_entitas;
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        $data = getRows($sql, $params);
    }
    
    jsonResponse(['success' => true, 'data' => $data]);
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
