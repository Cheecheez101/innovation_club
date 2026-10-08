<?php
class AuthController extends Controller {
    
    private function renderStandaloneView($view, $data = []) {
        extract($data);
        $viewPath = APP_PATH . '/views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("View '$view' not found!");
        }
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            // Validate input
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Please enter username and password';
                $this->renderStandaloneView('auth/login');
                return;
            }
            
            require_once APP_PATH . '/models/User.php';
            $userModel = new User();
            $user = $userModel->findByUsername($username);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['success'] = 'Login successful!';
                
                // Redirect based on role
                $this->redirect('dashboard');
            } else {
                $_SESSION['error'] = 'Invalid username or password';
                $this->renderStandaloneView('auth/login');
            }
        } else {
            $this->renderStandaloneView('auth/login');
        }
    }
    
    public function logout() {
        // Clear all session variables
        $_SESSION = [];
        
        // Destroy the session
        session_destroy();
        
        // Clear the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        // Redirect to login page
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Extract user account data
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Extract member data
            $fullName = trim($_POST['full_name']);
            $studentId = strtoupper(trim($_POST['student_id']));
            $department = trim($_POST['department']);
            $yearOfStudy = trim($_POST['year_of_study']);
            
            // Validate required fields
            if (empty($username) || empty($email) || empty($password) || empty($fullName) || empty($studentId) || empty($department) || empty($yearOfStudy)) {
                $_SESSION['error'] = 'Please fill in all required fields';
                $this->renderStandaloneView('auth/register');
                return;
            }
            
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
                $this->renderStandaloneView('auth/register');
                return;
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters long';
                $this->renderStandaloneView('auth/register');
                return;
            }
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Please enter a valid email address';
                $this->renderStandaloneView('auth/register');
                return;
            }
            
            $db = Database::getInstance();
            
            // Check if username already exists
            $existingUser = $db->fetchOne("SELECT id FROM users WHERE username = ?", [$username]);
            if ($existingUser) {
                $_SESSION['error'] = 'Username already exists';
                $this->renderStandaloneView('auth/register');
                return;
            }
            
            // Check if email already exists
            $existingEmail = $db->fetchOne("SELECT id FROM users WHERE email = ?", [$email]);
            if ($existingEmail) {
                $_SESSION['error'] = 'Email already exists';
                $this->renderStandaloneView('auth/register');
                return;
            }
            
            // Check if student ID already exists
            $existingStudent = $db->fetchOne("SELECT id FROM members WHERE UPPER(student_id) = UPPER(?)", [$studentId]);
            if ($existingStudent) {
                $_SESSION['error'] = 'Student ID already exists';
                $this->renderStandaloneView('auth/register');
                return;
            }

            try {
                $connection = $db->getConnection();
                $connection->beginTransaction();

                $userId = $db->insert('users', [
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => 'member'
                ]);

                if (!$userId) {
                    $connection->rollBack();
                    $_SESSION['error'] = 'Registration failed. Please try again.';
                    $this->renderStandaloneView('auth/register');
                    return;
                }

                $memberResult = $db->insert('members', [
                    'user_id' => $userId,
                    'full_name' => $fullName,
                    'student_id' => $studentId,
                    'email' => $email,
                    'department' => $department,
                    'year_of_study' => $yearOfStudy,
                    'join_date' => date('Y-m-d')
                ]);

                if (!$memberResult) {
                    $connection->rollBack();
                    $_SESSION['error'] = 'Registration failed. Please try again.';
                    $this->renderStandaloneView('auth/register');
                    return;
                }

                $connection->commit();
                $_SESSION['success'] = 'Registration successful! Please login with your credentials.';
                $this->redirect('auth/login');
            } catch (PDOException $e) {
                if (isset($connection) && $connection->inTransaction()) {
                    $connection->rollBack();
                }

                $message = $e->getMessage();

                if (strpos($message, 'student_id') !== false && strpos($message, '1062') !== false) {
                    $_SESSION['error'] = 'Student ID already exists';
                } elseif (strpos($message, 'username') !== false && strpos($message, '1062') !== false) {
                    $_SESSION['error'] = 'Username already exists';
                } elseif (strpos($message, 'email') !== false && strpos($message, '1062') !== false) {
                    $_SESSION['error'] = 'Email already exists';
                } else {
                    $_SESSION['error'] = 'Registration failed. Please try again.';
                }

                $this->renderStandaloneView('auth/register');
            }
        } else {
            $this->renderStandaloneView('auth/register');
        }
    }
}
