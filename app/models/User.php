<?php
class User extends Model {
    protected $table = 'users';
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username OR email = :email";
        return $this->db->fetchOne($sql, ['username' => $username, 'email' => $username]);
    }
    
    public function createUser($data) {
        // Hash password before saving
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        return parent::create($data);
    }
}
