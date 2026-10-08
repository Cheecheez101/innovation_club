<?php
class Project extends Model {
    protected $table = 'projects';
    private $tableColumns = null;
    private $statusEnumValues = null;

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

    private function getStatusEnumValues() {
        if ($this->statusEnumValues !== null) {
            return $this->statusEnumValues;
        }

        $column = $this->db->fetchOne("SHOW COLUMNS FROM {$this->table} WHERE Field = 'status'");
        if (!$column || empty($column['Type'])) {
            $this->statusEnumValues = [];
            return $this->statusEnumValues;
        }

        if (preg_match("/^enum\\((.*)\\)$/i", $column['Type'], $matches)) {
            $rawValues = str_getcsv($matches[1], ',', "'", '\\');
            $this->statusEnumValues = array_map('trim', $rawValues);
        } else {
            $this->statusEnumValues = [];
        }

        return $this->statusEnumValues;
    }

    private function normalizeStatusForSchema($status) {
        $status = strtolower((string)$status);
        $enumValues = $this->getStatusEnumValues();

        if (empty($enumValues) || in_array($status, $enumValues, true)) {
            return $status;
        }

        $aliases = [
            'in_progress' => 'ongoing',
            'ongoing' => 'in_progress',
            'on_hold' => 'on-hold',
            'on-hold' => 'on_hold',
            'idea' => 'planning'
        ];

        if (isset($aliases[$status]) && in_array($aliases[$status], $enumValues, true)) {
            return $aliases[$status];
        }

        return in_array('planning', $enumValues, true) ? 'planning' : ($enumValues[0] ?? $status);
    }

    public function getAllProjects() {
        $sql = "SELECT p.*, m.full_name as lead_member_name, u.username as supervisor_name
                FROM {$this->table} p
                LEFT JOIN members m ON p.lead_member_id = m.id
                LEFT JOIN users u ON p.supervisor_id = u.id
                ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function getProjectsByUser($userId) {
        // Get member ID for the user
        $memberSql = "SELECT id FROM members WHERE user_id = ?";
        $member = $this->db->fetchOne($memberSql, [$userId]);

        if (!$member) {
            return [];
        }

        $sql = "SELECT p.*, m.full_name as lead_member_name, u.username as supervisor_name
                FROM {$this->table} p
                LEFT JOIN members m ON p.lead_member_id = m.id
                LEFT JOIN users u ON p.supervisor_id = u.id
                WHERE p.lead_member_id = ?
                ORDER BY p.created_at DESC";

        return $this->db->fetchAll($sql, [$member['id']]);
    }

    public function getProjectById($id) {
        $sql = "SELECT p.*, m.full_name as lead_member_name, u.username as supervisor_name
                FROM {$this->table} p
                LEFT JOIN members m ON p.lead_member_id = m.id
                LEFT JOIN users u ON p.supervisor_id = u.id
                WHERE p.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function createProject($data) {
        if (isset($data['status'])) {
            $data['status'] = $this->normalizeStatusForSchema($data['status']);
        }

        $filteredData = $this->filterDataForCurrentSchema($data);
        if (empty($filteredData)) {
            return false;
        }

        return parent::create($filteredData);
    }

    public function updateProject($id, $data) {
        if (isset($data['status'])) {
            $data['status'] = $this->normalizeStatusForSchema($data['status']);
        }

        $filteredData = $this->filterDataForCurrentSchema($data);
        if (empty($filteredData)) {
            return false;
        }

        // Return the number of affected rows so callers can distinguish "no change" (0)
        $result = parent::update($id, $filteredData);
        return $result;
    }

    public function deleteProject($id) {
        // Remove physical files before deleting the project record.
        // DB rows in project_files/project_members are removed by ON DELETE CASCADE.
        $filesSql = "SELECT file_path FROM project_files WHERE project_id = ?";
        $files = $this->db->fetchAll($filesSql, [$id]);

        if (!empty($files)) {
            foreach ($files as $file) {
                if (empty($file['file_path'])) {
                    continue;
                }

                $fullPath = APP_PATH . $file['file_path'];
                if (file_exists($fullPath) && is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }
        }

        return parent::delete($id) > 0;
    }

    public function getMemberIdByUserId($userId) {
        $sql = "SELECT id FROM members WHERE user_id = ?";
        $result = $this->db->fetchOne($sql, [$userId]);
        return $result ? $result['id'] : null;
    }

    public function isUserTeamMember($projectId, $userId) {
        $memberId = $this->getMemberIdByUserId($userId);
        if (!$memberId) {
            return false;
        }

        $sql = "SELECT id FROM project_members WHERE project_id = ? AND member_id = ?";
        $result = $this->db->fetchOne($sql, [$projectId, $memberId]);
        return $result !== false;
    }

    public function getAllProjectsWithDetails() {
        $sql = "SELECT p.*, m.full_name as lead_member_name, u.username as supervisor_name,
                       COUNT(pm.member_id) as team_members
                FROM {$this->table} p
                LEFT JOIN members m ON p.lead_member_id = m.id
                LEFT JOIN users u ON p.supervisor_id = u.id
                LEFT JOIN project_members pm ON p.id = pm.project_id
                GROUP BY p.id
                ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function getTotalProjects() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetchOne($sql);
        return $result['count'];
    }

    public function getActiveProjectsCount() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status IN ('planning', 'in_progress')";
        $result = $this->db->fetchOne($sql);
        return $result['count'];
    }

    public function getRecentProjects($limit = 5) {
        $sql = "SELECT p.*, m.full_name as lead_member_name
                FROM {$this->table} p
                LEFT JOIN members m ON p.lead_member_id = m.id
                ORDER BY p.created_at DESC
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
}
