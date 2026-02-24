<?php
/**
 * Get Dokumen - Load dokumen data for a pekerjaan
 */

require_once __DIR__ . '/../includes/db_connect.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
    $jenis = $_GET['jenis'] ?? null;
    
    if (!$id_pekerjaan) {
        echo json_encode([
            'success' => false,
            'message' => 'ID Pekerjaan diperlukan'
        ]);
        exit;
    }
    
    try {
        if ($jenis) {
            // Filter by jenis_dokumen
            $dokumen = getRows(
                "SELECT * FROM dokumen WHERE id_pekerjaan = ? AND jenis_dokumen = ? ORDER BY created_at",
                [$id_pekerjaan, $jenis]
            );
        } else {
            // Get all dokumen
            $dokumen = getRows(
                "SELECT * FROM dokumen WHERE id_pekerjaan = ? ORDER BY doc_id",
                [$id_pekerjaan]
            );
        }
        
        echo json_encode([
            'success' => true,
            'data' => $dokumen
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Method tidak valid'
]);
