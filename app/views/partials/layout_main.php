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
      <?php $cartSession = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : []; ?>
      <a style="text-shadow: 1.5px 1.5px 1.5px rgba(0, 0, 0, 0.9);" href="<?php echo BASE_URL; ?>?r=cart/view" data-cart-action="view" data-modal-title="Carrito de compras">🛒 Carrito (<span data-cart-count><?php echo array_sum(array_map(function($item){ return isset($item['qty']) ? (int)$item['qty'] : 0; }, $cartSession)); ?></span>)</a>
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
<div id="modal-overlay" class="modal-overlay" hidden>
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <button type="button" class="modal-close" aria-label="Cerrar" data-modal-close>&times;</button>
    <h2 id="modal-title" class="modal-title" data-modal-title></h2>
    <div id="modal-content" data-modal-content></div>
  </div>
</div>
<script src="public/assets/js/app.js"></script>
</body>
</html>
