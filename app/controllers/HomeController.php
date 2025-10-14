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
    public function complaint(){
        $this->render('frontend/complaint');
    }
    public function complaint_submit(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('home/complaint');
        }

        $data = [
            'full_name'  => trim($_POST['full_name'] ?? ''),
            'document'   => trim($_POST['document'] ?? ''),
            'email'      => trim($_POST['email'] ?? ''),
            'phone'      => trim($_POST['phone'] ?? ''),
            'order_code' => trim($_POST['order_code'] ?? ''),
            'type'       => trim($_POST['type'] ?? 'Reclamo'),
            'description'=> trim($_POST['description'] ?? ''),
        ];

        $errors = [];
        if ($data['full_name'] === '') { $errors[] = 'Ingresa tu nombre completo.'; }
        if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'Ingresa un correo válido.'; }
        if ($data['description'] === '') { $errors[] = 'Describe tu reclamo o queja.'; }
        if (!in_array($data['type'], ['Reclamo','Queja','Consulta'], true)) { $data['type'] = 'Reclamo'; }

        if ($errors) {
            $error = implode(' ', $errors);
            $old = $data;
            $this->render('frontend/complaint', compact('error','old'));
            return;
        }

        (new Complaint())->create($data);
        $success = 'Tu registro en el libro de reclamaciones se ha enviado correctamente. Pronto nos pondremos en contacto.';
        $this->render('frontend/complaint', compact('success'));
    }
}
?>
