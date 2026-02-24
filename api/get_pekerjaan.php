<?php
/**
 * API Get Pekerjaan
 * Get list of pekerjaan based on BM type
 */

require_once __DIR__ . '/../includes/db_connect.php';

header('Content-Type: application/json');

$type = $_GET['type'] ?? 'all';
$id_entitas = $_GET['id_entitas'] ?? null;
$id = $_GET['id'] ?? null;

// If single ID provided, return that pekerjaan
if ($id) {
    $sql = "SELECT p.*, e.nama_entitas, e.folder_name as entity_folder, ab.nama_akun as nama_akun_belanja, ab.inisial as inisial_akun_belanja, 
            pen.nama_penyedia, pen.inisial as inisial_penyedia
            FROM pekerjaan p
            JOIN entitas e ON p.id_entitas = e.id_entitas
            JOIN akun_belanja ab ON p.id_akun_belanja = ab.id_akun_belanja
            JOIN penyedia pen ON p.id_penyedia = pen.id_penyedia
            WHERE p.id_pekerjaan = ?";
    
    $data = getRow($sql, [$id]);
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Build query based on type
$sql = "SELECT p.*, e.nama_entitas, ab.nama_akun as nama_akun_belanja, ab.inisial as inisial_akun_belanja, 
        pen.nama_penyedia, pen.inisial as inisial_penyedia
        FROM pekerjaan p
        JOIN entitas e ON p.id_entitas = e.id_entitas
        JOIN akun_belanja ab ON p.id_akun_belanja = ab.id_akun_belanja
        JOIN penyedia pen ON p.id_penyedia = pen.id_penyedia
        WHERE 1=1";

$params = [];

if ($type !== 'all') {
    $typeMapping = [
        'jalan' => 'JIJ',
        'gedung' => 'BG',
        'peralatan' => 'PM',
        'tanah' => 'TL',
        'aset_lain' => 'ATL'
    ];
    
    $inisial = $typeMapping[$type] ?? 'JIJ';
    $sql .= " AND ab.inisial = ?";
    $params[] = $inisial;
}

if ($id_entitas) {
    $sql .= " AND p.id_entitas = ?";
    $params[] = $id_entitas;
}

$sql .= " ORDER BY p.created_at DESC";

$data = getRows($sql, $params);

echo json_encode([
    'success' => true,
    'data' => $data
], JSON_UNESCAPED_UNICODE);
