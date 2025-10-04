<?php
class Order {
    private $db;
    public function __construct(){ $this->db = Database::getInstance(); }
    public function create($data, $items) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('INSERT INTO orders (customer_name,customer_email,customer_phone,customer_address,total,status,created_at) VALUES (?,?,?,?,?,"PENDIENTE",NOW())');
            $stmt->execute([$data['name'],$data['email'],$data['phone'],$data['address'],$data['total']]);
            $orderId = $this->db->lastInsertId();

            $stmtItem = $this->db->prepare('INSERT INTO order_items (order_id,product_id,quantity,unit_price,subtotal) VALUES (?,?,?,?,?)');
            $prodModel = new Product();
            foreach ($items as $it) {
                $stmtItem->execute([$orderId,$it['id'],$it['qty'],$it['price'],$it['qty']*$it['price']]);
                // Decrement stock
                if (!$prodModel->decrementStock($it['id'], $it['qty'])) {
                    throw new Exception('Stock insuficiente para: ' . $it['name']);
                }
            }
            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    public function all(){
        return $this->db->query('SELECT * FROM orders ORDER BY id DESC')->fetchAll();
    }
    public function find($id){
        $s=$this->db->prepare('SELECT * FROM orders WHERE id=?'); $s->execute([$id]); return $s->fetch();
    }
    public function items($order_id){
        $s=$this->db->prepare('SELECT oi.*, p.name, od.`status` FROM order_items oi INNER JOIN products p ON p.id=oi.product_id
                                INNER JOIN orders od ON od.id=oi.order_id  WHERE oi.order_id=?');
        $s->execute([$order_id]);
        return $s->fetchAll();
    }
    public function setStatus($id,$status){
        $s=$this->db->prepare('UPDATE orders SET status=? WHERE id=?'); return $s->execute([$status,$id]);
    }
    public function stats(){
        $res = [];
        $res['orders_count'] = $this->db->query('SELECT COUNT(*) c FROM orders')->fetch()['c'];
        $res['sales_sum'] = $this->db->query('SELECT IFNULL(SUM(total),0) s FROM orders WHERE status IN ("PAGADO","ENVIADO")')->fetch()['s'];
        $res['low_stock'] = $this->db->query('SELECT COUNT(*) c FROM products WHERE stock<=3')->fetch()['c'];
        return $res;
    }
    public function reportByMonth(){
        return $this->db->query('SELECT DATE_FORMAT(created_at,"%Y-%m") as ym, COUNT(*) as pedidos, SUM(total) as total FROM orders GROUP BY ym ORDER BY ym DESC')->fetchAll();
    }
}
?>
