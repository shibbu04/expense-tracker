<?php
header('Content-Type: application/json');
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $conn = $db->connect();

        $id = $_POST['id'] ?? '';

        if (!$id) {
            throw new Exception("ID is required.");
        }

        $sql = "DELETE FROM expenses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}
?>