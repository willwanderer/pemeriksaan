<?php
/**
 * Proses Serah Terima - Simpan/Edit/Hapus Serah Terima (PHO/FHO)
 */

require_once __DIR__ . '/../includes/db_connect.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? 'create';
    
    if ($action === 'create') {
        $data = [
            'id_pekerjaan' => $_POST['id_pekerjaan'],
            'nomor_berita_acara' => $_POST['nomor_berita_acara'] ?? null,
            'tanggal_serah_terima' => $_POST['tanggal_serah_terima'] ?? null,
            'jenis_serah_terima' => $_POST['jenis_serah_terima'] ?? 'PHO',
            'status_serah_terima' => $_POST['status_serah_terima'] ?? 'pending',
            'masa_pemeliharaan' => intval($_POST['masa_pemeliharaan'] ?? 0),
            'tanggal_akhir_pemeliharaan' => $_POST['tanggal_akhir_pemeliharaan'] ?? null,
            'nilai_garansi_bank' => floatval(str_replace(['.', ','], '', $_POST['nilai_garansi_bank'] ?? 0)),
            'nilai_garansi_jaminan' => floatval(str_replace(['.', ','], '', $_POST['nilai_garansi_jaminan'] ?? 0)),
            'catatan' => $_POST['catatan'] ?? $_POST['keterangan'] ?? null
        ];
        
        $id = insertRecord('serah_terima', $data);
        
        if ($id) {
            jsonResponse(['success' => true, 'message' => 'Serah terima berhasil ditambahkan', 'id' => $id]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menyimpan serah terima'], 500);
        }
        
    } elseif ($action === 'update') {
        $id = $_POST['id_serah_terima'];
        
        $data = [
            'nomor_berita_acara' => $_POST['nomor_berita_acara'] ?? null,
            'tanggal_serah_terima' => $_POST['tanggal_serah_terima'] ?? null,
            'jenis_serah_terima' => $_POST['jenis_serah_terima'] ?? 'PHO',
            'status_serah_terima' => $_POST['status_serah_terima'] ?? 'pending',
            'masa_pemeliharaan' => intval($_POST['masa_pemeliharaan'] ?? 0),
            'tanggal_akhir_pemeliharaan' => $_POST['tanggal_akhir_pemeliharaan'] ?? null,
            'nilai_garansi_bank' => floatval(str_replace(['.', ','], '', $_POST['nilai_garansi_bank'] ?? 0)),
            'nilai_garansi_jaminan' => floatval(str_replace(['.', ','], '', $_POST['nilai_garansi_jaminan'] ?? 0)),
            'catatan' => $_POST['catatan'] ?? $_POST['keterangan'] ?? null
        ];
        
        $result = updateRecord('serah_terima', $data, 'id_serah_terima = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Serah terima berhasil diperbarui']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui serah terima'], 500);
        }
        
    } elseif ($action === 'delete') {
        $id = $_POST['id_serah_terima'];
        $result = deleteRecord('serah_terima', 'id_serah_terima = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Serah terima berhasil dihapus']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menghapus serah terima'], 500);
        }
    }
}

// GET
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
    
    if ($id) {
        $data = getRow("SELECT * FROM serah_terima WHERE id_serah_terima = ?", [$id]);
    } else {
        $sql = "SELECT * FROM serah_terima WHERE 1=1";
        $params = [];
        
        if ($id_pekerjaan) {
            $sql .= " AND id_pekerjaan = ?";
            $params[] = $id_pekerjaan;
        }
        
        $sql .= " ORDER BY tanggal_serah_terima DESC";
        $data = getRows($sql, $params);
    }
    
    jsonResponse(['success' => true, 'data' => $data]);
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
