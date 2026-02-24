<?php
/**
 * Proses Item Pekerjaan - Simpan/Edit/Hapus Item Pekerjaan (RAB)
 */

require_once __DIR__ . '/../includes/db_connect.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? 'create';
    
    if ($action === 'create') {
        $volume = floatval(str_replace(',', '.', $_POST['volume']));
        $harga_satuan = floatval(str_replace(['.', ','], '', $_POST['harga_satuan']));
        $jumlah_harga = $volume * $harga_satuan;
        
        $data = [
            'id_pekerjaan' => $_POST['id_pekerjaan'],
            'kode_item' => $_POST['kode_item'] ?? null,
            'nama_item' => $_POST['nama_item'],
            'deskripsi' => $_POST['deskripsi'] ?? null,
            'satuan' => $_POST['satuan'],
            'volume' => $volume,
            'harga_satuan' => $harga_satuan,
            'jumlah_harga' => $jumlah_harga,
            'kategori_bm' => $_POST['kategori_bm'] ?? 'JIJ',
            'catatan' => $_POST['catatan'] ?? null
        ];
        
        $id = insertRecord('item_pekerjaan', $data);
        
        if ($id) {
            jsonResponse(['success' => true, 'message' => 'Item pekerjaan berhasil ditambahkan', 'id' => $id]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menyimpan item'], 500);
        }
        
    } elseif ($action === 'update') {
        $id = $_POST['id_item_pekerjaan'];
        
        $volume = floatval(str_replace(',', '.', $_POST['volume']));
        $harga_satuan = floatval(str_replace(['.', ','], '', $_POST['harga_satuan']));
        $jumlah_harga = $volume * $harga_satuan;
        
        $data = [
            'kode_item' => $_POST['kode_item'] ?? null,
            'nama_item' => $_POST['nama_item'],
            'deskripsi' => $_POST['deskripsi'] ?? null,
            'satuan' => $_POST['satuan'],
            'volume' => $volume,
            'harga_satuan' => $harga_satuan,
            'jumlah_harga' => $jumlah_harga,
            'kategori_bm' => $_POST['kategori_bm'] ?? 'JIJ',
            'catatan' => $_POST['catatan'] ?? null
        ];
        
        $result = updateRecord('item_pekerjaan', $data, 'id_item_pekerjaan = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Item pekerjaan berhasil diperbarui']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui item'], 500);
        }
        
    } elseif ($action === 'delete') {
        $id = $_POST['id_item_pekerjaan'];
        $result = deleteRecord('item_pekerjaan', 'id_item_pekerjaan = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Item pekerjaan berhasil dihapus']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menghapus item'], 500);
        }
    }
}

// GET
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
    
    if ($id) {
        $data = getRow("SELECT * FROM item_pekerjaan WHERE id_item_pekerjaan = ?", [$id]);
    } else {
        $sql = "SELECT * FROM item_pekerjaan WHERE 1=1";
        $params = [];
        
        if ($id_pekerjaan) {
            $sql .= " AND id_pekerjaan = ?";
            $params[] = $id_pekerjaan;
        }
        
        $sql .= " ORDER BY kode_item, id_item_pekerjaan";
        $data = getRows($sql, $params);
    }
    
    jsonResponse(['success' => true, 'data' => $data]);
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
