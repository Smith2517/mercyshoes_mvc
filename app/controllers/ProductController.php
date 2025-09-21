<?php
class ProductController extends Controller {
    public function index(){
        $m = new Product();
        $products = $m->all();
        $this->render('frontend/products', compact('products'));
    }
    public function show($id){
        $m = new Product();
        $product = $m->find($id);
        if(!$product){ echo '<p>Producto no encontrado</p>'; return; }
        $this->render('frontend/product_detail', compact('product'));
    }
}
?>
