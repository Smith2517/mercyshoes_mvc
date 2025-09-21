<?php
class Category {
    private $db;
    public function __construct(){ $this->db = Database::getInstance(); }
    public function all(){ return $this->db->query('SELECT * FROM categories ORDER BY name')->fetchAll(); }
    public function find($id){ $s=$this->db->prepare('SELECT * FROM categories WHERE id=?'); $s->execute([$id]); return $s->fetch(); }
    public function create($name,$desc){ $s=$this->db->prepare('INSERT INTO categories (name,description) VALUES (?,?)'); $s->execute([$name,$desc]); }
    public function update($id,$name,$desc){ $s=$this->db->prepare('UPDATE categories SET name=?, description=? WHERE id=?'); return $s->execute([$name,$desc,$id]); }
    public function delete($id){ $s=$this->db->prepare('DELETE FROM categories WHERE id=?'); return $s->execute([$id]); }
}
?>
