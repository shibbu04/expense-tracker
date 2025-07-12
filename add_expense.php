<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Check if connection is successful
        $database = new Database();
        $conn = $database->connect();
        
        if (!$conn) {
            throw new Exception('Database connection failed');
        }
        
        // Get and validate input
        $date = isset($_POST['date']) ? trim($_POST['date']) : '';
        $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
        $category = isset($_POST['category']) ? trim($_POST['category']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        
        // Validation
        if (empty($date)) {
            throw new Exception('Date is required');
        }
        
        if (empty($amount)) {
            throw new Exception('Amount is required');
        }
        
        if (empty($category)) {
            throw new Exception('Category is required');
        }
        
        if (!is_numeric($amount) || $amount <= 0) {
            throw new Exception('Amount must be a positive number');
        }
        
        // Validate date format
        $dateTime = DateTime::createFromFormat('Y-m-d', $date);
        if (!$dateTime || $dateTime->format('Y-m-d') !== $date) {
            throw new Exception('Invalid date format');
        }
        
        // Insert expense
        $sql = "INSERT INTO expenses (date, amount, category, description) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception('Failed to prepare statement: ' . $conn->errorInfo()[2]);
        }
        
        $result = $stmt->execute([$date, floatval($amount), $category, $description]);
        
        if (!$result) {
            throw new Exception('Failed to insert expense: ' . $stmt->errorInfo()[2]);
        }
        
        echo json_encode([
            'success' => true, 
            'message' => 'Expense added successfully',
            'id' => $conn->lastInsertId()
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false, 
            'message' => $e->getMessage(),
            'error_details' => [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
}
?>