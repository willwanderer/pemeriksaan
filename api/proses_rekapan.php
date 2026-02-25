<?php
/**
 * API forapan Pemeriksaan CRUD Rek Operations
 * Handles all BM types: Jalan (JIJ), Gedung (BG), Peralatan (PM), Tanah (TL), Aset Lain (ATL)
 */

// Disable error display to prevent HTML output
error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/folder_helper.php';

/**
 * Send JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Get table name based on BM type
 */
function getTableName($type) {
    $tables = [
        'jalan' => 'rekapan_pemeriksaan_jalan',
        'gedung' => 'rekapan_pemeriksaan_gedung',
        'peralatan' => 'rekapan_pemeriksaan_peralatan',
        'tanah' => 'rekapan_pemeriksaan_tanah',
        'aset_lain' => 'rekapan_pemeriksaan_aset_lain',
        'atl' => 'rekapan_pemeriksaan_aset_lain'
    ];
    
    return $tables[$type] ?? 'rekapan_pemeriksaan_jalan';
}

/**
 * Get ID column name based on BM type
 */
function getIdColumn($type) {
    $columns = [
        'jalan' => 'id_rekapan_jalan',
        'gedung' => 'id_rekapan_gedung',
        'peralatan' => 'id_rekapan_peralatan',
        'tanah' => 'id_rekapan_tanah',
        'aset_lain' => 'id_rekapan_aset_lain',
        'atl' => 'id_rekapan_aset_lain'
    ];
    
    return $columns[$type] ?? 'id_rekapan_jalan';
}

// Initialize database connection
$conn = getDBConnection();

if (!$conn) {
    jsonResponse(['success' => false, 'message' => 'Database connection failed'], 500);
}

header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Check for special action
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        handleGet();
        break;
    case 'POST':
        if ($action === 'update_with_image') {
            handleUpdateWithImage();
        } elseif ($action === 'create_with_image') {
            handleCreateWithImage();
        } else {
            handlePost();
        }
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
 * Handle GET requests - Fetch data
 */
