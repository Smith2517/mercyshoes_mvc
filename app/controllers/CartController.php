<?php
class CartController extends Controller {
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
            $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
            $this->renderPartial('frontend/partials/cart_content', compact('cart'));
            return;
        }
        $this->redirect('cart/view');
    }
    public function remove($id){
        if(isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
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
        $this->redirect('cart/view');
    }
    public function view(){
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if($this->isAjax()){
            $this->renderPartial('frontend/partials/cart_content', compact('cart'));
            return;
        }
        $this->render('frontend/cart', compact('cart'));
    }
    public function clear(){
        unset($_SESSION['cart']);
        $this->redirect('cart/view');
    }
}
?>