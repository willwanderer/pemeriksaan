<?php
/**
 * Proses Entitas - Simpan/Edit/Hapus Entitas
 */

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/folder_helper.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? 'create';
    
    if ($action === 'create') {
        // Handle both naming conventions (namaentitas and nama_entitas)
        $namaEntitas = $_POST['nama_entitas'] ?? $_POST['namaentitas'] ?? '';
        $level = $_POST['level'] ?? '';
        $daerah = $_POST['daerah'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $telepon = $_POST['telepon'] ?? '';
        
        if (empty($namaEntitas)) {
            jsonResponse(['success' => false, 'message' => 'Nama entitas wajib diisi'], 400);
        }
        
        // Generate folder name
        $folderName = createEntityFolder($namaEntitas);
        
        // Handle logo upload
        $logoPath = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            // Ensure base folder exists
            if (!is_dir(BASE_DOCUMENT_PATH)) {
                mkdir(BASE_DOCUMENT_PATH, 0755, true);
            }
            
            // Ensure entity folder exists
            if (!is_dir(BASE_DOCUMENT_PATH . $folderName)) {
                mkdir(BASE_DOCUMENT_PATH . $folderName, 0755, true);
            }
            
            $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $fullLogoPath = BASE_DOCUMENT_PATH . $folderName . '/logo.' . $ext;
            $logoRelativePath = RELATIVE_DOCUMENT_PATH . $folderName . '/logo.' . $ext;
            
            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $fullLogoPath)) {
                jsonResponse(['success' => false, 'message' => 'Gagal menyimpan file logo'], 500);
                return;
            }
            
            // Save RELATIVE path to database (portable)
            $logoPath = $logoRelativePath;
        }
        
        $data = [
            'nama_entitas' => $namaEntitas,
            'level' => $level,
            'daerah' => $daerah,
            'alamat' => $alamat,
            'telepon' => $telepon,
            'folder_name' => $folderName
        ];
        
        if ($logoPath) {
            $data['logo'] = $logoPath;
        }
        
        $id = insertRecord('entitas', $data);
        
        if ($id) {
            jsonResponse([
                'success' => true,
                'message' => 'Entitas berhasil ditambahkan',
                'folder' => $folderName,
                'id' => $id
            ]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menyimpan entitas'], 500);
        }
        
    } elseif ($action === 'update') {
        $id = $_POST['id_entitas'] ?? $_POST['idEntitas'] ?? 0;
        
        if (!$id) {
            jsonResponse(['success' => false, 'message' => 'ID entitas wajib diisi'], 400);
        }
        
        // Handle both naming conventions
        $namaEntitas = $_POST['nama_entitas'] ?? $_POST['namaentitas'] ?? '';
        
        $data = [
            'nama_entitas' => $namaEntitas,
            'level' => $_POST['level'] ?? '',
            'daerah' => $_POST['daerah'] ?? '',
            'alamat' => $_POST['alamat'] ?? '',
            'telepon' => $_POST['telepon'] ?? ''
        ];
        
        // Handle logo upload
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            // Get existing entity to find folder name
            $entitas = getRow("SELECT folder_name, logo FROM entitas WHERE id_entitas = ?", [$id]);
            if ($entitas && !empty($entitas['folder_name'])) {
                $folderName = $entitas['folder_name'];
                $fullPath = BASE_DOCUMENT_PATH . $folderName;
                
                // Create folder if it doesn't exist
                if (!is_dir($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                $fullLogoPath = $fullPath . '/logo.' . $ext;
                $logoRelativePath = RELATIVE_DOCUMENT_PATH . $folderName . '/logo.' . $ext;
                
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $fullLogoPath)) {
                    // Save RELATIVE path to database (portable)
                    $data['logo'] = $logoRelativePath;
                } else {
                    jsonResponse(['success' => false, 'message' => 'Gagal menyimpan file logo. Pastikan folder dokumen ada.'], 500);
                    return;
                }
            } else {
                jsonResponse(['success' => false, 'message' => 'Folder entitas tidak ditemukan. Silakan hubungi administrator.'], 400);
                return;
            }
        }
        
        $result = updateRecord('entitas', $data, 'id_entitas = ?', [$id]);
        
        if ($result) {
            jsonResponse(['success' => true, 'message' => 'Entitas berhasil diperbarui']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal memperbarui entitas'], 500);
        }
        
    } elseif ($action === 'delete') {
        $id = $_POST['id_entitas'] ?? $_POST['idEntitas'] ?? 0;
        
        if (!$id) {
            jsonResponse(['success' => false, 'message' => 'ID entitas wajib diisi'], 400);
        }
        
        // Get folder name first
        $entitas = getRow("SELECT folder_name FROM entitas WHERE id_entitas = ?", [$id]);
        
        // Delete from database
        $result = deleteRecord('entitas', 'id_entitas = ?', [$id]);
        
        if ($result && $entitas) {
            // Try to delete folder (will fail if not empty, that's ok)
            deleteFolder(BASE_DOCUMENT_PATH . $entitas['folder_name']);
            
            jsonResponse(['success' => true, 'message' => 'Entitas berhasil dihapus']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Gagal menghapus entitas'], 500);
        }
    }
}

// GET - Fetch entities
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    
    if ($id) {
        $data = getRow("SELECT * FROM entitas WHERE id_entitas = ?", [$id]);
    } else {
        $data = getRows("SELECT * FROM entitas ORDER BY nama_entitas");
    }
    
    jsonResponse(['success' => true, 'data' => $data]);
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
