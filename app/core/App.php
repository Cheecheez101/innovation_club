<?php
class App {
    private $controller = 'Dashboard';
    private $method = 'index';
    private $params = [];

    public function __construct() {
        // Constructor - just initialize properties
    }

    public function run() {
        $url = $this->parseUrl();

        // Set controller
        if (isset($url[0]) && file_exists(APP_PATH . '/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }

        require_once APP_PATH . '/controllers/' . $this->controller . 'Controller.php';
        $controllerClass = $this->controller . 'Controller';
        $this->controller = new $controllerClass();

        // Set method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
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

    private function checkAuthentication() {
        $publicRoutes = ['auth/login', 'auth/register'];
        $currentRoute = isset($_GET['url']) ? $_GET['url'] : 'dashboard';

        if (!in_array($currentRoute, $publicRoutes) && !isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }
}
