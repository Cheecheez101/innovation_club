<?php
class AuthController extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            // Validate input
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Please enter username and password';
                $this->view('auth/login');
                return;
            }
            
            $db = Database::getInstance();
            $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
            $user = $db->fetchOne($sql, ['username' => $username, 'email' => $username]);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['success'] = 'Login successful!';
                
                // Redirect based on role
                $this->redirect('dashboard');
            } else {
                $_SESSION['error'] = 'Invalid username or password';
                $this->view('auth/login');
            }
        } else {
            $this->view('auth/login');
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            $role = $_POST['role'] ?? 'member';
            
            // Validate input
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Please fill in all required fields';
                $this->view('auth/register');
                return;
            }
            
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
                $this->view('auth/register');
                return;
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters long';
                $this->view('auth/register');
                return;
            }
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Please enter a valid email address';
                $this->view('auth/register');
                return;
            }
            
            $db = Database::getInstance();
            
            // Check if username already exists
            $existingUser = $db->fetchOne("SELECT id FROM users WHERE username = :username", ['username' => $username]);
            if ($existingUser) {
                $_SESSION['error'] = 'Username already exists';
                $this->view('auth/register');
                return;
            }
            
            // Check if email already exists
            $existingEmail = $db->fetchOne("SELECT id FROM users WHERE email = :email", ['email' => $email]);
            if ($existingEmail) {
                $_SESSION['error'] = 'Email already exists';
                $this->view('auth/register');
                return;
            }
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $result = $db->insert('users', [
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => $role,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            if ($result) {
                $_SESSION['success'] = 'Registration successful! Please login with your credentials.';
                $this->redirect('auth/login');
            } else {
                $_SESSION['error'] = 'Registration failed. Please try again.';
                $this->view('auth/register');
            }
        } else {
            $this->view('auth/register');
        }
    }
}
