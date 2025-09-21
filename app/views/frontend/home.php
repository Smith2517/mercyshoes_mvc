<?php $settings = (new Setting())->get(); ?>
<!-- Hero Slider -->
<section class="hero-slider">
  <div class="slider-track">
    <div class="slide"><img src="public/assets/slider1.jpg" alt="Zapato 1"></div>
    <div class="slide"><img src="public/assets/slider2.jpg" alt="Zapato 2"></div>
    <div class="slide"><img src="public/assets/slider1.jpg" alt="Zapato 3"></div>
  </div>
  <div class="slider-overlay">
    <h1>Bienvenida a Mercyshoes</h1>
    <p>Calidad y confianza en cada paso</p>
    <a class="btn" href="<?php echo BASE_URL; ?>?r=product/index">Explorar catálogo</a>
  </div>
</section>


<section style="display:flex;gap:24px;align-items:center;margin:24px 0;">
  <div style="flex:1">
    <h1>Bienvenido a <?php echo htmlspecialchars($settings['company_name']); ?></h1>
    <p>Calidad y confianza en cada paso. Descubre nuestros modelos destacados.</p>
    <a class="btn" href="<?php echo BASE_URL; ?>?r=product/index">Ver catálogo</a>
  </div>
  <div style="flex:1;text-align:center">
    <img src="public/assets/logotienda.png" alt="Mercyshoes" style="max-width:300px;opacity:.9">
  </div>
</section>

<h2>Nuevos productos</h2>
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
