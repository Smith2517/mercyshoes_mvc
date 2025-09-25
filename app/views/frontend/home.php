<?php $settings = (new Setting())->get(); ?>
<!-- Hero Slider -->
<section class="hero-slider">
  <div class="slider-track">
    <div class="slide"><img src="public/assets/slider1.jpg" alt="Zapato 1"></div>
    <div class="slide"><img src="public/assets/slider2.jpg" alt="Zapato 2"></div>
    <div class="slide"><img src="public/assets/slider3.jpg" alt="Zapato 3"></div>
  </div>
  <div class="slider-overlay">
    <h1 style="font-size: 75px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.73);">Bienvenida a Mercyshoes</h1>
    <p style="font-size: 30px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.73);">Calidad y confianza en cada paso</p>
    <a class="btn" href="<?php echo BASE_URL; ?>?r=product/index">Explorar catálogo</a>
  </div>
</section>


<section style="display:flex;gap:24px;align-items:center;margin:60px 0;">
  <div style="flex:1">
    <h1 style="font-family:Cambria, serif; font-size: 45px">Bienvenido a <?php echo htmlspecialchars($settings['company_name']); ?></h1>
    <p style="line-height: 2.5; font-family: 'Georgia', serif; font-size: 20px; text-align: justify;">
      Cada paso refleja quién eres: seguridad, estilo y calidad que te acompañan en todo momento. 
      Descubre nuestros modelos más destacados y deja que tu camino hable por ti.</p>
    <a class="btn" href="<?php echo BASE_URL; ?>?r=product/index">Ver catálogo</a>
  </div>
  <div style="flex:1;text-align:center">
    <img src="public/assets/logotienda.png" alt="Mercyshoes" style="max-width:420px;opacity:.9">
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
      <a class="btn" href="<?php echo BASE_URL; ?>?r=cart/add/<?php echo $p['id']; ?>" data-cart-action="add" data-modal-title="Carrito de compras">Añadir</a>
      <a class="btn light" href="<?php echo BASE_URL; ?>?r=product/show/<?php echo $p['id']; ?>" data-modal="detail" data-modal-title="Detalle del producto">Detalle</a>
    </div>
  </div>
<?php endforeach; ?>
</div>
