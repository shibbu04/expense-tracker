<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

try {
    $database = new Database();
    $conn = $database->connect();
    
    if (!$conn) {
        throw new Exception('Database connection failed');
    }
    
    $month = isset($_GET['month']) ? trim($_GET['month']) : '';
    $year = isset($_GET['year']) ? trim($_GET['year']) : '';
    
    // Build query with proper parameter binding
    $query = "SELECT id, date, amount, category, description, created_at FROM expenses WHERE 1=1";
    $params = [];
    
    if (!empty($month) && is_numeric($month)) {
        $query .= " AND MONTH(date) = ?";
        $params[] = intval($month);
    }
    
    if (!empty($year) && is_numeric($year)) {
        $query .= " AND YEAR(date) = ?";
        $params[] = intval($year);
    }
    
    $query .= " ORDER BY date DESC, created_at DESC";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->errorInfo()[2]);
    }
    
    $result = $stmt->execute($params);
    if (!$result) {
        throw new Exception('Failed to execute query: ' . $stmt->errorInfo()[2]);
    }
    
    $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate total with same filters
    $totalQuery = "SELECT COALESCE(SUM(amount), 0) as total FROM expenses WHERE 1=1";
    $totalParams = [];
    
    if (!empty($month) && is_numeric($month)) {
        $totalQuery .= " AND MONTH(date) = ?";
        $totalParams[] = intval($month);
    }
    
    if (!empty($year) && is_numeric($year)) {
        $totalQuery .= " AND YEAR(date) = ?";
        $totalParams[] = intval($year);
    }
    
    $totalStmt = $conn->prepare($totalQuery);
    if (!$totalStmt) {
        throw new Exception('Failed to prepare total statement: ' . $conn->errorInfo()[2]);
    }
    
    $totalResult = $totalStmt->execute($totalParams);
    if (!$totalResult) {
        throw new Exception('Failed to execute total query: ' . $totalStmt->errorInfo()[2]);
    }
    
    $totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
    $total = $totalRow['total'] ?? 0;
    
    echo json_encode([
        'success' => true,
        'expenses' => $expenses,
        'total' => floatval($total),
        'count' => count($expenses)
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'expenses' => [],
        'total' => 0,
        'count' => 0,
        'error_details' => [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ]);
}
?>