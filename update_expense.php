<?php
header('Content-Type: application/json');
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $conn = $db->connect();

        $id = $_POST['id'] ?? '';
        $date = $_POST['date'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $category = $_POST['category'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!$id || !$date || !$amount || !$category) {
            throw new Exception("All fields are required.");
        }

        $sql = "UPDATE expenses SET date = ?, amount = ?, category = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$date, $amount, $category, $description, $id]);

        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}
?>