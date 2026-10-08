<?php
// Application Configuration
define('APP_NAME', ' Academy Innovation Club');
define('APP_VERSION', '1.0.0');
define('APP_DEBUG', true);

// Dynamic BASE_URL with HTTPS preference
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') 
            ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = str_replace('/public/index.php', '/public', $scriptName);
define('BASE_URL', $protocol . '://' . $host . $basePath);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

// Timezone
date_default_timezone_set('Africa/Nairobi');
