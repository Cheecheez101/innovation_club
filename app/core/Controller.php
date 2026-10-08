<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        
        $viewPath = APP_PATH . '/views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            $layoutPath = APP_PATH . '/views/layouts/';
            
            // Start output buffering
            ob_start();
            
            // Start output buffering
            ob_start();
            
            // Include header if exists
            if (file_exists($layoutPath . 'header.php')) {
                require $layoutPath . 'header.php';
            }
            
            // Include main view
            require $viewPath;
            
            // Include footer if exists
            if (file_exists($layoutPath . 'footer.php')) {
                require $layoutPath . 'footer.php';
            }
            
            // Get and clean buffer
            $content = ob_get_clean();
            echo $content;
        } else {
            echo "<!-- Debug: View file does not exist: $viewPath -->\n";
            die("View '$view' not found!");
        }
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . $url);
        exit;
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    protected function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    protected function isPatron() {
        return isset($_SESSION['role']) && ($_SESSION['role'] === 'patron' || $_SESSION['role'] === 'admin');
    }
    
    protected function requireAdmin() {
        if (!$this->isAdmin()) {
            $this->redirect('dashboard');
        }
    }
    
    protected function requirePatron() {
        if (!$this->isPatron()) {
            $this->redirect('dashboard');
        }
    }
}
