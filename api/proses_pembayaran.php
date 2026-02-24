<?php
/**
 * Proses Pembayaran - Simpan/Edit/Hapus Pembayaran Termin
 */

require_once __DIR__ . '/../includes/db_connect.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? 'create';
    
    if ($action === 'create') {
        $data = [
            'id_pekerjaan' => $_POST['id_pekerjaan'],
            'nomor_pembayaran' => $_POST['nomor_pembayaran'] ?? null,
            'termin' => intval($_POST['termin'] ?? 1),
            'tanggal_pembayaran' => $_POST['tanggal_pembayaran'] ?? null,
            'jumlah_pembayaran' => floatval(str_replace(['.', ','], '', $_POST['jumlah_pembayaran'] ?? 0)),
            'persentase_pekerjaan' => floatval(str_replace([','], '.', $_POST['persentase_pekerjaan'] ?? 0)),
            'status_pembayaran' => $_POST['status_pembayaran'] ?? 'pending',
            'keterangan' => $_POST['keterangan'] ?? null,
            'catatan' => $_POST['catatan'] ?? null
        ];
        
        $id = insertRecord('pembayaran', $data);
        
        if ($id) {
            jsonResponse(['success' => true, 'message' => 'Pembayaran berhasil ditambahkan', 'id' => $id]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menyimpan pembayaran'], 500);
        }
        
    } elseif ($action === 'update') {
        $id = $_POST['id_pembayaran'];
        
        $data = [
            'nomor_pembayaran' => $_POST['nomor_pembayaran'] ?? null,
            'termin' => intval($_POST['termin'] ?? 1),
            'tanggal_pembayaran' => $_POST['tanggal_pembayaran'] ?? null,
            'jumlah_pembayaran' => floatval(str_replace(['.', ','], '', $_POST['jumlah_pembayaran'] ?? 0)),
            'persentase_pekerjaan' => floatval(str_replace([','], '.', $_POST['persentase_pekerjaan'] ?? 0)),
            'status_pembayaran' => $_POST['status_pembayaran'] ?? 'pending',
            'keterangan' => $_POST['keterangan'] ?? null,
            'catatan' => $_POST['catatan'] ?? null
        ];
        
        $result = updateRecord('pembayaran', $data, 'id_pembayaran = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Pembayaran berhasil diperbarui']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui pembayaran'], 500);
        }
        
    } elseif ($action === 'delete') {
        $id = $_POST['id_pembayaran'];
        $result = deleteRecord('pembayaran', 'id_pembayaran = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Pembayaran berhasil dihapus']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menghapus pembayaran'], 500);
        }
    }
}

// GET
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
    
    if ($id) {
        $data = getRow("SELECT * FROM pembayaran WHERE id_pembayaran = ?", [$id]);
    } else {
        $sql = "SELECT * FROM pembayaran WHERE 1=1";
        $params = [];
        
        if ($id_pekerjaan) {
            $sql .= " AND id_pekerjaan = ?";
            $params[] = $id_pekerjaan;
        }
        
        $sql .= " ORDER BY termin, tanggal_pembayaran";
        $data = getRows($sql, $params);
    }
    
    jsonResponse(['success' => true, 'data' => $data]);
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
