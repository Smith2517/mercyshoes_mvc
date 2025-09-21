<?php
class Auth {
    public static function requireAdmin() {
        if (empty($_SESSION['admin_id'])) {
            header('Location: ' . BASE_URL . '?r=admin/login');
            exit;
        }
    }
    public static function login($user) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];
    }
    public static function logout() {
        unset($_SESSION['admin_id'], $_SESSION['admin_name']);
    }
}
?>
