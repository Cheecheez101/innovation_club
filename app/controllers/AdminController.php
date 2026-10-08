<?php
class AdminController extends Controller {
    private $userModel;
    private $memberModel;
    private $projectModel;

    public function __construct() {
        require_once APP_PATH . '/models/User.php';
        require_once APP_PATH . '/models/Member.php';
        require_once APP_PATH . '/models/Project.php';
        $this->userModel = new User();
        $this->memberModel = new Member();
        $this->projectModel = new Project();
    }

    public function index() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        $data = [
            'title' => 'Admin Dashboard - ' . APP_NAME,
            'stats' => $this->getAdminStats(),
            'recent_members' => $this->memberModel->getRecentMembers(5),
            'recent_projects' => $this->projectModel->getRecentProjects(5)
        ];

        $this->view('admin/index', $data);
    }

    public function members() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        $data = [
            'title' => 'Manage Members - ' . APP_NAME,
            'members' => $this->memberModel->getAllMembers()
        ];

        $this->view('admin/members', $data);
    }

    public function users() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        $data = [
            'title' => 'Manage Users - ' . APP_NAME,
            'users' => $this->userModel->getAllUsers()
        ];

        $this->view('admin/users', $data);
    }

    public function createUser() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'username' => trim($_POST['username'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'role' => trim($_POST['role'] ?? 'member'),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            $confirmPassword = trim($_POST['confirm_password'] ?? '');
            $allowedRoles = ['admin', 'patron', 'member'];

            if ($userData['username'] === '' || $userData['email'] === '' || $userData['password'] === '') {
                $_SESSION['error'] = 'Username, email, and password are required.';
                $this->view('admin/create_user', [
                    'title' => 'Add User - ' . APP_NAME,
                    'user' => $userData
                ]);
                return;
            }

            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Please enter a valid email address.';
                $this->view('admin/create_user', [
                    'title' => 'Add User - ' . APP_NAME,
                    'user' => $userData
                ]);
                return;
            }

            if (strlen($userData['password']) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters long.';
                $this->view('admin/create_user', [
                    'title' => 'Add User - ' . APP_NAME,
                    'user' => $userData
                ]);
                return;
            }

            if ($userData['password'] !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match.';
                $this->view('admin/create_user', [
                    'title' => 'Add User - ' . APP_NAME,
                    'user' => $userData
                ]);
                return;
            }

            if (!in_array($userData['role'], $allowedRoles, true)) {
                $_SESSION['error'] = 'Invalid role selected.';
                $this->view('admin/create_user', [
                    'title' => 'Add User - ' . APP_NAME,
                    'user' => $userData
                ]);
                return;
            }

            $db = Database::getInstance();
            $existingUsername = $db->fetchOne('SELECT id FROM users WHERE username = ?', [$userData['username']]);
            if ($existingUsername) {
                $_SESSION['error'] = 'Username already exists.';
                $this->view('admin/create_user', [
                    'title' => 'Add User - ' . APP_NAME,
                    'user' => $userData
                ]);
                return;
            }

            $existingEmail = $db->fetchOne('SELECT id FROM users WHERE email = ?', [$userData['email']]);
            if ($existingEmail) {
                $_SESSION['error'] = 'Email already exists.';
                $this->view('admin/create_user', [
                    'title' => 'Add User - ' . APP_NAME,
                    'user' => $userData
                ]);
                return;
            }

            if ($this->userModel->createUser($userData)) {
                $_SESSION['success'] = 'User account created successfully!';
                $this->redirect('admin/users');
                return;
            }

            $_SESSION['error'] = 'Failed to create user account. Please try again.';
            $this->view('admin/create_user', [
                'title' => 'Add User - ' . APP_NAME,
                'user' => $userData
            ]);
            return;
        }

        $this->view('admin/create_user', [
            'title' => 'Add User - ' . APP_NAME
        ]);
    }

    public function createPatron() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'role' => 'patron',
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->userModel->createUser($userData)) {
                $_SESSION['success'] = 'Patron account created successfully!';
                $this->redirect('admin/users');
            } else {
                $_SESSION['error'] = 'Failed to create patron account. Please try again.';
                $data = [
                    'title' => 'Create Patron - ' . APP_NAME,
                    'user' => $userData
                ];
                $this->view('admin/create_patron', $data);
            }
        } else {
            $data = [
                'title' => 'Create Patron - ' . APP_NAME
            ];
            $this->view('admin/create_patron', $data);
        }
    }

    public function editUser($id = null) {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        if (!$id) {
            $this->redirect('admin/users');
            return;
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            $this->redirect('admin/users');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'role' => trim($_POST['role']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Only update password if provided
            if (!empty($_POST['password'])) {
                $userData['password'] = trim($_POST['password']);
            }

            if ($this->userModel->updateUser($id, $userData)) {
                $_SESSION['success'] = 'User updated successfully!';
                $this->redirect('admin/users');
            } else {
                $_SESSION['error'] = 'Failed to update user. Please try again.';
                $data = [
                    'title' => 'Edit User - ' . APP_NAME,
                    'user' => array_merge($user, $userData)
                ];
                $this->view('admin/edit_user', $data);
            }
        } else {
            $data = [
                'title' => 'Edit User - ' . APP_NAME,
                'user' => $user
            ];
            $this->view('admin/edit_user', $data);
        }
    }

    public function projects() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        $data = [
            'title' => 'All Projects - ' . APP_NAME,
            'projects' => $this->projectModel->getAllProjectsWithDetails()
        ];

        $this->view('admin/projects', $data);
    }

    public function toggleUserStatus($id = null) {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        if (!$id) {
            $this->redirect('admin/users');
            return;
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            $this->redirect('admin/users');
            return;
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        if ($this->userModel->updateUser($id, ['is_active' => $newStatus])) {
            $_SESSION['success'] = 'User status updated successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update user status.';
        }

        $this->redirect('admin/users');
    }

    public function deleteUser($id = null) {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request method for deleting a user.';
            $this->redirect('admin/users');
            return;
        }

        if (!$id) {
            $this->redirect('admin/users');
            return;
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            $this->redirect('admin/users');
            return;
        }

        // Prevent admin from deleting themselves
        if ((int) $user['id'] === (int) $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot delete your own account.';
            $this->redirect('admin/users');
            return;
        }

        // Keep at least one admin in the system
        if (($user['role'] ?? '') === 'admin' && $this->userModel->countAdmins() <= 1) {
            $_SESSION['error'] = 'You cannot delete the last admin account.';
            $this->redirect('admin/users');
            return;
        }

        if ($this->userModel->hasUserReferences($id)) {
            $_SESSION['error'] = 'Cannot delete this user because they are referenced by events, projects, attendance, or uploaded files.';
            $this->redirect('admin/users');
            return;
        }

        if ($this->userModel->deleteUser($id)) {
            $_SESSION['success'] = 'User deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete user.';
        }

        $this->redirect('admin/users');
    }

    public function toggleMemberStatus($id = null) {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        if (!$id) {
            $this->redirect('admin/members');
            return;
        }

        $member = $this->memberModel->findById($id);
        if (!$member) {
            $_SESSION['error'] = 'Member not found.';
            $this->redirect('admin/members');
            return;
        }

        $newStatus = $member['status'] === 'active' ? 'inactive' : 'active';
        if ($this->memberModel->update($id, ['status' => $newStatus])) {
            $_SESSION['success'] = 'Member status updated successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update member status.';
        }

        $this->redirect('admin/members');
    }

    public function deleteMember($id = null) {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        if (!$id) {
            $this->redirect('admin/members');
            return;
        }

        $member = $this->memberModel->findById($id);
        if (!$member) {
            $_SESSION['error'] = 'Member not found.';
            $this->redirect('admin/members');
            return;
        }

        // Prevent admin from deleting themselves
        if ($member['user_id'] == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot delete your own account.';
            $this->redirect('admin/members');
            return;
        }

        if ($this->memberModel->delete($id)) {
            $_SESSION['success'] = 'Member deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete member.';
        }

        $this->redirect('admin/members');
    }

    public function deleteProject($id = null) {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'member') !== 'admin') {
            $this->redirect('dashboard');
            return;
        }

        if (!$id) {
            $this->redirect('admin/projects');
            return;
        }

        $project = $this->projectModel->findById($id);
        if (!$project) {
            $_SESSION['error'] = 'Project not found.';
            $this->redirect('admin/projects');
            return;
        }

        if ($this->projectModel->delete($id)) {
            $_SESSION['success'] = 'Project deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete project.';
        }

        $this->redirect('admin/projects');
    }

    private function getAdminStats() {
        return [
            'total_users' => $this->userModel->getTotalUsers(),
            'total_members' => $this->memberModel->getTotalMembers(),
            'total_projects' => $this->projectModel->getTotalProjects(),
            'active_projects' => $this->projectModel->getActiveProjectsCount(),
            'recent_registrations' => $this->memberModel->getRecentRegistrationsCount(30)
        ];
    }
}