<?php
class DashboardController extends Controller {
    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        $data = [
            'title' => 'Dashboard - ' . APP_NAME,
            'user' => [
                'name' => $_SESSION['username'] ?? 'Guest',
                'role' => $userRole
            ]
        ];

        // Add role-specific data
        switch ($userRole) {
            case 'admin':
                $data = array_merge($data, $this->getAdminData());
                $this->view('dashboard/admin', $data);
                break;
            case 'patron':
                $data = array_merge($data, $this->getPatronData());
                $this->view('dashboard/patron', $data);
                break;
            case 'member':
            default:
                $data = array_merge($data, $this->getMemberData());
                $this->view('dashboard/member', $data);
                break;
        }
    }

    private function getAdminData() {
        // Mock data for admin dashboard - in real app, this would come from database
        return [
            'stats' => [
                'total_members' => 45,
                'active_events' => 8,
                'active_projects' => 12,
                'pending_tasks' => 3
            ]
        ];
    }

    private function getPatronData() {
        // Mock data for patron dashboard
        return [
            'impact' => [
                'members_helped' => 120,
                'projects_supported' => 8,
                'events_sponsored' => 15
            ]
        ];
    }

    private function getMemberData() {
        // Mock data for member dashboard
        return [
            'progress' => [
                'active_projects' => 2,
                'events_attended' => 12,
                'achievements' => 5,
                'hours_contributed' => 45
            ]
        ];
    }
}
