<?php
class AdminController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['admin_id'])) {
            $this->redirect('admin/dashboard');
        }
        $this->render('admin/login', [], 'admin');
    }
    public function doLogin()
    {
        $email = $_POST['email'] ?? '';
        $pass = $_POST['password'] ?? '';
        $u = (new User())->findByEmail($email);
        if ($u && password_verify($pass, $u['password_hash'])) {
            Auth::login($u);
            $this->redirect('admin/dashboard');
        } else {
            $error = 'Credenciales no válidas';
            $this->render('admin/login', compact('error'), 'admin');
        }
    }
    public function logout()
    {
        Auth::logout();
        $this->redirect('admin/login');
    }
    public function dashboard()
    {
        Auth::requireAdmin();
        $stats = (new Order())->stats();
        $this->render('admin/dashboard', compact('stats'), 'admin');
    }
    public function orders()
    {
        Auth::requireAdmin();
        $orders = (new Order())->all();
        $this->render('admin/orders', compact('orders'), 'admin');
    }
    public function order($id)
    {
        Auth::requireAdmin();
        $m = new Order();
        $order = $m->find($id);
        $items = $m->items($id);
        $this->render('admin/order_view', compact('order', 'items'), 'admin');
    }
    public function status()
    {
        Auth::requireAdmin();
        $id = $_POST['id'];
        $status = $_POST['status'];
        (new Order())->setStatus($id, $status);
        $this->redirect('admin/order/' . $id);
    }

    // Products
    public function products()
    {
        Auth::requireAdmin();
        $m = new Product();
        $products = $m->all();
        $cats = (new Category())->all();
        $this->render('admin/products', compact('products', 'cats'), 'admin');
    }
    public function product_create()
    {
        Auth::requireAdmin();
        $cats = (new Category())->all();
        $this->render('admin/product_form', compact('cats'), 'admin');
    }
    public function product_store()
    {
        Auth::requireAdmin();
        $imgPath = '';
        if (!empty($_FILES['image']['name'])) {
            $fname = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['image']['name']);
            $dest = UPLOAD_DIR . $fname;
            move_uploaded_file($_FILES['image']['tmp_name'], $dest);
            $imgPath = 'public/uploads/' . $fname;
        }
        $data = [
            'category_id' => $_POST['category_id'] ?? null,
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'stock' => $_POST['stock'] ?? 0,
            'image' => $imgPath
        ];
        (new Product())->create($data);
        $this->redirect('admin/products');
    }
    public function product_edit($id)
    {
        Auth::requireAdmin();
        $p = (new Product())->find($id);
        $cats = (new Category())->all();
        $this->render('admin/product_form', compact('p', 'cats'), 'admin');
    }
    public function product_update($id)
    {
        Auth::requireAdmin();
        $p = (new Product())->find($id);
        $imgPath = $p['image'];
        if (!empty($_FILES['image']['name'])) {
            $fname = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['image']['name']);
            $dest = UPLOAD_DIR . $fname;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                $imgPath = 'public/uploads/' . $fname;
            }
        }
        $data = [
            'category_id' => $_POST['category_id'] ?? null,
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'stock' => $_POST['stock'] ?? 0,
            'image' => $imgPath
        ];
        (new Product())->update($id, $data);
        $this->redirect('admin/products');
    }
    public function product_delete($id)
    {
        Auth::requireAdmin();
        (new Product())->delete($id);
        $this->redirect('admin/products');
    }

    // Categories
    public function categories()
    {
        Auth::requireAdmin();
        $cats = (new Category())->all();
        $this->render('admin/categories', compact('cats'), 'admin');
    }
    public function category_store()
    {
        Auth::requireAdmin();
        (new Category())->create($_POST['name'], $_POST['description']);
        $this->redirect('admin/categories');
    }
    public function category_update($id)
    {
        Auth::requireAdmin();
        (new Category())->update($id, $_POST['name'], $_POST['description']);
        $this->redirect('admin/categories');
    }
    public function category_delete($id)
    {
        Auth::requireAdmin();
        (new Category())->delete($id);
        $this->redirect('admin/categories');
    }

    // Reports
    public function reports()
    {
        Auth::requireAdmin();
        $rows = (new Order())->reportByMonth();
        $this->render('admin/reports', compact('rows'), 'admin');
    }

    // Settings
    public function settings()
    {
        Auth::requireAdmin();
        $settings = (new Setting())->get();
        $this->render('admin/settings', compact('settings'), 'admin');
    }
    public function settings_save()
    {
        Auth::requireAdmin();
        $s = new Setting();
        $cur = $s->get();
        $logo = $cur['logo_path'];
        if (!empty($_FILES['logo']['name'])) {
            $fname = 'logo_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['logo']['name']);
            $dest = UPLOAD_DIR . $fname;
            move_uploaded_file($_FILES['logo']['tmp_name'], $dest);
            $logo = 'public/uploads/' . $fname;
        }
        $data = [
            'id' => $cur['id'],
            'company_name' => $_POST['company_name'],
            'company_email' => $_POST['company_email'],
            'company_phone' => $_POST['company_phone'],
            'company_address' => $_POST['company_address'],
            'company_ruc' => $_POST['company_ruc'],
            'logo_path' => $logo
        ];
        $s->update($data);
        $this->redirect('admin/settings');
    }
}
