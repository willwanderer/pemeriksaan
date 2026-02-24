<?php
/**
 * Database Connection for Pemeriksaan Application
 * 
 * Configuration - Update these values according to your setup
 */

// Disable error display to prevent HTML output in API
error_reporting(0);
ini_set('display_errors', 0);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'mysqlwilly');
define('DB_NAME', 'pemeriksaan');

/**
 * Get database connection
 * 
 * @return mysqli|null
 */
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        return null;
    }
    
    // Set charset to UTF-8
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

/**
 * Execute query with error handling
 * 
 * @param string $sql
 * @param array $params
 * @return mysqli_result|bool
 */
function executeQuery($sql, $params = []) {
    $conn = getDBConnection();
    
    if (!$conn) {
        return false;
    }
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        $conn->close();
        return false;
    }
    
    if (!empty($params)) {
        $types = '';
        $values = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $values[] = $param;
        }
        
        $stmt->bind_param($types, ...$values);
    }
    
    $result = $stmt->execute();
    
    if (!$result) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        $conn->close();
        return false;
    }
    
    $stmt->close();
    $conn->close();
    
    return $result;
}

/**
 * Get single row from database
 * 
 * @param string $sql
 * @param array $params
 * @return array|null
 */
function getRow($sql, $params = []) {
    $conn = getDBConnection();
    
    if (!$conn) {
        return null;
    }
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return null;
    }
    
    if (!empty($params)) {
        $types = '';
        $values = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $values[] = $param;
        }
        
        $stmt->bind_param($types, ...$values);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $row = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
    
    return $row;
}

/**
 * Get multiple rows from database
 * 
 * @param string $sql
 * @param array $params
 * @return array
 */
function getRows($sql, $params = []) {
    $conn = getDBConnection();
    
    if (!$conn) {
        return [];
    }
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return [];
    }
    
    if (!empty($params)) {
        $types = '';
        $values = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $values[] = $param;
        }
        
        $stmt->bind_param($types, ...$values);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $rows;
}

/**
 * Insert record and return insert ID
 * 
 * @param string $table
 * @param array $data
 * @return int|bool
 */
function insertRecord($table, $data) {
    $conn = getDBConnection();
    
    if (!$conn) {
        return false;
    }
    
    $columns = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return false;
    }
    
    $types = '';
    $values = [];
    
    foreach ($data as $value) {
        if (is_int($value)) {
            $types .= 'i';
        } elseif (is_float($value)) {
            $types .= 'd';
        } else {
            $types .= 's';
        }
        $values[] = $value;
    }
    
    $stmt->bind_param($types, ...$values);
    
    $result = $stmt->execute();
    
    if ($result) {
        $insertId = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        return $insertId;
    }
    
    $stmt->close();
    $conn->close();
    
    return false;
}

/**
 * Update record
 * 
 * @param string $table
 * @param array $data
 * @param string $where
 * @param array $whereParams
 * @return bool
 */
function updateRecord($table, $data, $where, $whereParams = []) {
    $conn = getDBConnection();
    
    if (!$conn) {
        return false;
    }
    
    $setParts = [];
    foreach (array_keys($data) as $key) {
        $setParts[] = "$key = ?";
    }
    
    $setClause = implode(', ', $setParts);
    $sql = "UPDATE $table SET $setClause WHERE $where";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return false;
    }
    
    $types = '';
    $values = [];
    
    foreach ($data as $value) {
        if (is_int($value)) {
            $types .= 'i';
        } elseif (is_float($value)) {
            $types .= 'd';
        } else {
            $types .= 's';
        }
        $values[] = $value;
    }
    
    foreach ($whereParams as $param) {
        if (is_int($param)) {
            $types .= 'i';
        } elseif (is_float($param)) {
            $types .= 'd';
        } else {
            $types .= 's';
        }
        $values[] = $param;
    }
    
    $stmt->bind_param($types, ...$values);
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    return $result;
}

/**
 * Delete record
 * 
 * @param string $table
 * @param string $where
 * @param array $params
 * @return bool
 */
function deleteRecord($table, $where, $params = []) {
    $conn = getDBConnection();
    
    if (!$conn) {
        return false;
    }
    
    $sql = "DELETE FROM $table WHERE $where";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return false;
    }
    
    if (!empty($params)) {
        $types = '';
        $values = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $values[] = $param;
        }
        
        $stmt->bind_param($types, ...$values);
    }
    
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    return $result;
}

/**
 * Run raw query (for operations not covered by other functions)
 * 
 * @param string $sql
 * @param array $params
 * @return bool
 */
function runQuery($sql, $params = []) {
    $conn = getDBConnection();
    
    if (!$conn) {
        return false;
    }
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        $conn->close();
        return false;
    }
    
    if (!empty($params)) {
        $types = '';
        $values = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $values[] = $param;
        }
        
        $stmt->bind_param($types, ...$values);
    }
    
    $result = $stmt->execute();
    
    if (!$result) {
        error_log("Execute failed: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();
    
    return $result;
}
