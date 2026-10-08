<?php
class DashboardController extends Controller {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

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
        // Get real data from database
        $stats = [];

        // Total active members
        $memberQuery = "SELECT COUNT(*) as count FROM members WHERE status = 'active'";
        $result = $this->db->fetchOne($memberQuery);
        $stats['total_members'] = $result['count'];

        // Active events (scheduled or ongoing, upcoming)
        $eventQuery = "SELECT COUNT(*) as count FROM events WHERE status IN ('scheduled', 'ongoing') AND event_date >= CURDATE()";
        $result = $this->db->fetchOne($eventQuery);
        $stats['active_events'] = $result['count'];

        // Active projects (planning or in progress)
        $projectQuery = "SELECT COUNT(*) as count FROM projects WHERE status IN ('planning', 'in_progress')";
        $result = $this->db->fetchOne($projectQuery);
        $stats['active_projects'] = $result['count'];

        // Pending tasks (for now, let's count projects that need attention - could be expanded)
        $pendingQuery = "SELECT COUNT(*) as count FROM projects WHERE status = 'idea' OR (status = 'on_hold' AND expected_end_date < CURDATE())";
        $result = $this->db->fetchOne($pendingQuery);
        $stats['pending_tasks'] = $result['count'];

        // Recent activities (last 5 activities)
        $activitiesQuery = "
            SELECT 'member_joined' as type, full_name as title, 'joined the club' as description, created_at as date
            FROM members
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            UNION ALL
            SELECT 'event_created' as type, title, 'event scheduled' as description, created_at as date
            FROM events
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            UNION ALL
            SELECT 'project_created' as type, title, 'project started' as description, created_at as date
            FROM projects
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            ORDER BY date DESC
            LIMIT 5
        ";
        $activities = $this->db->fetchAll($activitiesQuery);

        // Format activities for display
        $formattedActivities = [];
        foreach ($activities as $activity) {
            $formattedActivities[] = [
                'title' => $activity['title'] . ' ' . $activity['description'],
                'time' => $this->timeAgo($activity['date'])
            ];
        }

        // Upcoming events (next 3 events)
        $upcomingQuery = "
            SELECT title, description, event_date, start_time, end_time
            FROM events
            WHERE event_date >= CURDATE() AND status IN ('scheduled', 'ongoing')
            ORDER BY event_date ASC, start_time ASC
            LIMIT 3
        ";
        $upcomingEvents = $this->db->fetchAll($upcomingQuery);

        return [
            'stats' => $stats,
            'recent_activities' => $formattedActivities,
            'upcoming_events' => $upcomingEvents
        ];
    }

    private function timeAgo($datetime) {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        } elseif ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        } elseif ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        } elseif ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
        }
    }

    private function getPatronData() {
        // Get real data for patron dashboard
        $impact = [];

        // Members helped (total active members)
        $memberQuery = "SELECT COUNT(*) as count FROM members WHERE status = 'active'";
        $result = $this->db->fetchOne($memberQuery);
        $impact['members_helped'] = $result['count'];

        // Projects supported (total projects)
        $projectQuery = "SELECT COUNT(*) as count FROM projects";
        $result = $this->db->fetchOne($projectQuery);
        $impact['projects_supported'] = $result['count'];

        // Events sponsored (total events)
        $eventQuery = "SELECT COUNT(*) as count FROM events";
        $result = $this->db->fetchOne($eventQuery);
        $impact['events_sponsored'] = $result['count'];

        return [
            'impact' => $impact
        ];
    }

    private function getMemberData() {
        // Get real data for member dashboard
        $userId = $_SESSION['user_id'];
        $progress = [];

        // Get member ID first
        $memberId = $this->db->fetchOne("SELECT id FROM members WHERE user_id = :user_id", ['user_id' => $userId])['id'] ?? null;

        // Active projects for this member (as team member OR lead)
        if ($memberId) {
            $projectQuery = "
                SELECT COUNT(DISTINCT p.id) as count
                FROM projects p
                LEFT JOIN project_members pm ON p.id = pm.project_id
                WHERE (pm.member_id = ? OR p.lead_member_id = ?)
                AND p.status IN ('planning', 'in_progress')
            ";
            $result = $this->db->fetchOne($projectQuery, [$memberId, $memberId]);
            $progress['active_projects'] = $result['count'];
        } else {
            $progress['active_projects'] = 0;
        }

        // Events attended
        $attendanceQuery = "
            SELECT COUNT(*) as count
            FROM attendance a
            JOIN members m ON a.member_id = m.id
            WHERE m.user_id = :user_id AND a.status = 'present'
        ";
        $result = $this->db->fetchOne($attendanceQuery, ['user_id' => $userId]);
        $progress['events_attended'] = $result['count'];

        // Achievements (for now, use events attended as proxy)
        $progress['achievements'] = $progress['events_attended'];

        // Hours contributed (estimate based on events attended)
        $progress['hours_contributed'] = $progress['events_attended'] * 2; // Assume 2 hours per event

        // Get member's projects (as lead or team member)
        if ($memberId) {
            $projectsQuery = "
                SELECT DISTINCT p.*, m.full_name as lead_name,
                       CASE
                           WHEN p.lead_member_id = ? THEN 'Lead'
                           ELSE COALESCE(pm.role, 'Member')
                       END as member_role,
                       (SELECT COUNT(*) FROM project_members WHERE project_id = p.id) + 1 as team_count
                FROM projects p
                LEFT JOIN members m ON p.lead_member_id = m.id
                LEFT JOIN project_members pm ON p.id = pm.project_id AND pm.member_id = ?
                WHERE p.lead_member_id = ?
                   OR pm.member_id = ?
                ORDER BY p.created_at DESC
                LIMIT 3
            ";
            $projects = $this->db->fetchAll($projectsQuery, [$memberId, $memberId, $memberId, $memberId]);
        } else {
            $projects = [];
        }

        return [
            'progress' => $progress,
            'projects' => $projects
        ];
    }
}