function handleGet() {
    global $conn;
    
    $type = $_GET['type'] ?? 'jalan';
    $id_pekerjaan = $_GET['id_pekerjaan'] ?? null;
    $id_sub_pekerjaan = $_GET['id_sub_pekerjaan'] ?? null;
    $id = $_GET['id'] ?? null;
    
    if (!$id_pekerjaan) {
        jsonResponse(['success' => false, 'message' => 'id_pekerjaan is required'], 400);
    }
    
    $table = getTableName($type);
    
    // Check if table exists
    $tableCheck = $conn->query("SHOW TABLES LIKE '$table'");
    if ($tableCheck->num_rows == 0) {
        jsonResponse(['success' => false, 'message' => 'Table not found: ' . $table], 404);
    }
    
    if ($id) {
        // Get single record
        $sql = "SELECT * FROM $table WHERE id_pekerjaan = ? AND " . getIdColumn($type) . " = ?";
        $data = getRow($sql, [$id_pekerjaan, $id]);
        
        if ($data) {
            jsonResponse(['success' => true, 'data' => $data]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Data not found'], 404);
        }
    } else {
        // Get all records for this job, optionally filtered by sub_pekerjaan
        if ($id_sub_pekerjaan) {
            $sql = "SELECT * FROM $table WHERE id_pekerjaan = ? AND id_sub_pekerjaan = ? ORDER BY created_at DESC";
            $data = getRows($sql, [$id_pekerjaan, $id_sub_pekerjaan]);
        } else {
            $sql = "SELECT * FROM $table WHERE id_pekerjaan = ? ORDER BY created_at DESC";
            $data = getRows($sql, [$id_pekerjaan]);
        }
        
        jsonResponse(['success' => true, 'data' => $data]);
    }
}

/**
 * Handle POST requests - Create new data
 */
function handlePost() {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            $input = $_POST;
        }
        
        if (empty($input)) {
            jsonResponse(['success' => false, 'message' => 'No input data provided'], 400);
        }
        
        $type = $input['type'] ?? 'jalan';
        $id_pekerjaan = $input['id_pekerjaan'] ?? null;
        $id_sub_pekerjaan = $input['id_sub_pekerjaan'] ?? null;
        
        if (!$id_pekerjaan) {
            jsonResponse(['success' => false, 'message' => 'id_pekerjaan is required'], 400);
        }
        
        // Remove type from data
        unset($input['type']);
        
        // Handle id_sub_pekerjaan - set to null if empty
        if (empty($id_sub_pekerjaan)) {
            $input['id_sub_pekerjaan'] = null;
        } else {
            $input['id_sub_pekerjaan'] = $id_sub_pekerjaan;
        }
        
        // Add timestamps
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');
        
        $table = getTableName($type);
        $idColumn = getIdColumn($type);
        
        // Insert data
        $id = insertRecord($table, $input);
        
        if ($id) {
            // Log activity
            logActivity('create', "Created new $type inspection record ID: $id for job: $id_pekerjaan");
            
            jsonResponse([
                'success' => true, 
                'message' => 'Data berhasil disimpan',
                'id' => $id
            ]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menyimpan data ke tabel ' . $table], 500);
        }
    } catch (Exception $e) {
        jsonResponse(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}

/**
 * Handle PUT requests - Update data
 */
function handlePut() {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            $input = $_POST;
        }
        
        if (empty($input)) {
            jsonResponse(['success' => false, 'message' => 'No input data provided'], 400);
        }
        
        $type = $input['type'] ?? 'jalan';
        $id = $input['id'] ?? null;
        $id_pekerjaan = $input['id_pekerjaan'] ?? null;
        
        if (!$id || !$id_pekerjaan) {
            jsonResponse(['success' => false, 'message' => 'id and id_pekerjaan are required'], 400);
        }
        
        // Remove type and id from data
        unset($input['type'], $input['id']);
        
        // Add updated timestamp
        $input['updated_at'] = date('Y-m-d H:i:s');
        
        $table = getTableName($type);
        $idColumn = getIdColumn($type);
        
        // Update data
        $result = updateRecord($table, $input, "$idColumn = ?", [$id]);
        
        if ($result) {
            logActivity('update', "Updated $type inspection record ID: $id");
            
            jsonResponse([
                'success' => true, 
                'message' => 'Data berhasil diperbarui'
            ]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui data'], 500);
        }
    } catch (Exception $e) {
        jsonResponse(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}

/**
 * Handle POST with image upload - Update data with images
 */
function handleUpdateWithImage() {
    global $conn;
    
    try {
        $type = $_POST['type'] ?? 'jalan';
        $id = $_POST['id'] ?? null;
        $id_pekerjaan = $_POST['id_pekerjaan'] ?? null;
        
        if (!$id || !$id_pekerjaan) {
            jsonResponse(['success' => false, 'message' => 'id and id_pekerjaan are required'], 400);
        }
        
        $table = getTableName($type);
        $idColumn = getIdColumn($type);
        
        // Get existing record to check for old photos
        $stmt = $conn->prepare("SELECT * FROM $table WHERE $idColumn = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();
        $stmt->close();
        
        if (!$existingData) {
            jsonResponse(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        
        // Prepare data array
        $data = [];
        
        // Map form fields to database columns
        $fieldMappings = [
            'sta' => 'sta',
            'STA_type' => 'STA_type',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'jenis' => 'jenis_jalan',
            'tebal1' => 'tebal_1',
            'tebal2' => 'tebal_2',
            'tebal3' => 'tebal_3',
            'tebal4' => 'tebal_4',
            'tebal_existing' => 'tebal_existing',
            'tebal_rencana' => 'tebal_rencana',
            'tebal_actual' => 'tebal_actual',
            'lebarjalan' => 'lebar_jalan',
            'panjang' => 'panjang',
            'kipas' => 'kipas',
            'sloop' => 'sloop',
            'lebarkiri' => 'lebar_bahu_kiri',
            'tekalkiri' => 'tebal_bahu_kiri',
            'lebarkanan' => 'lebar_bahu_kanan',
            'tekalkanan' => 'tebal_bahu_kanan',
            'statusKesesuaian' => 'status_kesesuaian',
            'catatan' => 'catatan'
        ];
        
        foreach ($fieldMappings as $formField => $dbField) {
            if (isset($_POST[$formField]) && $_POST[$formField] !== '') {
                $data[$dbField] = $_POST[$formField];
            }
        }
        
        // Handle image uploads
        $uploadDir = __DIR__ . '/../dokumen_pemeriksaan/';
        
        // Create directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $photoFields = [
            'foto_sta' => 'foto_sta',
            'foto_bahu' => 'foto_bahu',
            'foto_bendauji' => 'foto_bendauji',
            'foto_lain' => 'foto_lain'
        ];
        
        foreach ($photoFields as $formField => $dbField) {
            if (isset($_FILES[$formField]) && $_FILES[$formField]['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES[$formField];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = $type . '_' . $id . '_' . $formField . '_' . time() . '.' . $ext;
                $targetPath = $uploadDir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    // Delete old photo if exists
                    if (!empty($existingData[$dbField])) {
                        $oldFile = $uploadDir . basename($existingData[$dbField]);
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    $data[$dbField] = 'dokumen_pemeriksaan/' . $filename;
                }
            } else {
                // Keep existing photo path if no new file uploaded
                if (!empty($_POST[$formField]) && $_POST[$formField] !== '') {
                    $data[$dbField] = $_POST[$formField];
                } elseif (!empty($existingData[$dbField])) {
                    $data[$dbField] = $existingData[$dbField];
                }
            }
        }
        
        // Add updated timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        // Update data
        $result = updateRecord($table, $data, "$idColumn = ?", [$id]);
        
        if ($result) {
            logActivity('update', "Updated $type inspection record with images ID: $id");
            
            jsonResponse([
                'success' => true, 
                'message' => 'Data berhasil diperbarui'
            ]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui data'], 500);
        }
    } catch (Exception $e) {
        jsonResponse(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}

/**
 * Handle POST with image upload - Create new data with images
 */
function handleCreateWithImage() {
    global $conn;
    
    try {
        $type = $_POST['type'] ?? 'jalan';
        $id_pekerjaan = $_POST['id_pekerjaan'] ?? null;
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'] ?? null;
        
        if (!$id_pekerjaan) {
            jsonResponse(['success' => false, 'message' => 'id_pekerjaan is required'], 400);
        }
        
        $table = getTableName($type);
        $idColumn = getIdColumn($type);
        
        // Prepare data array
        $data = [];
        
        // Add id_pekerjaan to data
        $data['id_pekerjaan'] = $id_pekerjaan;
        
        // Map form fields to database columns
        $fieldMappings = [
            'sta' => 'sta',
            'STA_type' => 'STA_type',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'jenis' => 'jenis_jalan',
            'tebal1' => 'tebal_1',
            'tebal2' => 'tebal_2',
            'tebal3' => 'tebal_3',
            'tebal4' => 'tebal_4',
            'tebal_existing' => 'tebal_existing',
            'tebal_rencana' => 'tebal_rencana',
            'tebal_actual' => 'tebal_actual',
            'lebarjalan' => 'lebar_jalan',
            'panjang' => 'panjang',
            'kipas' => 'kipas',
            'sloop' => 'sloop',
            'lebarkiri' => 'lebar_bahu_kiri',
            'tekalkiri' => 'tebal_bahu_kiri',
            'lebarkanan' => 'lebar_bahu_kanan',
            'tekalkanan' => 'tebal_bahu_kanan',
            'statusKesesuaian' => 'status_kesesuaian',
            'catatan' => 'catatan'
        ];
        
        foreach ($fieldMappings as $formField => $dbField) {
            if (isset($_POST[$formField]) && $_POST[$formField] !== '') {
                $value = $_POST[$formField];
                
                // Validate latitude - must be between -90 and 90
                if ($dbField === 'latitude') {
                    $val = floatval($value);
                    if ($val < -90 || $val > 90) {
                        continue; // Skip invalid latitude
                    }
                }
                
                // Validate longitude - must be between -180 and 180
                if ($dbField === 'longitude') {
                    $val = floatval($value);
                    if ($val < -180 || $val > 180) {
                        continue; // Skip invalid longitude
                    }
                }
                
                // Validate other numeric fields - skip invalid values
                if (in_array($dbField, ['tebal_1', 'tebal_2', 'tebal_3', 'tebal_4', 'lebar_jalan', 'lebar_bahu_kiri', 'lebar_bahu_kanan', 'tebal_bahu_kiri', 'tebal_bahu_kanan'])) {
                    if (!is_numeric($value)) {
                        continue; // Skip invalid numeric values
                    }
                }
                
                $data[$dbField] = $value;
            }
        }
        
        // Set id_sub_pekerjaan
        if (!empty($id_sub_pekerjaan)) {
            $data['id_sub_pekerjaan'] = $id_sub_pekerjaan;
        }
        
        // Server-side auto-validation: Set status_kesesuaian based on road type and average thickness
        $jenis = $_POST['jenis'] ?? '';
        $tebal1 = isset($_POST['tebal1']) ? floatval($_POST['tebal1']) : 0;
        $tebal2 = isset($_POST['tebal2']) ? floatval($_POST['tebal2']) : 0;
        $tebal3 = isset($_POST['tebal3']) ? floatval($_POST['tebal3']) : 0;
        $tebal4 = isset($_POST['tebal4']) ? floatval($_POST['tebal4']) : 0;
        
        // Calculate average thickness from non-zero values
        $thicknessValues = array_filter([$tebal1, $tebal2, $tebal3, $tebal4], function($v) { return $v > 0; });
        $avgThickness = count($thicknessValues) > 0 ? array_sum($thicknessValues) / count($thicknessValues) : 0;
        
        // Auto-set status_kesesuaian based on road type and average thickness
        if ($jenis === 'AC-WC' || $jenis === 'AC-BC') {
            $statusKesesuaian = '';
            
            if ($jenis === 'AC-WC') {
                // AC-WC: if avg thickness > 3.9 cm → "sesuai", if ≤ 3.9 cm → "tidak_sesuai"
                $statusKesesuaian = ($avgThickness > 3.9) ? 'sesuai' : 'tidak_sesuai';
            } elseif ($jenis === 'AC-BC') {
                // AC-BC: if avg thickness > 5.9 cm → "sesuai", if ≤ 5.9 cm → "tidak_sesuai"
                $statusKesesuaian = ($avgThickness > 5.9) ? 'sesuai' : 'tidak_sesuai';
            }
            
            // Only override if statusKesesuaian is not manually set by user
            if (!isset($_POST['statusKesesuaian']) || $_POST['statusKesesuaian'] === '') {
                $data['status_kesesuaian'] = $statusKesesuaian;
            }
            
            error_log("Server-side validation: Jenis=$jenis, AvgThickness=$avgThickness, Status=$statusKesesuaian");
        }
        
        // Handle image uploads
        $uploadDir = __DIR__ . '/../dokumen_pemeriksaan/';
        
        // Create directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $photoFields = [
            'fotosta' => 'foto_sta',
            'fotobahu' => 'foto_bahu',
            'fotobendauji' => 'foto_bendauji',
            'fotolain' => 'foto_lain'
        ];
        
        foreach ($photoFields as $formField => $dbField) {
            if (isset($_FILES[$formField]) && $_FILES[$formField]['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES[$formField];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = $type . '_new_' . $formField . '_' . time() . '.' . $ext;
                $targetPath = $uploadDir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $data[$dbField] = 'dokumen_pemeriksaan/' . $filename;
                }
            }
        }
        
        // Add timestamps
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        // Insert data
        $id = insertRecord($table, $data);
        
        if ($id) {
            // If photos were uploaded with temporary names, rename them with correct ID
            foreach ($photoFields as $formField => $dbField) {
                if (isset($_FILES[$formField]) && $_FILES[$formField]['error'] === UPLOAD_ERR_OK) {
                    $oldPath = $uploadDir . $type . '_new_' . $formField . '_' . time() . '.' . pathinfo($_FILES[$formField]['name'], PATHINFO_EXTENSION);
                    $newFilename = $type . '_' . $id . '_' . $formField . '_' . time() . '.' . pathinfo($_FILES[$formField]['name'], PATHINFO_EXTENSION);
                    $newPath = $uploadDir . $newFilename;
                    
                    if (file_exists($oldPath) && isset($data[$dbField])) {
                        rename($oldPath, $newPath);
                        // Update the record with the new filename
                        $conn->query("UPDATE $table SET $dbField = 'dokumen_pemeriksaan/$newFilename' WHERE $idColumn = $id");
                    }
                }
            }
            
            logActivity('create', "Created new $type inspection record ID: $id for job: $id_pekerjaan");
            
            jsonResponse([
                'success' => true, 
                'message' => 'Data berhasil disimpan',
                'id' => $id
            ]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menyimpan data ke tabel ' . $table], 500);
        }
    } catch (Exception $e) {
        jsonResponse(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}

/**
 * Handle DELETE requests - Delete data
 */
function handleDelete() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        $input = $_POST;
    }
    
    $type = $input['type'] ?? 'jalan';
    $id = $input['id'] ?? null;
    $id_pekerjaan = $input['id_pekerjaan'] ?? null;
    
    if (!$id || !$id_pekerjaan) {
        jsonResponse(['success' => false, 'message' => 'id and id_pekerjaan are required'], 400);
    }
    
    $table = getTableName($type);
    $idColumn = getIdColumn($type);
    
    // Delete data
    $result = deleteRecord($table, "$idColumn = ?", [$id]);
    
    if ($result) {
        logActivity('delete', "Deleted $type inspection record ID: $id");
        
        jsonResponse([
            'success' => true, 
            'message' => 'Data berhasil dihapus'
        ]);
    } else {
        jsonResponse(['success' => false, 'message' => 'Gagal menghapus data'], 500);
    }
}
