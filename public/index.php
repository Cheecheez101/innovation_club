<?php
// Elite Academy Innovation Club Management System
// Main Entry Point

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

// Load configuration first (before session starts)
require_once APP_PATH . '/config/app.php';

// Start session after configuration is loaded
session_start();

// Autoloader
spl_autoload_register(function ($className) {
    // Convert namespace separators to directory separators
    $file = APP_PATH . '/' . str_replace('\\', '/', $className) . '.php';

    // If direct path doesn't exist, try to find in subdirectories
    if (!file_exists($file)) {
        // Try core directory
        $coreFile = APP_PATH . '/core/' . $className . '.php';
        if (file_exists($coreFile)) {
            require_once $coreFile;
            return;
        }

        // Try controllers directory
        $controllerFile = APP_PATH . '/controllers/' . $className . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            return;
        }

        // Try models directory
        $modelFile = APP_PATH . '/models/' . $className . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return;
        }
    } else {
        require_once $file;
    }
});

// Initialize and run application
try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    error_log("Application error: " . $e->getMessage());
    http_response_code(500);
    echo "An error occurred. Please try again later.";
    if (defined('APP_DEBUG') && APP_DEBUG) {
        echo "<pre>" . $e->getMessage() . "</pre>";
    }
}
