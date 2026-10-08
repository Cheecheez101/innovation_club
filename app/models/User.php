<?php
class User extends Model {
    protected $table = 'users';
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = ? OR email = ?";
        return $this->db->fetchOne($sql, [$username, $username]);
    }
    
    public function findById($id) {
        $sql = "SELECT u.*, m.full_name, m.student_id
                FROM {$this->table} u
                LEFT JOIN members m ON u.id = m.user_id
                WHERE u.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getAllUsers() {
        $sql = "SELECT u.*, m.full_name, m.student_id
                FROM {$this->table} u
                LEFT JOIN members m ON u.id = m.user_id
                ORDER BY u.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function getTotalUsers() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetchOne($sql);
        return $result['count'];
    }

    public function updateUser($id, $data) {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return parent::update($id, $data);
    }

    public function createUser($data) {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return parent::create($data);
    }

    public function countAdmins() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE role = 'admin'";
        $result = $this->db->fetchOne($sql);
        return (int) ($result['count'] ?? 0);
    }

    public function hasUserReferences($userId) {
        $referenceChecks = [
            ['table' => 'events', 'column' => 'organizer_id'],
            ['table' => 'events', 'column' => 'created_by'],
            ['table' => 'attendance', 'column' => 'marked_by'],
            ['table' => 'projects', 'column' => 'supervisor_id'],
            ['table' => 'project_files', 'column' => 'uploaded_by']
        ];

        foreach ($referenceChecks as $check) {
            if (!$this->tableColumnExists($check['table'], $check['column'])) {
                continue;
            }

            $sql = "SELECT COUNT(*) as count FROM {$check['table']} WHERE {$check['column']} = ?";
            $result = $this->db->fetchOne($sql, [$userId]);
            if ((int) ($result['count'] ?? 0) > 0) {
                return true;
            }
        }

        return false;
    }

    public function deleteUser($id) {
        try {
            return parent::delete($id) > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    private function tableColumnExists($table, $column) {
        $sql = "SELECT COUNT(*) as count
                FROM information_schema.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = ?
                AND COLUMN_NAME = ?";

        $result = $this->db->fetchOne($sql, [$table, $column]);
        return (int) ($result['count'] ?? 0) > 0;
    }
}
