<?php
class Member extends Model {
    protected $table = 'members';
    
    public function findActiveMembers() {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY full_name";
        return $this->db->fetchAll($sql);
    }
    
    public function search($query) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE full_name LIKE :query 
                OR student_id LIKE :query 
                OR email LIKE :query 
                ORDER BY full_name";
        return $this->db->fetchAll($sql, ['query' => "%$query%"]);
    }
}
