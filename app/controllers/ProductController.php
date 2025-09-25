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
        if(!$product){
            http_response_code(404);
            echo '<p>Producto no encontrado</p>';
            return;
        }
        if($this->isAjax()){
            $this->renderPartial('frontend/partials/product_detail_content', compact('product'));
            return;
        }
        $this->render('frontend/product_detail', compact('product'));
    }
}
?>
