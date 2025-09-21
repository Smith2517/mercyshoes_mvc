<h1>Catálogo</h1>
<div class="grid">
<?php foreach($products as $p): ?>
  <div class="card">
    <img src="<?php echo $p['image'] ?: 'public/assets/placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
    <div class="p">
      <strong><?php echo htmlspecialchars($p['name']); ?></strong><br>
      <small><?php echo htmlspecialchars($p['category_name'] ?? ''); ?></small>
      <div class="price">S/ <?php echo number_format($p['price'],2); ?></div>
      <a class="btn" href="<?php echo BASE_URL; ?>?r=cart/add/<?php echo $p['id']; ?>">Añadir</a>
      <a class="btn light" href="<?php echo BASE_URL; ?>?r=product/show/<?php echo $p['id']; ?>">Detalle</a>
    </div>
  </div>
<?php endforeach; ?>
</div>
