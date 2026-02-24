<?php
/**
 * Proses Addendum - Simpan/Edit/Hapus Addendum Kontrak
 */

require_once __DIR__ . '/../includes/db_connect.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? 'create';
    
    if ($action === 'create') {
        $data = [
            'id_pekerjaan' => $_POST['id_pekerjaan'],
            'nomor_addendum' => $_POST['nomor_addendum'],
            'tanggal_addendum' => $_POST['tanggal_addendum'] ?? null,
            'uraian_perubahan' => $_POST['uraian_perubahan'] ?? null,
            'nilai_addendum' => floatval(str_replace(['.', ','], '', $_POST['nilai_addendum'] ?? 0)),
            'tanggal_mulai_baru' => $_POST['tanggal_mulai_baru'] ?? null,
            'tanggal_selesai_baru' => $_POST['tanggal_selesai_baru'] ?? null,
            'catatan' => $_POST['catatan'] ?? null
        ];
        
        $id = insertRecord('addendum', $data);
        
        if ($id) {
            jsonResponse(['success' => true, 'message' => 'Addendum berhasil ditambahkan', 'id' => $id]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menyimpan addendum'], 500);
        }
        
    } elseif ($action === 'update') {
        $id = $_POST['id_addendum'];
        
        $data = [
            'nomor_addendum' => $_POST['nomor_addendum'],
            'tanggal_addendum' => $_POST['tanggal_addendum'] ?? null,
            'uraian_perubahan' => $_POST['uraian_perubahan'] ?? null,
            'nilai_addendum' => floatval(str_replace(['.', ','], '', $_POST['nilai_addendum'] ?? 0)),
            'tanggal_mulai_baru' => $_POST['tanggal_mulai_baru'] ?? null,
            'tanggal_selesai_baru' => $_POST['tanggal_selesai_baru'] ?? null,
            'catatan' => $_POST['catatan'] ?? null
        ];
        
        $result = updateRecord('addendum', $data, 'id_addendum = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Addendum berhasil diperbarui']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui addendum'], 500);
        }
        
    } elseif ($action === 'delete') {
        $id = $_POST['id_addendum'];
        $result = deleteRecord('addendum', 'id_addendum = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Addendum berhasil dihapus']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menghapus addendum'], 500);
        }
    }
}

// GET
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
    
    if ($id) {
        $data = getRow("SELECT * FROM addendum WHERE id_addendum = ?", [$id]);
    } else {
        $sql = "SELECT * FROM addendum WHERE 1=1";
        $params = [];
        
        if ($id_pekerjaan) {
            $sql .= " AND id_pekerjaan = ?";
            $params[] = $id_pekerjaan;
        }
        
        $sql .= " ORDER BY tanggal_addendum DESC, id_addendum DESC";
        $data = getRows($sql, $params);
    }
    
    jsonResponse(['success' => true, 'data' => $data]);
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
