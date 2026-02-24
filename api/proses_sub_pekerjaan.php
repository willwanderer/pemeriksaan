<?php
/**
 * API for Sub Pekerjaan CRUD Operations
 * Handles sub-pekerjaan (sections/segments) for physical inspection
 */

require_once __DIR__ . '/../includes/db_connect.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        handleGet();
        break;
    case 'POST':
        handlePost();
        break;
    case 'PUT':
        handlePut();
        break;
    case 'DELETE':
        handleDelete();
        break;
    default:
        jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
}

/**
 * Handle GET requests - Fetch sub_pekerjaan data
 */
function handleGet() {
    $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
    $id = $_GET['id'] ?? null;
    
    if ($id) {
        // Get single sub_pekerjaan
        $sql = "SELECT * FROM sub_pekerjaan WHERE id_sub_pekerjaan = ?";
        $data = getRow($sql, [$id]);
        
        if ($data) {
            jsonResponse(['success' => true, 'data' => $data]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Sub pekerjaan not found'], 404);
        }
    } elseif ($id_pekerjaan) {
        // Get all sub_pekerjaan for a pekerjaan
        $sql = "SELECT * FROM sub_pekerjaan WHERE id_pekerjaan = ? ORDER BY created_at DESC";
        $data = getRows($sql, [$id_pekerjaan]);
        
        jsonResponse(['success' => true, 'data' => $data]);
    } else {
        jsonResponse(['success' => false, 'message' => 'id_pekerjaan is required'], 400);
    }
}

/**
 * Handle POST requests - Create new sub_pekerjaan
 */
function handlePost() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        $input = $_POST;
    }
    
    $id_pekerjaan = $input['id_pekerjaan'] ?? null;
    $nama_sub_pekerjaan = $input['nama_sub_pekerjaan'] ?? null;
    
    // For JIJ type, we don't require id_pekerjaan for testing, but it's actually required
    if (!$id_pekerjaan) {
        jsonResponse(['success' => false, 'message' => 'id_pekerjaan is required'], 400);
    }
    
    if (!$nama_sub_pekerjaan) {
        jsonResponse(['success' => false, 'message' => 'nama_sub_pekerjaan is required'], 400);
    }
    
    // Prepare data
    $data = [
        'id_pekerjaan' => $id_pekerjaan,
        'nama_sub_pekerjaan' => $nama_sub_pekerjaan,
        'catatan' => $input['catatan'] ?? null
    ];
    
    // Insert
    $id = insertRecord('sub_pekerjaan', $data);
    
    if ($id) {
        jsonResponse([
            'success' => true,
            'message' => 'Sub pekerjaan berhasil ditambahkan',
            'id' => $id
        ]);
    } else {
        jsonResponse(['success' => false, 'message' => 'Gagal menambahkan sub pekerjaan'], 500);
    }
}

/**
 * Handle PUT requests - Update sub_pekerjaan
 */
function handlePut() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        $input = $_POST;
    }
    
    $id = $input['id'] ?? null;
    
    if (!$id) {
        jsonResponse(['success' => false, 'message' => 'id is required'], 400);
    }
    
    // Remove id from data
    unset($input['id']);
    
    // Add updated timestamp
    $input['updated_at'] = date('Y-m-d H:i:s');
    
    // Update
    $result = updateRecord('sub_pekerjaan', $input, 'id_sub_pekerjaan = ?', [$id]);
    
    if ($result) {
        jsonResponse([
            'success' => true,
            'message' => 'Sub pekerjaan berhasil diperbarui'
        ]);
    } else {
        jsonResponse(['success' => false, 'message' => 'Gagal memperbarui sub pekerjaan'], 500);
    }
}

/**
 * Handle DELETE requests - Delete sub_pekerjaan
 */
function handleDelete() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        $input = $_POST;
    }
    
    $id = $input['id'] ?? null;
    
    if (!$id) {
        jsonResponse(['success' => false, 'message' => 'id is required'], 400);
    }
    
    // Delete
    $result = deleteRecord('sub_pekerjaan', 'id_sub_pekerjaan = ?', [$id]);
    
    if ($result) {
        jsonResponse([
            'success' => true,
            'message' => 'Sub pekerjaan berhasil dihapus'
        ]);
    } else {
        jsonResponse(['success' => false, 'message' => 'Gagal menghapus sub pekerjaan'], 500);
    }
}

/**
 * Send JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
