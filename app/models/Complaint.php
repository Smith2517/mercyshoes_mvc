<?php
class Complaint {
    private $db;

    public function __construct(){
        $this->db = Database::getInstance();
    }

    public function create($data){
        $stmt = $this->db->prepare('INSERT INTO complaints (full_name, document, email, phone, order_code, type, description) VALUES (?,?,?,?,?,?,?)');
        $stmt->execute([
            $data['full_name'],
            $data['document'],
            $data['email'],
            $data['phone'],
            $data['order_code'],
            $data['type'],
            $data['description'],
        ]);
        return $this->db->lastInsertId();
    }

    public function all(){
        $stmt = $this->db->query('SELECT * FROM complaints ORDER BY id DESC');
        return $stmt->fetchAll();
    }
}
?>
