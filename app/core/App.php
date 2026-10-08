<?php
class App {
    private $controller = 'Dashboard';
    private $controllerName = 'Dashboard';
    private $method = 'index';
    private $params = [];

    public function __construct() {
        // Constructor - just initialize properties
    }

    public function run() {
        $url = $this->parseUrl();

        // Set controller
        if (isset($url[0])) {
            $controllerName = $this->singularize($url[0]);
            $controllerFile = APP_PATH . '/controllers/' . ucfirst($controllerName) . 'Controller.php';
            if (file_exists($controllerFile)) {
                $this->controllerName = ucfirst($controllerName);
                unset($url[0]);
            }
        }

        require_once APP_PATH . '/controllers/' . $this->controllerName . 'Controller.php';
        $controllerClass = $this->controllerName . 'Controller';
        $this->controller = new $controllerClass();

        // Set method
        if (isset($url[1])) {
            // Convert kebab-case to camelCase: edit-user -> editUser
            $parts = explode('-', $url[1]);
            $methodName = array_shift($parts);
            foreach ($parts as $part) {
                $methodName .= ucfirst($part);
            }

            // Backward compatibility: /controller/view/{id} -> show({id})
            if ($methodName === 'view' && is_callable([$this->controller, 'show'])) {
                $methodName = 'show';
            }

            if (is_callable([$this->controller, $methodName])) {
                $this->method = $methodName;
                unset($url[1]);
            }
        }

        // Set parameters
        $this->params = $url ? array_values($url) : [];

        // Check authentication before executing controller
        $this->checkAuthentication();

        // Call controller method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return ['dashboard'];
    }

    private function singularize($word) {
        if (substr($word, -1) === 's') {
            return substr($word, 0, -1);
        }
        return $word;
    }

    private function checkAuthentication() {
        // Temporarily disabled for testing
        /*
        $publicRoutes = ['auth/login', 'auth/register'];
        $publicPrefixes = ['projects'];
        $currentRoute = isset($_GET['url']) ? $_GET['url'] : 'dashboard';

        // Debug: log the current route
        error_log("Current route: " . $currentRoute);

        $isPublic = in_array($currentRoute, $publicRoutes);
        if (!$isPublic) {
            foreach ($publicPrefixes as $prefix) {
                if (strpos($currentRoute, $prefix) === 0) {
                    $isPublic = true;
                    break;
                }
            }
        }

        if (!$isPublic && !isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
        */
    }
}
