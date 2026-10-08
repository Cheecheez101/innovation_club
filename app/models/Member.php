<?php
class Member extends Model {
    protected $table = 'members';
    
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function findActiveMembers() {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY full_name";
        return $this->db->fetchAll($sql);
    }
    
    public function findByUserId($userId) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ?";
        return $this->db->fetchOne($sql, [$userId]);
    }

    public function getAllMembers() {
        $sql = "SELECT m.*, u.username, u.email, u.role, u.is_active, u.last_login, u.created_at as user_created_at
                FROM {$this->table} m
                LEFT JOIN users u ON m.user_id = u.id
                ORDER BY m.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function getTotalMembers() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetchOne($sql);
        return $result['count'];
    }

    public function getRecentMembers($limit = 5) {
        $sql = "SELECT m.*, u.username, u.email
                FROM {$this->table} m
                LEFT JOIN users u ON m.user_id = u.id
                ORDER BY m.created_at DESC
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function getRecentRegistrationsCount($days = 30) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)";
        $result = $this->db->fetchOne($sql, [$days]);
        return $result['count'];
    }
}
