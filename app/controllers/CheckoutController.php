<?php
class CheckoutController extends Controller {

    // Detecta si la petición es parcial (AJAX o con ?partial=1)
    protected function isPartialReq() {
        $isAjax    = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        $hasPartial= !empty($_GET['partial']);
        return $isAjax || $hasPartial;
    }

    protected function uploadReceipt(){
        $file = $_FILES['payment_receipt'] ?? null;
        if (empty($file['name'])) {
            throw new Exception('Debes adjuntar la imagen del comprobante de pago.');
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new Exception('Ocurrió un error al subir el comprobante.');
        }

        $info = @getimagesize($file['tmp_name']);
        if ($info === false) {
            throw new Exception('El comprobante debe ser una imagen válida (JPG, PNG o WEBP).');
        }

        $allowed = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG  => 'png',
            IMAGETYPE_WEBP => 'webp',
        ];
        $type = $info[2];
        if (!isset($allowed[$type])) {
            throw new Exception('Formato de comprobante no soportado. Usa JPG, PNG o WEBP.');
        }

        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0775, true);
        }

        $filename = 'receipt_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $allowed[$type];
        $destination = UPLOAD_DIR . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('No se pudo guardar el comprobante. Intenta nuevamente.');
        }

        return 'public/uploads/' . $filename;
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
            $data['payment_receipt'] = $this->uploadReceipt();
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

            if (!empty($data['payment_receipt'] ?? '')) {
                $stored = UPLOAD_DIR . basename($data['payment_receipt']);
                if (is_file($stored)) {
                    @unlink($stored);
                }
                unset($data['payment_receipt']);
            }

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
