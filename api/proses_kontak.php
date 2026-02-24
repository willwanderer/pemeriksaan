<?php
/**
 * Proses Kontak - Simpan/Edit/Hapus Kontak
 */

require_once __DIR__ . '/../includes/db_connect.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? 'create';
    
    if ($action === 'create') {
        $data = [
            'id_entitas' => $_POST['id_entitas'],
            'nama' => $_POST['nama'],
            'posisi' => $_POST['posisi'] ?? null,
            'telepon' => $_POST['telepon'] ?? null,
            'email' => $_POST['email'] ?? null,
            'whatsapp' => $_POST['whatsapp'] ?? null,
            'catatan' => $_POST['catatan'] ?? null
        ];
        
        $id = insertRecord('kontak', $data);
        
        if ($id) {
            jsonResponse(['success' => true, 'message' => 'Kontak berhasil ditambahkan', 'id' => $id]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menyimpan kontak'], 500);
        }
        
    } elseif ($action === 'update') {
        $id = $_POST['id_kontak'];
        
        $data = [
            'nama' => $_POST['nama'],
            'posisi' => $_POST['posisi'] ?? null,
            'telepon' => $_POST['telepon'] ?? null,
            'email' => $_POST['email'] ?? null,
            'whatsapp' => $_POST['whatsapp'] ?? null,
            'catatan' => $_POST['catatan'] ?? null
        ];
        
        $result = updateRecord('kontak', $data, 'id_kontak = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Kontak berhasil diperbarui']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui kontak'], 500);
        }
        
    } elseif ($action === 'delete') {
        $id = $_POST['id_kontak'];
        $result = deleteRecord('kontak', 'id_kontak = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Kontak berhasil dihapus']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menghapus kontak'], 500);
        }
    }
}

// GET
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    $id_entitas = $_GET['id_entitas'] ?? null;
    
    if ($id) {
        $data = getRow("SELECT * FROM kontak WHERE id_kontak = ?", [$id]);
    } else {
        $sql = "SELECT k.*, e.nama_entitas FROM kontak k 
                JOIN entitas e ON k.id_entitas = e.id_entitas 
                WHERE 1=1";
        $params = [];
        
        if ($id_entitas) {
            $sql .= " AND k.id_entitas = ?";
            $params[] = $id_entitas;
        }
        
        $sql .= " ORDER BY k.nama";
        $data = getRows($sql, $params);
    }
    
    jsonResponse(['success' => true, 'data' => $data]);
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
