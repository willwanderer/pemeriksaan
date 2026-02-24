<?php
/**
 * Folder Helper for Pemeriksaan Application
 * Automatically creates folder structure when:
 * - New entity is added
 * - New job/work is added
 */

// Disable error display to prevent HTML output in API
error_reporting(0);
ini_set('display_errors', 0);

// Base directory for all documents (absolute path for file operations)
define('BASE_DOCUMENT_PATH', __DIR__ . '/../dokumen_pemeriksaan/');

// Relative path for database storage (portable, works when project is moved)
define('RELATIVE_DOCUMENT_PATH', 'dokumen_pemeriksaan/');

/**
 * Get full path from relative path
 * 
 * @param string $relativePath - Relative path from database
 * @return string - Full absolute path
 */
function getFullPath($relativePath) {
    if (empty($relativePath)) return '';
    
    // If already absolute path, return as-is
    if (strpos($relativePath, '/') === 0 || preg_match('/^[A-Za-z]:/', $relativePath)) {
        return $relativePath;
    }
    
    return __DIR__ . '/../' . $relativePath;
}

/**
 * Get relative path from full path
 * 
 * @param string $fullPath - Full absolute path
 * @return string - Relative path for database storage
 */
function getRelativePath($fullPath) {
    if (empty($fullPath)) return '';
    
    // Remove trailing slashes
    $fullPath = rtrim($fullPath, '/');
    
    // Get the project root directory
    $projectRoot = rtrim(__DIR__ . '/..', '/');
    
    // If path is within project root, extract relative part
    if (strpos($fullPath, $projectRoot) === 0) {
        $relative = substr($fullPath, strlen($projectRoot) + 1);
        return $relative;
    }
    
    // If not within project, return as-is (fallback)
    return $fullPath;
}

/**
 * Create folder for new entity
 * Path: BASE_DOCUMENT_PATH/{nama_entitas_formatted}/
 * 
 * @param string $namaEntitas - Entity name from form
 * @return string - Generated folder name
 */
function createEntityFolder($namaEntitas) {
    // Format folder name: replace spaces with underscores, remove special chars
    $folderName = formatFolderName($namaEntitas);
    $fullPath = BASE_DOCUMENT_PATH . $folderName;
    
    if (!is_dir($fullPath)) {
        if (mkdir($fullPath, 0755, true)) {
            // Create subfolders for organization
            $subfolders = ['Arsip', 'Dokumen_Lainnya'];
            foreach ($subfolders as $subfolder) {
                mkdir($fullPath . '/' . $subfolder, 0755, true);
            }
            logActivity('folder_created', 'Entity folder created: ' . $folderName);
            return $folderName;
        } else {
            throw new Exception('Failed to create entity folder: ' . $folderName);
        }
    }
    
    return $folderName;
}

/**
 * Create folder for new job/work
 * Path: BASE_DOCUMENT_PATH/{entity_folder}/{inisial_akun_belanja}_{inisial_penyedia}/
 * 
 * @param string $entityFolder - Parent entity folder name
 * @param string $inisialAkunBelanja - Spending account initial (JIJ, PM, BG, TL, ATL, AL)
 * @param string $inisialPenyedia - Provider initial (e.g., PTJK, PTSS, CMJ)
 * @return string - Generated folder name
 */
function createJobFolder($entityFolder, $inisialAkunBelanja, $inisialPenyedia) {
    // Format: {inisial_akun_belanja}_{inisial_penyedia}
    $folderName = strtoupper($inisialAkunBelanja) . '_' . strtoupper($inisialPenyedia);
    $fullPath = BASE_DOCUMENT_PATH . $entityFolder . '/' . $folderName;
    
    if (!is_dir($fullPath)) {
        if (mkdir($fullPath, 0755, true)) {
            // Create subfolders for document organization
            $subfolders = [
                'Dokumen',
                'Dokumen/Umum',
                'Dokumen/Tanah',
                'Addendum',
                'Pembayaran',
                'Serah_Terima',
                'Foto',
                'Gambar',
                'Laporan'
            ];
            
            foreach ($subfolders as $subfolder) {
                mkdir($fullPath . '/' . $subfolder, 0755, true);
            }
            
            logActivity('folder_created', 'Job folder created: ' . $entityFolder . '/' . $folderName);
            return $folderName;
        } else {
            throw new Exception('Failed to create job folder: ' . $folderName);
        }
    }
    
    return $folderName;
}

/**
 * Generate document filename with proper format
 * Format: {nama_dokumen}_{inisial_akun_belanja}_{inisial_penyedia}.{extension}
 * 
 * @param string $namaDokumen - Document name (e.g., Kontrak, SPMK)
 * @param string $inisialAkunBelanja - Spending account initial
 * @param string $inisialPenyedia - Provider initial
 * @param string $extension - File extension
 * @return string - Formatted document name
 */
