<?php
class MemberController extends Controller {
    private $memberModel;
    
    public function __construct() {
        parent::__construct();
        require_once APP_PATH . '/models/Member.php';
        $this->memberModel = new Member();
        $this->requirePatron(); // Only patrons and admins can manage members
    }
    
    public function index() {
        $members = $this->memberModel->findAll();
        
        $data = [
            'title' => 'Manage Members',
            'members' => $members
        ];
        
        $this->view('members/index', $data);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $memberData = [
                'full_name' => trim($_POST['full_name']),
                'student_id' => trim($_POST['student_id']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'department' => trim($_POST['department']),
                'year_of_study' => trim($_POST['year_of_study']),
                'join_date' => date('Y-m-d')
            ];
            
            if ($this->memberModel->create($memberData)) {
                $_SESSION['success'] = 'Member added successfully!';
                $this->redirect('members');
            } else {
                $_SESSION['error'] = 'Failed to add member';
                $this->view('members/create', ['title' => 'Add New Member']);
            }
        } else {
            $this->view('members/create', ['title' => 'Add New Member']);
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
                'phone' => trim($_POST['phone']),
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
}
