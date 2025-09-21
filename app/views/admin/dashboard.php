<h1>Panel</h1>
<div class="grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="form"><h3>Pedidos</h3><p><?php echo (int)$stats['orders_count']; ?></p></div>
  <div class="form"><h3>Ventas (pagadas/enviadas)</h3><p>S/ <?php echo number_format($stats['sales_sum'],2); ?></p></div>
  <div class="form"><h3>Productos con poco stock</h3><p><?php echo (int)$stats['low_stock']; ?></p></div>
</div>
<p><a class="btn" href="<?php echo BASE_URL; ?>?r=admin/products">Gestionar productos</a></p>
