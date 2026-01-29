<?php
// Test database connection and queries
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');

// Load configuration
require_once APP_PATH . '/config/app.php';

// Autoloader
spl_autoload_register(function ($className) {
    $file = APP_PATH . '/' . str_replace('\\', '/', $className) . '.php';
    if (!file_exists($file)) {
        $coreFile = APP_PATH . '/core/' . $className . '.php';
        if (file_exists($coreFile)) {
            require_once $coreFile;
            return;
        }
        $controllerFile = APP_PATH . '/controllers/' . $className . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            return;
        }
        $modelFile = APP_PATH . '/models/' . $className . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return;
        }
    } else {
        require_once $file;
    }
});

try {
    echo "Testing database connection...\n";
    $db = Database::getInstance();
    echo "Database connected successfully\n";

    echo "Testing simple query...\n";
    $users = $db->fetchAll("SELECT id, username FROM users LIMIT 1");
    echo "Query successful, found " . count($users) . " users\n";

    echo "Testing parameterized query...\n";
    $user = $db->fetchOne("SELECT * FROM users WHERE username = :username", ['username' => 'admin']);
    echo "Parameterized query successful, found user: " . ($user ? $user['username'] : 'none') . "\n";

    echo "All tests passed!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}