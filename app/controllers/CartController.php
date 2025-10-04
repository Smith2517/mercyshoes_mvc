<?php
class CartController extends Controller {

    protected function isPartialReq() {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest';
        $hasPartial = !empty($_GET['partial']);
        return $isAjax || $hasPartial;
    }

    protected function renderCartPartial() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $this->renderPartial('frontend/partials/cart_content', compact('cart'));
    }

    public function add($id){
        $p = (new Product())->find($id);
        if(!$p){ $this->redirect('product/index'); }

        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$id] = ['id'=>$p['id'], 'name'=>$p['name'], 'price'=>$p['price'], 'qty'=>1];
        }

        if($this->isPartialReq()){
            $this->renderCartPartial();
            return;
        }
        $this->redirect('cart/view');
    }

    public function remove($id){
        if(isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);

        if($this->isPartialReq()){
            $this->renderCartPartial();
            return;
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

        if($this->isPartialReq()){
            $this->renderCartPartial();
            return;
        }
        $this->redirect('cart/view');
    }

    public function view(){
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if($this->isPartialReq()){
            $this->renderPartial('frontend/partials/cart_content', compact('cart'));
            return;
        }
        $this->render('frontend/cart', compact('cart'));
    }

    public function clear(){
        unset($_SESSION['cart']);

        if($this->isPartialReq()){
            $this->renderCartPartial();
            return;
        }
        $this->redirect('cart/view');
    }
}
?>
