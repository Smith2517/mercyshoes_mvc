<?php
class HomeController extends Controller {
    public function index(){
        $m = new Product();
        $products = $m->paginate(12);
        $this->render('frontend/home', compact('products'));
    }
    public function about(){
        $settings = (new Setting())->get();
        $this->render('frontend/about', compact('settings'));
    }
    public function contact(){
        $settings = (new Setting())->get();
        $this->render('frontend/contact', compact('settings'));
    }
}
?>
