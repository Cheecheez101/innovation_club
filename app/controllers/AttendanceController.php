<?php
class AttendanceController {

    private const VALID_STATUSES = ['present', 'absent', 'late'];

    public function mark() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $event_id  = (int) ($_POST['event_id']  ?? 0);
        $member_id = (int) ($_POST['member_id'] ?? 0);
        $status    = $_POST['status'] ?? '';

        // Validate status against allowed ENUM values
        if (!in_array($status, self::VALID_STATUSES, true)) {
            $_SESSION['error'] = 'Invalid attendance status';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $db = Database::getInstance();

        // Check if member is registered for this event
        $checkSql = "SELECT * FROM event_registrations 
                     WHERE event_id = :event_id AND member_id = :member_id";
        $registered = $db->fetchOne($checkSql, [
            'event_id'  => $event_id,
            'member_id' => $member_id,
        ]);

        if (!$registered) {
            $_SESSION['error'] = 'Member not registered for this event';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Check for an existing attendance record to avoid duplicates
        $existsSql = "SELECT id FROM attendance 
                      WHERE event_id = :event_id AND member_id = :member_id";
        $existing = $db->fetchOne($existsSql, [
            'event_id'  => $event_id,
            'member_id' => $member_id,
        ]);

        if ($existing) {
            // Update the existing record instead of inserting a duplicate
            $db->update(
                'attendance',
                ['status' => $status, 'marked_by' => $_SESSION['user_id']],
                'event_id = ? AND member_id = ?',
                [$event_id, $member_id]
            );
        } else {
            $db->insert('attendance', [
                'event_id'  => $event_id,
                'member_id' => $member_id,
                'status'    => $status,
                'marked_by' => $_SESSION['user_id'],
            ]);
        }

        $_SESSION['success'] = 'Attendance marked successfully';
        // PRG: redirect to prevent duplicate submission on refresh
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
