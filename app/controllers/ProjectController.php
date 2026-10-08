<?php
class ProjectController extends Controller {
    private $projectModel;
    private $projectFileModel;

    public function __construct() {
        require_once APP_PATH . '/models/Project.php';
        require_once APP_PATH . '/models/ProjectFile.php';
        $this->projectModel = new Project();
        $this->projectFileModel = new ProjectFile();
    }

    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        if ($userRole === 'admin' || $userRole === 'patron') {
            // Admins and patrons can see all projects
            $projects = $this->projectModel->getAllProjects();
        } else {
            // Members can only see their own projects (where they are lead or member)
            $projects = $this->projectModel->getProjectsByUser($_SESSION['user_id']);
        }

        $userRole = $_SESSION['role'] ?? 'member';
        $memberId = null;

        if ($userRole === 'member') {
            $memberId = $this->projectModel->getMemberIdByUserId($_SESSION['user_id']);
        }

        $data = [
            'title' => 'Projects - ' . APP_NAME,
            'projects' => $projects,
            'userRole' => $userRole,
            'memberId' => $memberId
        ];

        $this->view('projects/index', $data);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectData = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'objectives' => trim($_POST['objectives'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'status' => trim($_POST['status'] ?? 'idea'),
                'start_date' => trim($_POST['start_date'] ?? null),
                'expected_end_date' => trim($_POST['expected_end_date'] ?? null),
                'budget' => trim($_POST['budget'] ?? 0)
            ];

            // For members, automatically set them as the lead member
            if ($userRole === 'member') {
                // Get member ID from user ID
                $memberId = $this->projectModel->getMemberIdByUserId($_SESSION['user_id']);
                if ($memberId) {
                    $projectData['lead_member_id'] = $memberId;
                }
            } else {
                $projectData['lead_member_id'] = trim($_POST['lead_member_id'] ?? null);
                $projectData['supervisor_id'] = trim($_POST['supervisor_id'] ?? null);

                // Validate lead_member_id exists in members table (allow null)
                $db = Database::getInstance();
                if (!empty($projectData['lead_member_id'])) {
                    $leadCheck = $db->fetchOne("SELECT id FROM members WHERE id = ?", [ (int)$projectData['lead_member_id'] ]);
                    if (!$leadCheck) {
                        $_SESSION['error'] = 'Selected lead member does not exist.';
                        $data = [
                            'title' => 'Create Project - ' . APP_NAME,
                            'project' => $projectData,
                            'userRole' => $userRole
                        ];
                        $this->view('projects/create', $data);
                        return;
                    }
                } else {
                    $projectData['lead_member_id'] = null;
                }

                // Validate supervisor_id exists in users table (allow null)
                if (!empty($projectData['supervisor_id'])) {
                    $supCheck = $db->fetchOne("SELECT id FROM users WHERE id = ?", [ (int)$projectData['supervisor_id'] ]);
                    if (!$supCheck) {
                        $_SESSION['error'] = 'Selected supervisor does not exist.';
                        $data = [
                            'title' => 'Create Project - ' . APP_NAME,
                            'project' => $projectData,
                            'userRole' => $userRole
                        ];
                        $this->view('projects/create', $data);
                        return;
                    }
                } else {
                    $projectData['supervisor_id'] = null;
                }
            }

            // Handle file uploads
            $uploadedFiles = [];
            if (isset($_FILES['project_files']) && !empty($_FILES['project_files']['name'][0])) {
                $uploadDir = APP_PATH . '/storage/uploads/projects/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $allowedTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'zip', 'rar'];
                $maxSize = 10 * 1024 * 1024; // 10MB

                foreach ($_FILES['project_files']['name'] as $key => $filename) {
                    if ($_FILES['project_files']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileTmp = $_FILES['project_files']['tmp_name'][$key];
                        $fileSize = $_FILES['project_files']['size'][$key];
                        $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                        if (!in_array($fileExt, $allowedTypes)) {
                            $_SESSION['error'] = "File type not allowed: $filename";
                            $data = [
                                'title' => 'Create Project - ' . APP_NAME,
                                'project' => $projectData,
                                'userRole' => $userRole
                            ];
                            $this->view('projects/create', $data);
                            return;
                        }

                        if ($fileSize > $maxSize) {
                            $_SESSION['error'] = "File too large: $filename (max 10MB)";
                            $data = [
                                'title' => 'Create Project - ' . APP_NAME,
                                'project' => $projectData,
                                'userRole' => $userRole
                            ];
                            $this->view('projects/create', $data);
                            return;
                        }

                        $newFilename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
                        $filePath = $uploadDir . $newFilename;

                        if (move_uploaded_file($fileTmp, $filePath)) {
                            $uploadedFiles[] = [
                                'original_name' => $filename,
                                'filename' => $newFilename,
                                'path' => $filePath,
                                'size' => $fileSize,
                                'type' => $fileExt
                            ];
                        }
                    }
                }
            }

            try {
                $projectId = $this->projectModel->createProject($projectData);
            } catch (PDOException $e) {
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, '1452') !== false) {
                    $_SESSION['error'] = 'Invalid project lead or supervisor selected.';
                } else {
                    $_SESSION['error'] = 'Failed to create project. Please try again.';
                }
                $data = [
                    'title' => 'Create Project - ' . APP_NAME,
                    'project' => $projectData,
                    'userRole' => $userRole
                ];
                $this->view('projects/create', $data);
                return;
            }

            if ($projectId) {

                // Save uploaded files info if any
                if (!empty($uploadedFiles)) {
                    foreach ($uploadedFiles as $file) {
                        $fileData = [
                            'project_id' => $projectId,
                            'filename' => $file['filename'],
                            'original_name' => $file['original_name'],
                            'file_path' => str_replace(APP_PATH, '', $file['path']),
                            'file_size' => $file['size'],
                            'file_type' => $file['type'],
                            'uploaded_by' => $_SESSION['user_id']
                        ];
                        $this->projectFileModel->createFile($fileData);
                    }
                }

                $_SESSION['success'] = 'Project created successfully!';
                $this->redirect('projects');
            } else {
                $_SESSION['error'] = 'Failed to create project. Please try again.';
                $data = [
                    'title' => 'Create Project - ' . APP_NAME,
                    'project' => $projectData,
                    'userRole' => $userRole
                ];
                $this->view('projects/create', $data);
            }
        } else {
            $data = [
                'title' => 'Create Project - ' . APP_NAME,
                'userRole' => $userRole
            ];
            $this->view('projects/create', $data);
        }
    }

    public function edit($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if (!$id) {
            $this->redirect('projects');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';
        $project = $this->projectModel->getProjectById($id);

        if (!$project) {
            $_SESSION['error'] = 'Project not found.';
            $this->redirect('projects');
            return;
        }

        // Check if user has permission to edit this project
        if ($userRole === 'member') {
            $memberId = $this->projectModel->getMemberIdByUserId($_SESSION['user_id']);
            if ($project['lead_member_id'] != $memberId) {
                $_SESSION['error'] = 'You do not have permission to edit this project.';
                $this->redirect('projects');
                return;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectData = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'objectives' => trim($_POST['objectives'] ?? ''),
                'category' => trim($_POST['category'] ?? ''),
                'status' => trim($_POST['status'] ?? 'idea'),
                'start_date' => trim($_POST['start_date'] ?? null),
                'expected_end_date' => trim($_POST['expected_end_date'] ?? null),
                'budget' => trim($_POST['budget'] ?? 0),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Only admins/patrons can change lead member and supervisor
            if ($userRole !== 'member') {
                $projectData['lead_member_id'] = trim($_POST['lead_member_id'] ?? null);
                $projectData['supervisor_id'] = trim($_POST['supervisor_id'] ?? null);

                // Validate lead_member_id exists in members table (allow null)
                $db = Database::getInstance();
                if (!empty($projectData['lead_member_id'])) {
                    $leadCheck = $db->fetchOne("SELECT id FROM members WHERE id = ?", [ (int)$projectData['lead_member_id'] ]);
                    if (!$leadCheck) {
                        $_SESSION['error'] = 'Selected lead member does not exist.';
                        $data = [
                            'title' => 'Edit Project - ' . APP_NAME,
                            'project' => array_merge($project, $projectData),
                            'userRole' => $userRole
                        ];
                        $this->view('projects/edit', $data);
                        return;
                    }
                } else {
                    $projectData['lead_member_id'] = null;
                }

                // Validate supervisor_id exists in users table (allow null)
                if (!empty($projectData['supervisor_id'])) {
                    $supCheck = $db->fetchOne("SELECT id FROM users WHERE id = ?", [ (int)$projectData['supervisor_id'] ]);
                    if (!$supCheck) {
                        $_SESSION['error'] = 'Selected supervisor does not exist.';
                        $data = [
                            'title' => 'Edit Project - ' . APP_NAME,
                            'project' => array_merge($project, $projectData),
                            'userRole' => $userRole
                        ];
                        $this->view('projects/edit', $data);
                        return;
                    }
                } else {
                    $projectData['supervisor_id'] = null;
                }
            }

            try {
                $updated = $this->projectModel->updateProject($id, $projectData);
            } catch (PDOException $e) {
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, '1452') !== false) {
                    $_SESSION['error'] = 'Invalid project lead or supervisor selected.';
                } else {
                    $_SESSION['error'] = 'Failed to update project. Please try again.';
                }
                $data = [
                    'title' => 'Edit Project - ' . APP_NAME,
                    'project' => array_merge($project, $projectData),
                    'userRole' => $userRole
                ];
                $this->view('projects/edit', $data);
                return;
            }

            if ($updated === false) {
                // Filtered data empty or other failure
                $_SESSION['error'] = 'Failed to update project. Please try again.';
                $data = [
                    'title' => 'Edit Project - ' . APP_NAME,
                    'project' => array_merge($project, $projectData),
                    'userRole' => $userRole
                ];
                $this->view('projects/edit', $data);
            } elseif ($updated === 0) {
                // No rows changed — nothing to update
                $_SESSION['info'] = 'No changes detected.';
                $this->redirect('projects/show/' . $id);
            } elseif ($updated > 0) {
                $_SESSION['success'] = 'Project updated successfully!';
                $this->redirect('projects/show/' . $id);
            } else {
                // Unexpected result
                $_SESSION['error'] = 'Failed to update project. Please try again.';
                $data = [
                    'title' => 'Edit Project - ' . APP_NAME,
                    'project' => array_merge($project, $projectData),
                    'userRole' => $userRole
                ];
                $this->view('projects/edit', $data);
            }
        } else {
            $data = [
                'title' => 'Edit Project - ' . APP_NAME,
                'project' => $project,
                'userRole' => $userRole
            ];
            $this->view('projects/edit', $data);
        }
    }

    public function show($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if (!$id) {
            $this->redirect('projects');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';
        $project = $this->projectModel->getProjectById($id);

        if (!$project) {
            $_SESSION['error'] = 'Project not found.';
            $this->redirect('projects');
            return;
        }

        // Check if user has permission to view this project
        $memberId = null;
        $canManage = ($userRole === 'admin' || $userRole === 'patron');
        if ($userRole === 'member') {
            $memberId = $this->projectModel->getMemberIdByUserId($_SESSION['user_id']);
            // Allow viewing if user is the lead OR a team member
            $isLead = ($project['lead_member_id'] == $memberId);
            $isTeamMember = $this->projectModel->isUserTeamMember($id, $_SESSION['user_id']);
            $canManage = $isLead;

            if (!$isLead && !$isTeamMember) {
                $_SESSION['error'] = 'You do not have permission to view this project.';
                $this->redirect('projects');
                return;
            }
        }

        $data = [
            'title' => 'View Project - ' . APP_NAME,
            'project' => $project,
            'userRole' => $userRole,
            'memberId' => $memberId,
            'canManage' => $canManage,
            'projectFiles' => $this->projectFileModel->getFilesByProjectId($id)
        ];

        $this->view('projects/view', $data);
    }

    public function delete($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if (!$id) {
            $this->redirect('projects');
            return;
        }

        $project = $this->projectModel->getProjectById($id);
        if (!$project) {
            $_SESSION['error'] = 'Project not found.';
            $this->redirect('projects');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';
        $canDelete = ($userRole === 'admin' || $userRole === 'patron');

        if (!$canDelete && $userRole === 'member') {
            $memberId = $this->projectModel->getMemberIdByUserId($_SESSION['user_id']);
            $canDelete = ($memberId && (int)$project['lead_member_id'] === (int)$memberId);
        }

        if (!$canDelete) {
            $_SESSION['error'] = 'You do not have permission to delete this project.';
            $this->redirect('projects/show/' . $id);
            return;
        }

        if ($this->projectModel->deleteProject($id)) {
            $_SESSION['success'] = 'Project deleted successfully!';
            $this->redirect('projects');
            return;
        }

        $_SESSION['error'] = 'Failed to delete project. Please try again.';
        $this->redirect('projects/show/' . $id);
    }
}