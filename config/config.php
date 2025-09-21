<?php
// === Configuration for Mercyshoes MVC ===
date_default_timezone_set('America/Lima');

// Base URL (adjust if the folder name changes)
define('BASE_URL', 'http://localhost/mercyshoes_mvc/index.php');

// Database (XAMPP defaults). Change password if you set one for root.
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mercyshoes_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// File upload directory (relative to project root)
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');

// Company defaults (editable later in Admin > Ajustes)
define('COMPANY_DEFAULT_NAME', 'Mercyshoes');
define('COMPANY_DEFAULT_EMAIL', 'ventas@mercyshoes.local');
define('COMPANY_DEFAULT_PHONE', '+51 900 000 000');
?>
