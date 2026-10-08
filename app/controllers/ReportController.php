<?php
class ReportController extends Controller {
    private $reportModel;

    public function __construct() {
        require_once APP_PATH . '/models/Report.php';
        $this->reportModel = new Report();
    }

    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $data = [
            'title' => 'Reports - ' . APP_NAME,
            'reports' => $this->getReports()
        ];

        $this->view('reports/index', $data);
    }

    public function attendance() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        // Handle export request
        if (isset($_GET['export'])) {
            $filters = $this->getFiltersFromRequest();
            $data = $this->reportModel->getAttendanceReport($filters);
            $this->reportModel->exportReport('attendance', $data, $_GET['export']);
            return;
        }

        $filters = $this->getFiltersFromRequest();
        $data = [
            'title' => 'Attendance Report - ' . APP_NAME,
            'report_data' => $this->reportModel->getAttendanceReport($filters),
            'filters' => $filters
        ];

        $this->view('reports/attendance', $data);
    }

    public function events() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        // Handle export request
        if (isset($_GET['export'])) {
            $filters = $this->getFiltersFromRequest();
            $data = $this->reportModel->getEventsReport($filters);
            $this->reportModel->exportReport('events', $data, $_GET['export']);
            return;
        }

        $filters = $this->getFiltersFromRequest();
        $data = [
            'title' => 'Events Report - ' . APP_NAME,
            'report_data' => $this->reportModel->getEventsReport($filters),
            'filters' => $filters
        ];

        $this->view('reports/events', $data);
    }

    public function members() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        // Handle export request
        if (isset($_GET['export'])) {
            $filters = $this->getFiltersFromRequest();
            $data = $this->reportModel->getMembersReport($filters);
            $this->reportModel->exportReport('members', $data, $_GET['export']);
            return;
        }

        $filters = $this->getFiltersFromRequest();
        $data = [
            'title' => 'Members Report - ' . APP_NAME,
            'report_data' => $this->reportModel->getMembersReport($filters),
            'filters' => $filters
        ];

        $this->view('reports/members', $data);
    }

    public function projects() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        // Handle export request
        if (isset($_GET['export'])) {
            $filters = $this->getFiltersFromRequest();
            $data = $this->reportModel->getProjectsReport($filters);
            $this->reportModel->exportReport('projects', $data, $_GET['export']);
            return;
        }

        $filters = $this->getFiltersFromRequest();
        $data = [
            'title' => 'Projects Report - ' . APP_NAME,
            'report_data' => $this->reportModel->getProjectsReport($filters),
            'filters' => $filters
        ];

        $this->view('reports/projects', $data);
    }

    private function getFiltersFromRequest() {
        return [
            'start_date' => $_GET['start_date'] ?? null,
            'end_date' => $_GET['end_date'] ?? null,
            'event_type' => $_GET['event_type'] ?? null,
            'department' => $_GET['department'] ?? null,
            'status' => $_GET['status'] ?? null,
            'category' => $_GET['category'] ?? null,
            'event_id' => $_GET['event_id'] ?? null
        ];
    }

    private function getReports() {
        return [
            [
                'title' => 'Attendance Report',
                'description' => 'View attendance statistics and trends',
                'url' => BASE_URL . '/reports/attendance',
                'icon' => 'fas fa-user-check',
                'color' => 'primary'
            ],
            [
                'title' => 'Events Report',
                'description' => 'Analyze event participation and feedback',
                'url' => BASE_URL . '/reports/events',
                'icon' => 'fas fa-calendar-alt',
                'color' => 'success'
            ],
            [
                'title' => 'Members Report',
                'description' => 'Member statistics and demographics',
                'url' => BASE_URL . '/reports/members',
                'icon' => 'fas fa-users',
                'color' => 'info'
            ],
            [
                'title' => 'Projects Report',
                'description' => 'Project progress and outcomes',
                'url' => BASE_URL . '/reports/projects',
                'icon' => 'fas fa-tasks',
                'color' => 'warning'
            ]
        ];
    }
}