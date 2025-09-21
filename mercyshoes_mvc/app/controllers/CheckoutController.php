<?php
class CheckoutController extends Controller {
    public function form(){
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if(empty($cart)){ $this->redirect('cart/view'); }
        $this->render('frontend/checkout', compact('cart'));
    }
    public function pay(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){ $this->redirect('checkout/form'); }
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if(empty($cart)){ $this->redirect('product/index'); }
        $total = 0; foreach($cart as $c){ $total += $c['qty']*$c['price']; }
        $data = [
            'name'=>trim($_POST['name']??''),
            'email'=>trim($_POST['email']??''),
            'phone'=>trim($_POST['phone']??''),
            'address'=>trim($_POST['address']??''),
            'total'=>$total,
        ];
        try {
            $orderId = (new Order())->create($data, $cart);
            unset($_SESSION['cart']);
            $this->redirect('checkout/receipt/'.$orderId);
        } catch (Exception $e) {
            $error = $e->getMessage();
            $cart = $cart;
            $this->render('frontend/checkout', compact('cart','error'));
        }
    }
    public function receipt($id){
        $orderModel = new Order();
        $order = $orderModel->find($id);
        if(!$order){ echo '<p>Comprobante no encontrado</p>'; return; }
        $items = $orderModel->items($id);
        $settings = (new Setting())->get();
        $this->render('frontend/receipt', compact('order','items','settings'));
    }
}
?>
