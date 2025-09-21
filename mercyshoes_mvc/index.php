<?php
session_start();
require __DIR__ . '/config/config.php';

spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/core/' . $class . '.php',
        __DIR__ . '/app/controllers/' . $class . '.php',
        __DIR__ . '/app/models/' . $class . '.php',
    ];
    foreach ($paths as $p) if (file_exists($p)) { require $p; return; }
});

// Simple Router: r=controller/action/param1/param2
$route = isset($_GET['r']) ? trim($_GET['r']) : 'home/index';
$parts = array_values(array_filter(explode('/', $route)));
$controller = !empty($parts[0]) ? ucfirst($parts[0]) . 'Controller' : 'HomeController';
$action = $parts[1] ?? 'index';
$params = array_slice($parts, 2);

if (!class_exists($controller)) {
    http_response_code(404);
    echo "<h1>404</h1><p>Controlador no encontrado: $controller</p>";
    exit;
}
$c = new $controller();
if (!method_exists($c, $action)) {
    http_response_code(404);
    echo "<h1>404</h1><p>Acción no encontrada: $action</p>";
    exit;
}
call_user_func_array([$c, $action], $params);
?>
