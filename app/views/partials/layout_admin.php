<?php
// Admin Layout
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Mercyshoes</title>
  <link rel="stylesheet" href="public/assets/css/stylesadmin.css">
</head>
<body class="admin-body">
<header class="admin-header">
  <div class="container">
    <strong>Mercyshoes • Panel</strong>
    <nav>
      <a href="<?php echo BASE_URL; ?>?r=admin/dashboard">Inicio</a>
      <a href="<?php echo BASE_URL; ?>?r=admin/orders">Pedidos</a>
      <a href="<?php echo BASE_URL; ?>?r=admin/products">Productos</a>
      <a href="<?php echo BASE_URL; ?>?r=admin/categories">Categorías</a>
      <a href="<?php echo BASE_URL; ?>?r=admin/reports">Reportes</a>
      <a href="<?php echo BASE_URL; ?>?r=admin/settings">Ajustes</a>
      <a href="<?php echo BASE_URL; ?>?r=admin/logout">Salir</a>
      <a href="<?php echo BASE_URL; ?>" target="_blank" >Ver tienda</a>
    </nav>
  </div>
</header>
<main class="container">
  <?php include $viewFile; ?>
</main>
</body>
</html>
