<?php
class Product {
    private $db;
    public function __construct(){ $this->db = Database::getInstance(); }
    public function all() {
        $stmt = $this->db->query('SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC');
        return $stmt->fetchAll();
    }
    public function paginate($limit=12) {
        $stmt = $this->db->prepare('SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC LIMIT :l');
        $stmt->bindValue(':l', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function find($id) {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id=?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO products (category_id,name,description,price,stock,image) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$data['category_id'],$data['name'],$data['description'],$data['price'],$data['stock'],$data['image']]);
        return $this->db->lastInsertId();
    }
    public function update($id,$data) {
        $stmt = $this->db->prepare('UPDATE products SET category_id=?, name=?, description=?, price=?, stock=?, image=? WHERE id=?');
        return $stmt->execute([$data['category_id'],$data['name'],$data['description'],$data['price'],$data['stock'],$data['image'],$id]);
    }
    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id=?');
        return $stmt->execute([$id]);
    }
    public function decrementStock($id,$qty){
        $stmt = $this->db->prepare('UPDATE products SET stock = stock - ? WHERE id=? AND stock >= ?');
        $stmt->execute([$qty,$id,$qty]);
        return $stmt->rowCount() > 0;
    }
}
?>
