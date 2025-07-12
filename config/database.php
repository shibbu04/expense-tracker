<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'expense_tracker';
    private $username = 'root';
    private $password = 'Vipin'; // Adjust as needed
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                                $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
        return $this->conn;
    }
}

// Create database and table if they don't exist
function initializeDatabase() {
    try {
        // First connect without database to create it
        $pdo = new PDO("mysql:host=localhost", 'root', 'Vipin');   // Adjust credentials as needed
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create database
        $pdo->exec("CREATE DATABASE IF NOT EXISTS expense_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE expense_tracker");
        
        // Create expenses table with proper constraints
        $sql = "CREATE TABLE IF NOT EXISTS expenses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            date DATE NOT NULL,
            amount DECIMAL(10,2) NOT NULL CHECK (amount > 0),
            category VARCHAR(100) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_date (date),
            INDEX idx_category (category)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        
        // Test the table by inserting and deleting a test record
        $testInsert = "INSERT INTO expenses (date, amount, category, description) VALUES (CURDATE(), 1.00, 'Test', 'Test record')";
        $pdo->exec($testInsert);
        
        $testDelete = "DELETE FROM expenses WHERE category = 'Test' AND description = 'Test record'";
        $pdo->exec($testDelete);
        
    } catch(PDOException $e) {
        error_log("Database initialization error: " . $e->getMessage());
        throw new Exception("Database setup failed: " . $e->getMessage());
    }
}

// Initialize database on first run
try {
    initializeDatabase();
} catch(Exception $e) {
    error_log("Failed to initialize database: " . $e->getMessage());
}
?>