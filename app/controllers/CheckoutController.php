<?php
class CheckoutController extends Controller {

    // Detecta si la petición es parcial (AJAX o con ?partial=1)
    protected function isPartialReq() {
        $isAjax    = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        $hasPartial= !empty($_GET['partial']);
        return $isAjax || $hasPartial;
    }

    public function form(){
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (empty($cart)) { 
            $this->redirect('cart/view'); 
        }

        if ($this->isPartialReq()) {
            // En modal: solo el contenido (sin layout)
            $this->renderPartial('frontend/checkout', compact('cart'));
            return;
        }

        // Página normal con layout
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
        foreach($cart as $c){ $total += $c['qty'] * $c['price']; }

        $data = [
            'name'    => trim($_POST['name']    ?? ''),
            'email'   => trim($_POST['email']   ?? ''),
            'phone'   => trim($_POST['phone']   ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'total'   => $total,
        ];

        try {
            $orderModel = new Order();
            $orderId = $orderModel->create($data, $cart);

            // limpiar carrito
            unset($_SESSION['cart']);

            if ($this->isPartialReq()) {
                // En modal: devolver directamente el comprobante (sin layout)
                $order    = $orderModel->find($orderId);
                $items    = $orderModel->items($orderId);
                $settings = (new Setting())->get();
                $this->renderPartial('frontend/receipt', compact('order','items','settings'));
                return;
            }

            // Página completa
            $this->redirect('checkout/receipt/'.$orderId);

        } catch (Exception $e) {
            $error = $e->getMessage();

            if ($this->isPartialReq()) {
                // En modal: devolver el form con el error (sin layout)
                $this->renderPartial('frontend/checkout', compact('cart','error'));
                return;
            }

            // Página completa con error
            $this->render('frontend/checkout', compact('cart','error'));
        }
    }

    public function receipt($id){
        $orderModel = new Order();
        $order = $orderModel->find($id);
        if (!$order) { echo '<p>Comprobante no encontrado</p>'; return; }

        $items    = $orderModel->items($id);
        $settings = (new Setting())->get();

        if ($this->isPartialReq()) {
            // En modal
            $this->renderPartial('frontend/receipt', compact('order','items','settings'));
            return;
        }

        // Página completa
        $this->render('frontend/receipt', compact('order','items','settings'));
    }
}
