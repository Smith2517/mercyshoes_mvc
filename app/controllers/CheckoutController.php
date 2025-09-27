<?php
class CheckoutController extends Controller {

    // <- agregado: detectar modo parcial (AJAX o ?partial=1)
    protected function isPartialReq() {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest';
        $hasPartial = !empty($_GET['partial']);
        return $isAjax || $hasPartial;
    }

    public function form(){
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (empty($cart)) { 
            $this->redirect('cart/view'); 
        }

        // En modo parcial devolvemos SOLO el contenido (sin layout)
        if ($this->isPartialReq()) {
            $this->renderPartial('frontend/checkout', compact('cart'));
            return;
        }

        // Modo normal con layout (lo que ya hacías)
        $this->render('frontend/checkout', compact('cart'));
    }

    public function pay(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
            $this->redirect('checkout/form'); 
        }

        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (empty($cart)) { 
            $this->redirect('product/index'); 
        }

        $total = 0; 
        foreach($cart as $c){ $total += $c['qty']*$c['price']; }

        $data = [
            'name'   => trim($_POST['name']   ?? ''),
            'email'  => trim($_POST['email']  ?? ''),
            'phone'  => trim($_POST['phone']  ?? ''),
            'address'=> trim($_POST['address']?? ''),
            'total'  => $total,
        ];

        try {
            $orderId = (new Order())->create($data, $cart);
            // limpiar carrito al confirmar
            unset($_SESSION['cart']);

            // En modo parcial devolvemos el comprobante SIN layout (para el modal)
            if ($this->isPartialReq()) {
                $orderModel = new Order();
                $order  = $orderModel->find($orderId);
                $items  = $orderModel->items($orderId);
                $settings = (new Setting())->get();
                $this->renderPartial('frontend/receipt', compact('order','items','settings'));
                return;
            }

            // Modo normal: como ya hacías, redirige a recibo con layout
            $this->redirect('checkout/receipt/'.$orderId);

        } catch (Exception $e) {
            $error = $e->getMessage();

            // En modo parcial, devolvemos SOLO el formulario con error (sin layout)
            if ($this->isPartialReq()) {
                $this->renderPartial('frontend/checkout', compact('cart','error'));
                return;
            }

            // Modo normal con layout (tu flujo actual)
            $this->render('frontend/checkout', compact('cart','error'));
        }
    }

    public function receipt($id){
        $orderModel = new Order();
        $order = $orderModel->find($id);
        if (!$order) { echo '<p>Comprobante no encontrado</p>'; return; }
        $items = $orderModel->items($id);
        $settings = (new Setting())->get();

        // Si alguien abre el recibo en parcial, devolvemos sin layout
        if ($this->isPartialReq()) {
            $this->renderPartial('frontend/receipt', compact('order','items','settings'));
            return;
        }

        $this->render('frontend/receipt', compact('order','items','settings'));
    }
}
?>
