<?php
class MemberController extends Controller {
    private $memberModel;
    
    public function __construct() {
        require_once APP_PATH . '/models/Member.php';
        $this->memberModel = new Member();
        // Temporarily disabled for testing
        // $this->requirePatron(); // Only patrons and admins can manage members
    }
    
    public function index() {
        $search = $_GET['search'] ?? '';
        if (!empty($search)) {
            $members = $this->memberModel->search($search);
        } else {
            $members = $this->memberModel->findAll();
        }
        
        $data = [
            'title' => 'Members - ' . APP_NAME,
            'members' => $members,
            'search' => $search
        ];
        
        $this->view('members/index', $data);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Extract user account data
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Extract member data
            $memberData = [
                'full_name' => trim($_POST['full_name']),
                'student_id' => trim($_POST['student_id']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone'] ?? ''),
                'department' => trim($_POST['department']),
                'year_of_study' => trim($_POST['year_of_study']),
                'join_date' => date('Y-m-d')
            ];
            
            // Validate login credentials
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username and password are required';
                $this->view('members/create', ['title' => 'Add New Member']);
                return;
            }
            
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
                $this->view('members/create', ['title' => 'Add New Member']);
                return;
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters long';
                $this->view('members/create', ['title' => 'Add New Member']);
                return;
            }
            
            // Validate email format
            if (!filter_var($memberData['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Please enter a valid email address';
                $this->view('members/create', ['title' => 'Add New Member']);
                return;
            }
            
            // Check for existing username and email
            require_once APP_PATH . '/models/User.php';
            $userModel = new User();
            
            $existingUser = $userModel->findByUsername($username);
            if ($existingUser) {
                $_SESSION['error'] = 'Username already exists';
                $this->view('members/create', ['title' => 'Add New Member']);
                return;
            }
            
            $existingEmail = $userModel->findByUsername($memberData['email']);
            if ($existingEmail) {
                $_SESSION['error'] = 'Email already exists';
                $this->view('members/create', ['title' => 'Add New Member']);
                return;
            }
            
            // Create user account first
            $userData = [
                'username' => $username,
                'email' => $memberData['email'],
                'password' => $password,
                'role' => 'member',
                'is_active' => true
            ];
            
            $userId = $userModel->createUser($userData);
            
            if (!$userId) {
                $_SESSION['error'] = 'Failed to create user account';
                $this->view('members/create', ['title' => 'Add New Member']);
                return;
            }
            
            // Add user_id to member data
            $memberData['user_id'] = $userId;
            
            // Create member record
            if ($this->memberModel->create($memberData)) {
                $_SESSION['success'] = 'Member registered successfully! They can now login with their credentials.';
                $this->redirect('members');
            } else {
                // If member creation fails, we should probably delete the user account
                // But for now, just show error
                $_SESSION['error'] = 'Failed to create member record';
                $this->view('members/create', ['title' => 'Add New Member']);
            }
        } else {
            $this->view('members/create', ['title' => 'Register New Member']);
        }
    }
    
