<?php
class Event extends Model {
    protected $table = 'events';
    private $tableColumns = null;

    private function getTableColumns() {
        if ($this->tableColumns !== null) {
            return $this->tableColumns;
        }

        $columns = $this->db->fetchAll("SHOW COLUMNS FROM {$this->table}");
        $this->tableColumns = array_column($columns, 'Field');

        return $this->tableColumns;
    }

    private function filterDataForCurrentSchema($data) {
        $allowedColumns = array_flip($this->getTableColumns());
        return array_intersect_key($data, $allowedColumns);
    }

    public function getAllEvents() {
        $sql = "SELECT * FROM {$this->table} ORDER BY event_date DESC, start_time DESC";
        return $this->db->fetchAll($sql);
    }

    public function getEventById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getUpcomingEvents() {
        $sql = "SELECT * FROM {$this->table} WHERE event_date >= CURDATE() ORDER BY event_date ASC, start_time ASC";
        return $this->db->fetchAll($sql);
    }

    public function getEventsByUser($userId) {
        $sql = "SELECT * FROM {$this->table} WHERE created_by = ? ORDER BY event_date DESC";
        return $this->db->fetchAll($sql, [$userId]);
    }

    public function createEvent($data) {
        $filteredData = $this->filterDataForCurrentSchema($data);
        if (empty($filteredData)) {
            return false;
        }

        return parent::create($filteredData);
    }

    public function updateEvent($id, $data) {
        $filteredData = $this->filterDataForCurrentSchema($data);
        if (empty($filteredData)) {
            return false;
        }

        return parent::update($id, $filteredData);
    }

    public function deleteEvent($id) {
        return parent::delete($id);
    }

    public function getEventsByDateRange($startDate, $endDate) {
        $sql = "SELECT * FROM {$this->table} WHERE event_date BETWEEN ? AND ? ORDER BY event_date ASC";
        return $this->db->fetchAll($sql, [$startDate, $endDate]);
    }

    public function getEventsByType($type) {
        $sql = "SELECT * FROM {$this->table} WHERE event_type = ? ORDER BY event_date DESC";
        return $this->db->fetchAll($sql, [$type]);
    }

    public function registerForEvent($data) {
        // Convert user_id to member_id
        if (isset($data['user_id'])) {
            $memberSql = "SELECT id FROM members WHERE user_id = ?";
            $member = $this->db->fetchOne($memberSql, [$data['user_id']]);
            if ($member) {
                $data['member_id'] = $member['id'];
                unset($data['user_id']);
            } else {
                return false; // User is not a member
            }
        }

        $sql = "INSERT INTO event_registrations (event_id, member_id, registered_at) VALUES (?, ?, ?)";
        $stmt = $this->db->query($sql, [$data['event_id'], $data['member_id'], $data['registered_at']]);
        return $stmt !== false;
    }

    public function unregisterFromEvent($eventId, $userId) {
        // Convert user_id to member_id
        $memberSql = "SELECT id FROM members WHERE user_id = ?";
        $member = $this->db->fetchOne($memberSql, [$userId]);
        if (!$member) {
            return false;
        }

        $sql = "DELETE FROM event_registrations WHERE event_id = ? AND member_id = ?";
        $stmt = $this->db->query($sql, [$eventId, $member['id']]);
        return $stmt !== false && $stmt->rowCount() > 0;
    }

    public function isUserRegistered($eventId, $userId) {
        // Convert user_id to member_id
        $memberSql = "SELECT id FROM members WHERE user_id = ?";
        $member = $this->db->fetchOne($memberSql, [$userId]);
        if (!$member) {
            return false;
        }

        $sql = "SELECT COUNT(*) as count FROM event_registrations WHERE event_id = ? AND member_id = ?";
        $result = $this->db->fetchOne($sql, [$eventId, $member['id']]);
        return $result['count'] > 0;
    }

    public function getRegistrationCount($eventId) {
        $sql = "SELECT COUNT(*) as count FROM event_registrations WHERE event_id = ?";
        $result = $this->db->fetchOne($sql, [$eventId]);
        return $result['count'];
    }

    public function getEventRegistrations($eventId) {
        $sql = "SELECT er.*, m.full_name, u.username
                FROM event_registrations er
            LEFT JOIN members m ON er.member_id = m.id
            LEFT JOIN users u ON m.user_id = u.id
                WHERE er.event_id = ?
                ORDER BY er.registered_at ASC";
        return $this->db->fetchAll($sql, [$eventId]);
    }
}