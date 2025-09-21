<?php
class User {
    private $db;
    public function __construct(){ $this->db = Database::getInstance(); }
    public function findByEmail($email){
        $s=$this->db->prepare('SELECT * FROM users WHERE email=?');
        $s->execute([$email]);
        return $s->fetch();
    }
}
?>