function formatDocumentName($namaDokumen, $inisialAkunBelanja, $inisialPenyedia, $extension = 'pdf') {
    $inisial = strtoupper($inisialAkunBelanja) . '_' . strtoupper($inisialPenyedia);
    $docName = formatFolderName($namaDokumen);
    return $docName . '_' . $inisial . '.' . $extension;
}

/**
 * Format string to be folder/file name safe
 * 
 * @param string $name - Original name
 * @return string - Formatted safe name
 */
function formatFolderName($name) {
    // Replace spaces with underscores
    $formatted = str_replace(' ', '_', $name);
    // Remove special characters except underscores and hyphens
    $formatted = preg_replace('/[^a-zA-Z0-9_\-]/', '', $formatted);
    // Remove multiple underscores
    $formatted = preg_replace('/_+/', '_', $formatted);
    // Trim underscores
    $formatted = trim($formatted, '_');
    
    return $formatted;
}

/**
 * Get full path for document storage
 * 
 * @param string $entityFolder - Entity folder name
 * @param string $jobFolder - Job folder name
 * @param string $subfolder - Subfolder path (e.g., 'Dokumen/Umum')
 * @return string - Full path
 */
function getDocumentPath($entityFolder, $jobFolder, $subfolder = 'Dokumen') {
    $path = BASE_DOCUMENT_PATH . $entityFolder . '/' . $jobFolder . '/' . $subfolder;
    
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
    
    return $path;
}

/**
 * Log folder creation activity
 * 
 * @param string $action - Action type
 * @param string $description - Activity description
 */
function logActivity($action, $description) {
    // Can be extended to write to database activity_log table
    // For now, write to log file
    $logFile = __DIR__ . '/../logs/folder_activity.log';
    $logDir = dirname($logFile);
    
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] [$action] $description\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

/**
 * Delete folder recursively
 * 
 * @param string $dirPath - Directory path to delete
 * @return bool - Success status
 */
function deleteFolder($dirPath) {
    if (!is_dir($dirPath)) {
        return false;
    }
    
    $items = array_diff(scandir($dirPath), array('.', '..'));
    
    foreach ($items as $item) {
        $path = $dirPath . '/' . $item;
        if (is_dir($path)) {
            deleteFolder($path);
        } else {
            unlink($path);
        }
    }
    
    return rmdir($dirPath);
}

/**
 * Get spending account initial from full name
 * 
 * @param string $jenisModal - Full modal type name
 * @return string - Initial code
 */
function getAkunBelanjaInitial($jenisModal) {
    $mapping = [
        'BM JIJ' => 'JIJ',
        'Belanja Modal Jalan, Irigasi, dan Jaringan' => 'JIJ',
        'BM Gedung dan Bangunan' => 'BG',
        'Belanja Modal Gedung dan Bangunan' => 'BG',
        'BM Peralatan Mesin' => 'PM',
        'Belanja Modal Peralatan Mesin' => 'PM',
        'BM Tanah' => 'TL',
        'Belanja Modal Tanah' => 'TL',
        'BM Aset Tetap Lainnya' => 'ATL',
        'Belanja Modal Aset Tetap Lainnya' => 'ATL',
        'BM Aset Lainnya' => 'AL',
        'Belanja Modal Aset Lainnya' => 'AL'
    ];
    
    foreach ($mapping as $key => $value) {
        if (stripos($jenisModal, $key) !== false) {
            return $value;
        }
    }
    
    return 'OTH';
}

/**
 * Get provider initial from name (auto-generate if not exists)
 * 
 * @param string $namaPenyedia - Provider name
 * @param string $existingInitial - Existing initial from database (optional)
 * @return string - Initial code
 */
function getPenyediaInitial($namaPenyedia, $existingInitial = null) {
    if ($existingInitial) {
        return $existingInitial;
    }
    
    // Generate from name - take first letters of each word
    $words = explode(' ', $namaPenyedia);
    $initial = '';
    
    foreach ($words as $word) {
        if (strlen($word) > 2 && strtoupper($word) !== 'PT' && strtoupper($word) !== 'CV' && strtoupper($word) !== 'TO') {
            $initial .= strtoupper(substr($word, 0, 1));
        }
    }
    
    // Add PT or CV prefix
    if (stripos($namaPenyedia, 'PT ') === 0) {
        $initial = 'PT' . $initial;
    } elseif (stripos($namaPenyedia, 'CV ') === 0) {
        $initial = 'CV' . $initial;
    }
    
    return $initial ?: 'PEN';
}
