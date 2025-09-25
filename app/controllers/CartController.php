<?php
class CartController extends Controller {
    private function cartItems(){
        return isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    private function cartCount($cart = null){
        $items = $cart !== null ? $cart : $this->cartItems();
        return array_sum(array_map(function($item){ return isset($item['qty']) ? (int)$item['qty'] : 0; }, $items));
    }

    private function respondCartAjax($cart){
        $html = $this->renderPartialToString('frontend/partials/cart_content', ['cart' => $cart]);
        header('Content-Type: application/json');
        echo json_encode([
            'title' => 'Carrito de compras',
            'html' => $html,
            'count' => $this->cartCount($cart)
        ]);
        exit;
    }
    public function add($id){
        $p = (new Product())->find($id);
        if(!$p){ $this->redirect('product/index'); }
        if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$id] = ['id'=>$p['id'],'name'=>$p['name'],'price'=>$p['price'],'qty'=>1];
        }
        if($this->isAjax()){
            $this->respondCartAjax($this->cartItems());
        }
        $this->redirect('cart/view');
    }
    public function remove($id){
        if(isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
        if($this->isAjax()){
            $this->respondCartAjax($this->cartItems());
        }
        $this->redirect('cart/view');
    }
    public function update(){
        if(isset($_POST['qty']) && is_array($_POST['qty'])){
            foreach($_POST['qty'] as $id=>$qty){
                $qty = (int)$qty;
                if($qty<=0){ unset($_SESSION['cart'][$id]); }
                else if(isset($_SESSION['cart'][$id])){ $_SESSION['cart'][$id]['qty'] = $qty; }
            }
        }
        if($this->isAjax()){
            $this->respondCartAjax($this->cartItems());
        }
        $this->redirect('cart/view');
    }
    public function view(){
        $cart = $this->cartItems();
        if($this->isAjax()){
            $this->respondCartAjax($cart);
        }
        $this->render('frontend/cart', compact('cart'));
    }
    public function clear(){
        unset($_SESSION['cart']);
        if($this->isAjax()){
            $this->respondCartAjax($this->cartItems());
        }
        $this->redirect('cart/view');
    }
}
?>