    public function edit($id) {
        $member = $this->memberModel->findById($id);
        
        if (!$member) {
            $_SESSION['error'] = 'Member not found';
            $this->redirect('members');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateData = [
                'full_name' => trim($_POST['full_name']),
                'student_id' => trim($_POST['student_id']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone'] ?? ''),
                'department' => trim($_POST['department']),
                'year_of_study' => trim($_POST['year_of_study'])
            ];
            
            if ($this->memberModel->update($id, $updateData)) {
                $_SESSION['success'] = 'Member updated successfully!';
                $this->redirect('members');
            } else {
                $_SESSION['error'] = 'Failed to update member';
            }
        }
        
        $data = [
            'title' => 'Edit Member',
            'member' => $member
        ];
        
        $this->view('members/edit', $data);
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        require_once APP_PATH . '/models/User.php';
        $userModel = new User();

        $userId = (int)$_SESSION['user_id'];
        $user = $userModel->findById($userId);
        $member = $this->memberModel->findByUserId($userId);

        if (!$user) {
            $_SESSION['error'] = 'User profile not found.';
            $this->redirect('dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getInstance();
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $fullName = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $department = trim($_POST['department'] ?? '');
            $yearOfStudy = trim($_POST['year_of_study'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_new_password'] ?? '';

            if (empty($username) || empty($email)) {
                $_SESSION['error'] = 'Username and email are required.';
                $this->view('members/profile', [
                    'title' => 'My Profile - ' . APP_NAME,
                    'user' => $user,
                    'member' => $member
                ]);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Please enter a valid email address.';
                $this->view('members/profile', [
                    'title' => 'My Profile - ' . APP_NAME,
                    'user' => $user,
                    'member' => $member
                ]);
                return;
            }

            $existingUsername = $db->fetchOne(
                "SELECT id FROM users WHERE username = ? AND id != ?",
                [$username, $userId]
            );
            if ($existingUsername) {
                $_SESSION['error'] = 'Username already exists.';
                $this->view('members/profile', [
                    'title' => 'My Profile - ' . APP_NAME,
                    'user' => $user,
                    'member' => $member
                ]);
                return;
            }

            $existingEmail = $db->fetchOne(
                "SELECT id FROM users WHERE email = ? AND id != ?",
                [$email, $userId]
            );
            if ($existingEmail) {
                $_SESSION['error'] = 'Email already exists.';
                $this->view('members/profile', [
                    'title' => 'My Profile - ' . APP_NAME,
                    'user' => $user,
                    'member' => $member
                ]);
                return;
            }

            $userData = [
                'username' => $username,
                'email' => $email,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!empty($newPassword) || !empty($currentPassword) || !empty($confirmPassword)) {
                if (empty($currentPassword)) {
                    $_SESSION['error'] = 'Current password is required to set a new password.';
                    $this->view('members/profile', [
                        'title' => 'My Profile - ' . APP_NAME,
                        'user' => $user,
                        'member' => $member
                    ]);
                    return;
                }

                if (!password_verify($currentPassword, $user['password'])) {
                    $_SESSION['error'] = 'Current password is incorrect.';
                    $this->view('members/profile', [
                        'title' => 'My Profile - ' . APP_NAME,
                        'user' => $user,
                        'member' => $member
                    ]);
                    return;
                }

                if (strlen($newPassword) < 6) {
                    $_SESSION['error'] = 'New password must be at least 6 characters long.';
                    $this->view('members/profile', [
                        'title' => 'My Profile - ' . APP_NAME,
                        'user' => $user,
                        'member' => $member
                    ]);
                    return;
                }

                if ($newPassword !== $confirmPassword) {
                    $_SESSION['error'] = 'New password and confirmation do not match.';
                    $this->view('members/profile', [
                        'title' => 'My Profile - ' . APP_NAME,
                        'user' => $user,
                        'member' => $member
                    ]);
                    return;
                }

                $userData['password'] = $newPassword;
            }

            $userUpdated = $userModel->updateUser($userId, $userData);

            if ($userUpdated === false) {
                $_SESSION['error'] = 'Failed to update profile. Please try again.';
                $this->redirect('members/profile');
                return;
            }

            if ($member) {
                $memberData = [
                    'full_name' => $fullName,
                    'email' => $email,
                    'phone' => $phone,
                    'department' => $department,
                    'year_of_study' => $yearOfStudy,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->memberModel->update($member['id'], $memberData);
            }

            $_SESSION['username'] = $username;
            $_SESSION['success'] = 'Profile updated successfully!';
            $this->redirect('members/profile');
            return;
        }

        $this->view('members/profile', [
            'title' => 'My Profile - ' . APP_NAME,
            'user' => $user,
            'member' => $member
        ]);
    }

    public function delete($id = null) {
        if (!$id) {
            $this->redirect('members');
            return;
        }
        
        $this->memberModel->delete($id);
        $this->redirect('members');
    }
}
