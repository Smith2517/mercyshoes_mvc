<?php
// Frontend Layout
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mercyshoes</title>
  <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container">
    <a style="text-shadow: 1.5px 1.5px 1.5px rgba(0, 0, 0, 0.9);" class="brand" href="<?php echo BASE_URL; ?>?r=home/index">Mercyshoes</a>
    <nav>
      <a style="text-shadow: 1.5px 1.5px 1.5px rgba(0, 0, 0, 0.9);" href="<?php echo BASE_URL; ?>?r=product/index">Productos</a>
      <a style="text-shadow: 1.5px 1.5px 1.5px rgba(0, 0, 0, 0.9);" href="<?php echo BASE_URL; ?>?r=home/about">Nosotros</a>
      <a style="text-shadow: 1.5px 1.5px 1.5px rgba(0, 0, 0, 0.9);" href="<?php echo BASE_URL; ?>?r=home/contact">Contacto</a>
      <a style="text-shadow: 1.5px 1.5px 1.5px rgba(0, 0, 0, 0.9);" href="<?php echo BASE_URL; ?>?r=cart/view">🛒 Carrito (<?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>)</a>
      <a style="text-shadow: 1.5px 1.5px 1.5px rgba(0, 0, 0, 0.9);" href="<?php echo BASE_URL; ?>?r=admin/login" class="admin">cPanel</a>
    </nav>
  </div>
</header>

<main class="container">
  <?php include $viewFile; ?>
</main>

<footer class="site-footer">
  <div class="container">
    <p style="text-shadow: 1.5px 1.5px 1.5px rgba(0, 0, 0, 0.9);">© <?php echo date('Y'); ?> Mercyshoes — Calidad y confianza.</p>
  </div>
</footer>
<script src="public/assets/js/app.js"></script>
</body>
</html>
