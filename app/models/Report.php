<?php
class Report extends Model {
    protected $table = 'reports';

    public function getAttendanceReport($filters = []) {
        $startDate = $filters['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $filters['end_date'] ?? date('Y-m-d');
        $eventId = $filters['event_id'] ?? null;

        // Get total events in date range
        $eventQuery = "SELECT COUNT(*) as total_events FROM events WHERE event_date BETWEEN :start_date AND :end_date";
        $params = ['start_date' => $startDate, 'end_date' => $endDate];

        if ($eventId) {
            $eventQuery .= " AND id = :event_id";
            $params['event_id'] = $eventId;
        }

        $totalEvents = $this->db->fetchOne($eventQuery, $params)['total_events'];

        // Get attendance statistics
        $attendanceQuery = "
            SELECT
                COUNT(DISTINCT a.event_id) as events_with_attendance,
                COUNT(a.id) as total_attendance_records,
                AVG(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) * 100 as attendance_rate,
                SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) as total_present,
                SUM(CASE WHEN a.status = 'absent' THEN 1 ELSE 0 END) as total_absent,
                SUM(CASE WHEN a.status = 'late' THEN 1 ELSE 0 END) as total_late
            FROM attendance a
            INNER JOIN events e ON a.event_id = e.id
            WHERE e.event_date BETWEEN :start_date AND :end_date
        ";

        $attendanceStats = $this->db->fetchOne($attendanceQuery, ['start_date' => $startDate, 'end_date' => $endDate]);

        // Get attendance by event
        $eventAttendanceQuery = "
            SELECT
                e.title as event_title,
                e.event_date,
                COUNT(a.id) as total_registered,
                SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN a.status = 'absent' THEN 1 ELSE 0 END) as absent_count,
                SUM(CASE WHEN a.status = 'late' THEN 1 ELSE 0 END) as late_count,
                ROUND((SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) / COUNT(a.id)) * 100, 1) as attendance_rate
            FROM events e
            LEFT JOIN attendance a ON e.id = a.event_id
            WHERE e.event_date BETWEEN :start_date AND :end_date
            GROUP BY e.id, e.title, e.event_date
            ORDER BY e.event_date DESC
        ";

        $eventAttendance = $this->db->fetchAll($eventAttendanceQuery, ['start_date' => $startDate, 'end_date' => $endDate]);

        return [
            'summary' => [
                'total_events' => $totalEvents,
                'events_with_attendance' => $attendanceStats['events_with_attendance'] ?? 0,
                'total_attendance_records' => $attendanceStats['total_attendance_records'] ?? 0,
                'overall_attendance_rate' => round($attendanceStats['attendance_rate'] ?? 0, 1),
                'total_present' => $attendanceStats['total_present'] ?? 0,
                'total_absent' => $attendanceStats['total_absent'] ?? 0,
                'total_late' => $attendanceStats['total_late'] ?? 0
            ],
            'event_breakdown' => $eventAttendance,
            'filters' => $filters,
            'date_range' => ['start' => $startDate, 'end' => $endDate]
        ];
    }

    public function getEventsReport($filters = []) {
        $startDate = $filters['start_date'] ?? date('Y-m-d', strtotime('-90 days'));
        $endDate = $filters['end_date'] ?? date('Y-m-d');
        $eventType = $filters['event_type'] ?? null;

        // Base query for events
        $eventQuery = "
            SELECT
                COUNT(*) as total_events,
                SUM(CASE WHEN event_date >= CURDATE() THEN 1 ELSE 0 END) as upcoming_events,
                SUM(CASE WHEN event_date < CURDATE() THEN 1 ELSE 0 END) as completed_events,
                AVG(CASE WHEN max_participants > 0 THEN max_participants ELSE NULL END) as avg_capacity
            FROM events
            WHERE event_date BETWEEN :start_date AND :end_date
        ";

        $params = ['start_date' => $startDate, 'end_date' => $endDate];

        if ($eventType) {
            $eventQuery .= " AND event_type = :event_type";
            $params['event_type'] = $eventType;
        }

        $eventStats = $this->db->fetchOne($eventQuery, $params);

        // Get events by type
        $typeQuery = "
            SELECT
                event_type,
                COUNT(*) as count,
                AVG(CASE WHEN max_participants > 0 THEN max_participants ELSE NULL END) as avg_capacity
            FROM events
            WHERE event_date BETWEEN :start_date AND :end_date
            GROUP BY event_type
            ORDER BY count DESC
        ";

        $eventsByType = $this->db->fetchAll($typeQuery, ['start_date' => $startDate, 'end_date' => $endDate]);

        // Get recent events with attendance
        $recentEventsQuery = "
            SELECT
                e.title,
                e.event_type,
                e.event_date,
                e.max_participants,
                COUNT(a.id) as registered_count,
                ROUND((COUNT(a.id) / NULLIF(e.max_participants, 0)) * 100, 1) as registration_rate
            FROM events e
            LEFT JOIN event_registrations a ON e.id = a.event_id
            WHERE e.event_date BETWEEN :start_date AND :end_date
            GROUP BY e.id, e.title, e.event_type, e.event_date, e.max_participants
            ORDER BY e.event_date DESC
            LIMIT 20
        ";

        $recentEvents = $this->db->fetchAll($recentEventsQuery, ['start_date' => $startDate, 'end_date' => $endDate]);

        return [
            'summary' => [
                'total_events' => $eventStats['total_events'] ?? 0,
                'upcoming_events' => $eventStats['upcoming_events'] ?? 0,
                'completed_events' => $eventStats['completed_events'] ?? 0,
                'average_capacity' => round($eventStats['avg_capacity'] ?? 0, 1)
            ],
            'events_by_type' => $eventsByType,
            'recent_events' => $recentEvents,
            'filters' => $filters,
            'date_range' => ['start' => $startDate, 'end' => $endDate]
        ];
    }

    public function getMembersReport($filters = []) {
        $department = $filters['department'] ?? null;
        $status = $filters['status'] ?? null;

        // Base member statistics
        $memberQuery = "
            SELECT
                COUNT(*) as total_members,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_members,
                SUM(CASE WHEN join_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as new_this_month,
                SUM(CASE WHEN join_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as new_this_week
            FROM members
            WHERE 1=1
        ";

        $params = [];

        if ($department) {
            $memberQuery .= " AND department = :department";
            $params['department'] = $department;
        }

        if ($status) {
            $memberQuery .= " AND status = :status";
            $params['status'] = $status;
        }

        $memberStats = $this->db->fetchOne($memberQuery, $params);

        // Members by department
        $deptQuery = "
            SELECT
                department,
                COUNT(*) as count,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_count
            FROM members
            WHERE department IS NOT NULL AND department != ''
            GROUP BY department
            ORDER BY count DESC
        ";

        $membersByDept = $this->db->fetchAll($deptQuery);

        // Members by year of study
        $yearQuery = "
            SELECT
                year_of_study,
                COUNT(*) as count
            FROM members
            WHERE year_of_study IS NOT NULL AND year_of_study != ''
            GROUP BY year_of_study
            ORDER BY year_of_study
        ";

        $membersByYear = $this->db->fetchAll($yearQuery);

        // Recent members
        $recentQuery = "
            SELECT
                full_name,
                student_id,
                department,
                join_date,
                status
            FROM members
            ORDER BY join_date DESC
            LIMIT 10
        ";

        $recentMembers = $this->db->fetchAll($recentQuery);

        return [
            'summary' => [
                'total_members' => $memberStats['total_members'] ?? 0,
                'active_members' => $memberStats['active_members'] ?? 0,
                'new_this_month' => $memberStats['new_this_month'] ?? 0,
                'new_this_week' => $memberStats['new_this_week'] ?? 0,
                'inactive_members' => ($memberStats['total_members'] ?? 0) - ($memberStats['active_members'] ?? 0)
            ],
            'by_department' => $membersByDept,
            'by_year' => $membersByYear,
            'recent_members' => $recentMembers,
            'filters' => $filters
        ];
    }

    public function getProjectsReport($filters = []) {
        $status = $filters['status'] ?? null;
        $category = $filters['category'] ?? null;

        // Project statistics
        $projectQuery = "
            SELECT
                COUNT(*) as total_projects,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_projects,
                SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as active_projects,
                SUM(CASE WHEN status = 'idea' THEN 1 ELSE 0 END) as planned_projects,
                AVG(CASE WHEN actual_end_date IS NOT NULL AND start_date IS NOT NULL
                         THEN DATEDIFF(actual_end_date, start_date) ELSE NULL END) as avg_completion_days
            FROM projects
            WHERE 1=1
        ";

        $params = [];

        if ($status) {
            $projectQuery .= " AND status = :status";
            $params['status'] = $status;
        }

        if ($category) {
            $projectQuery .= " AND category = :category";
            $params['category'] = $category;
        }

        $projectStats = $this->db->fetchOne($projectQuery, $params);

        // Projects by status
        $statusQuery = "
            SELECT
                status,
                COUNT(*) as count,
                AVG(CASE WHEN budget > 0 THEN budget ELSE NULL END) as avg_budget
            FROM projects
            GROUP BY status
            ORDER BY count DESC
        ";

        $projectsByStatus = $this->db->fetchAll($statusQuery);

        // Projects by category
        $categoryQuery = "
            SELECT
                category,
                COUNT(*) as count,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_count
            FROM projects
            WHERE category IS NOT NULL AND category != ''
            GROUP BY category
            ORDER BY count DESC
        ";

        $projectsByCategory = $this->db->fetchAll($categoryQuery);

        // Recent projects
        $recentQuery = "
            SELECT
                title,
                category,
                status,
                start_date,
                expected_end_date,
                budget
            FROM projects
            ORDER BY start_date DESC
            LIMIT 10
        ";

        $recentProjects = $this->db->fetchAll($recentQuery);

        return [
            'summary' => [
                'total_projects' => $projectStats['total_projects'] ?? 0,
                'completed_projects' => $projectStats['completed_projects'] ?? 0,
                'active_projects' => $projectStats['active_projects'] ?? 0,
                'planned_projects' => $projectStats['planned_projects'] ?? 0,
                'avg_completion_days' => round($projectStats['avg_completion_days'] ?? 0, 1)
            ],
            'by_status' => $projectsByStatus,
            'by_category' => $projectsByCategory,
            'recent_projects' => $recentProjects,
            'filters' => $filters
        ];
    }

    public function exportReport($type, $data, $format = 'csv') {
        $filename = $type . '_report_' . date('Y-m-d_H-i-s');

        if ($format === 'csv') {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

            $output = fopen('php://output', 'w');

            // Add headers based on report type
            switch ($type) {
                case 'attendance':
                    fputcsv($output, ['Event Title', 'Date', 'Total Registered', 'Present', 'Absent', 'Late', 'Attendance Rate (%)']);
                    foreach ($data['event_breakdown'] as $row) {
                        fputcsv($output, [
                            $row['event_title'],
                            $row['event_date'],
                            $row['total_registered'],
                            $row['present_count'],
                            $row['absent_count'],
                            $row['late_count'],
                            $row['attendance_rate']
                        ]);
                    }
                    break;

                case 'events':
                    fputcsv($output, ['Event Title', 'Type', 'Date', 'Capacity', 'Registered', 'Registration Rate (%)']);
                    foreach ($data['recent_events'] as $row) {
                        fputcsv($output, [
                            $row['title'],
                            $row['event_type'],
                            $row['event_date'],
                            $row['max_participants'],
                            $row['registered_count'],
                            $row['registration_rate']
                        ]);
                    }
                    break;

                case 'members':
                    fputcsv($output, ['Name', 'Student ID', 'Department', 'Join Date', 'Status']);
                    foreach ($data['recent_members'] as $row) {
                        fputcsv($output, [
                            $row['full_name'],
                            $row['student_id'],
                            $row['department'],
                            $row['join_date'],
                            $row['status']
                        ]);
                    }
                    break;

                case 'projects':
                    fputcsv($output, ['Title', 'Category', 'Status', 'Start Date', 'Expected End Date', 'Budget']);
                    foreach ($data['recent_projects'] as $row) {
                        fputcsv($output, [
                            $row['title'],
                            $row['category'],
                            $row['status'],
                            $row['start_date'],
                            $row['expected_end_date'],
                            $row['budget']
                        ]);
                    }
                    break;
            }

            fclose($output);
            exit;
        }
    }
}