<?php
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

require_once APP_PATH . '/core/Database.php';

$db = Database::getInstance();

try {
    $stmt = $db->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . implode(', ', $tables) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$hashedPassword = password_hash('password123', PASSWORD_DEFAULT);

echo "Hash: $hashedPassword\n";

$result = $db->insert('users', [
    'username' => 'admin',
    'email' => 'admin@example.com',
    'password' => $hashedPassword,
    'role' => 'admin',
    'is_active' => true,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
]);

if ($result) {
    echo "Admin user created successfully.\n";
} else {
    echo "Failed to create admin user.\n";
}
?>