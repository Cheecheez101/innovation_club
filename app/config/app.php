<?php
// Application Configuration
define('APP_NAME', 'Elite Academy Innovation Club');
define('APP_VERSION', '1.0.0');
define('APP_DEBUG', true);
define('BASE_URL', 'http://localhost/innovation_club/public');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

// Timezone
date_default_timezone_set('Africa/Nairobi');
