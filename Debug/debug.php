<?php
// Debug page to test database connection and operations
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Expense Tracker - Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Expense Tracker - Debug Page</h1>
    
    <?php
    echo "<h2>PHP Configuration</h2>";
    echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
    echo "<p><strong>PDO Available:</strong> " . (extension_loaded('pdo') ? 'Yes' : 'No') . "</p>";
    echo "<p><strong>PDO MySQL Available:</strong> " . (extension_loaded('pdo_mysql') ? 'Yes' : 'No') . "</p>";
    
    echo "<h2>Database Connection Test</h2>";
    
    try {
        require_once '../config/database.php';
        
        $database = new Database();
        $conn = $database->connect();
        
        if ($conn) {
            echo "<p class='success'>✓ Database connection successful</p>";
            
            // Test table exists
            $stmt = $conn->prepare("SHOW TABLES LIKE 'expenses'");
            $stmt->execute();
            $tableExists = $stmt->fetch();
            
            if ($tableExists) {
                echo "<p class='success'>✓ Expenses table exists</p>";
                
                // Test table structure
                $stmt = $conn->prepare("DESCRIBE expenses");
                $stmt->execute();
                $columns = $stmt->fetchAll();
                
                echo "<h3>Table Structure:</h3>";
                echo "<pre>";
                foreach ($columns as $column) {
                    echo $column['Field'] . " - " . $column['Type'] . " - " . $column['Null'] . " - " . $column['Key'] . "\n";
                }
                echo "</pre>";
                
                // Test insert
                echo "<h3>Test Insert:</h3>";
                try {
                    $testStmt = $conn->prepare("INSERT INTO expenses (date, amount, category, description) VALUES (?, ?, ?, ?)");
                    $testResult = $testStmt->execute([date('Y-m-d'), 10.50, 'Test', 'Debug test record']);
                    
                    if ($testResult) {
                        $testId = $conn->lastInsertId();
                        echo "<p class='success'>✓ Test insert successful (ID: $testId)</p>";
                        
                        // Test select
                        $selectStmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
                        $selectStmt->execute([$testId]);
                        $testRecord = $selectStmt->fetch();
                        
                        if ($testRecord) {
                            echo "<p class='success'>✓ Test select successful</p>";
                            echo "<pre>" . print_r($testRecord, true) . "</pre>";
                        }
                        
                        // Clean up test record
                        $deleteStmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
                        $deleteStmt->execute([$testId]);
                        echo "<p class='info'>ℹ Test record cleaned up</p>";
                    }
                } catch (Exception $e) {
                    echo "<p class='error'>✗ Test insert failed: " . $e->getMessage() . "</p>";
                }
                
                // Show existing records count
                $countStmt = $conn->prepare("SELECT COUNT(*) as count FROM expenses");
                $countStmt->execute();
                $count = $countStmt->fetch()['count'];
                echo "<p class='info'>Total expenses in database: $count</p>";
                
            } else {
                echo "<p class='error'>✗ Expenses table does not exist</p>";
            }
            
        } else {
            echo "<p class='error'>✗ Database connection failed</p>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>✗ Error: " . $e->getMessage() . "</p>";
        echo "<p class='error'>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
    }
    
    echo "<h2>POST Test</h2>";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<p class='info'>POST data received:</p>";
        echo "<pre>" . print_r($_POST, true) . "</pre>";
    } else {
        echo "<form method='POST'>";
        echo "<p>Test POST submission:</p>";
        echo "<input type='date' name='date' value='" . date('Y-m-d') . "'>";
        echo "<input type='number' name='amount' step='0.01' value='25.00'>";
        echo "<select name='category'>";
        echo "<option value='Food'>Food</option>";
        echo "<option value='Transport'>Transport</option>";
        echo "</select>";
        echo "<input type='text' name='description' value='Test expense'>";
        echo "<button type='submit'>Test Submit</button>";
        echo "</form>";
    }
    ?>
    
    <h2>Quick Actions</h2>
    <p><a href="../index.php">← Back to Main App</a></p>
    <p><a href="../add_expense.php" target="_blank">Test add_expense.php directly</a></p>
    <p><a href="../get_expenses.php" target="_blank">Test get_expenses.php directly</a></p>
</body>
</html>