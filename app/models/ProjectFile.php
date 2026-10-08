<?php
class ProjectFile extends Model {
    protected $table = 'project_files';

    public function getFilesByProjectId($projectId) {
        $sql = "SELECT pf.*, u.username as uploaded_by_name
                FROM {$this->table} pf
                LEFT JOIN users u ON pf.uploaded_by = u.id
                WHERE pf.project_id = :project_id
                ORDER BY pf.uploaded_at DESC";
        return $this->db->fetchAll($sql, ['project_id' => $projectId]);
    }

    public function createFile($data) {
        return parent::create($data);
    }

    public function deleteFile($id) {
        // Get file info first to delete physical file
        $file = $this->findById($id);
        if ($file) {
            $filePath = APP_PATH . $file['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        return parent::delete($id);
    }
}