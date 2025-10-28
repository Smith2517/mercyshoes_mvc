<?php $settings = (new Setting())->get(); ?>
<link rel="stylesheet" href="public/assets/css/styleproducts.css">

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
      <!-- NOTA: aquí no hay clases especiales; el JS captura por href -->
      <a class="btn" href="<?php echo BASE_URL; ?>?r=cart/add/<?php echo $p['id']; ?>">Añadir</a>
      <a class="btn light" href="<?php echo BASE_URL; ?>?r=product/show/<?php echo $p['id']; ?>">Detalle</a>
    </div>
  </div>
<?php endforeach; ?>
</div>

<section class="testimonials" id="opiniones">
  <div class="testimonials__intro">
    <h2>Lo que opinan nuestras clientas</h2>
    <p>Historias reales de mujeres que ya caminan con Mercyshoes. ¡Tu experiencia también puede inspirar a otras!</p>
  </div>

  <?php if (!empty($feedback) && !empty($feedback['message'])): ?>
    <div class="testimonial-alert <?php echo $feedback['type'] === 'success' ? 'success' : 'error'; ?>">
      <?php echo htmlspecialchars($feedback['message']); ?>
    </div>
  <?php endif; ?>

  <div class="testimonials__layout">
    <div class="testimonials__list" aria-live="polite">
      <?php if (!empty($testimonials)): ?>
        <?php foreach ($testimonials as $testimonial): ?>
          <article class="testimonial-card">
            <header>
              <div class="testimonial-stars" aria-label="Calificación: <?php echo (int)$testimonial['rating']; ?> de 5">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="star <?php echo $i <= (int)$testimonial['rating'] ? 'filled' : ''; ?>" aria-hidden="true">★</span>
                <?php endfor; ?>
              </div>
              <h3><?php echo htmlspecialchars($testimonial['author_name']); ?></h3>
              <time datetime="<?php echo htmlspecialchars($testimonial['created_at']); ?>">
                <?php echo date('d/m/Y', strtotime($testimonial['created_at'])); ?>
              </time>
            </header>
            <p>“<?php echo nl2br(htmlspecialchars($testimonial['comment'])); ?>”</p>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="testimonial-empty">Aún no hay comentarios publicados. ¡Sé la primera en dejar el tuyo!</p>
      <?php endif; ?>
    </div>

    <div class="testimonial-form-wrapper">
      <h3>Comparte tu experiencia</h3>
      <form class="testimonial-form" method="post" action="<?php echo BASE_URL; ?>?r=home/testimonial_submit">
        <div class="rating-group">
          <span>¿Cómo calificarías tu compra?</span>
          <div class="rating-input">
            <?php $selectedRating = (int)($oldTestimonial['rating'] ?? 5); ?>
            <?php for ($i = 5; $i >= 1; $i--): ?>
              <input type="radio" id="rating-<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo $selectedRating === $i ? 'checked' : ''; ?> required>
              <label for="rating-<?php echo $i; ?>" title="<?php echo $i; ?> estrella<?php echo $i > 1 ? 's' : ''; ?>">
                <span class="sr-only"><?php echo $i; ?> estrella<?php echo $i > 1 ? 's' : ''; ?></span>
                ★
              </label>
            <?php endfor; ?>
          </div>
        </div>

        <label class="input-group">
          <span>Nombre o apodo</span>
          <input type="text" name="author_name" value="<?php echo htmlspecialchars($oldTestimonial['author_name'] ?? ''); ?>" maxlength="120" required>
        </label>

        <label class="input-group">
          <span>Tu comentario</span>
          <textarea name="comment" rows="4" maxlength="600" required><?php echo htmlspecialchars($oldTestimonial['comment'] ?? ''); ?></textarea>
        </label>

        <button type="submit" class="btn">Enviar opinión</button>
        <p class="testimonial-help">Revisamos cada testimonio antes de publicarlo para mantener una comunidad segura.</p>
      </form>
    </div>
  </div>
</section>

<!-- ========= MODAL (MISMO DE products.php, SIN IFRAME) ========= -->
<div id="modal-overlay" class="modal-overlay" hidden>
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <button type="button" class="modal-close" aria-label="Cerrar">&times;</button>
    <h2 id="modal-title" class="modal-title"></h2>
    <div id="modal-content"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const overlay = document.getElementById('modal-overlay');
  const modalContent = document.getElementById('modal-content');
  const modalTitle = document.getElementById('modal-title');
  const closeBtn = overlay.querySelector('.modal-close');
  const BASE = "<?php echo BASE_URL; ?>";

  function openModal(title){
    modalTitle.textContent = title || '';
    overlay.hidden = false;
    overlay.classList.add('active');
    document.body.classList.add('modal-open');
  }
  function closeModal(){
    overlay.classList.remove('active');
    overlay.hidden = true;
    document.body.classList.remove('modal-open');
    modalTitle.textContent = '';
    modalContent.innerHTML = '';
  }
  function fetchHTML(url, opts) {
    return fetch(url, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      credentials: 'same-origin',
      ...opts
    }).then(r => { if (!r.ok) throw new Error('Network error'); return r.text(); });
  }
  function fetchModal(url, title){
    modalContent.innerHTML = '<p class="modal-loading">Cargando...</p>';
    openModal(title);
    fetchHTML(url).then(html=>{
      modalContent.innerHTML = html;

      // **Usar el <h1> del parcial como título y removerlo del cuerpo**
      const h1 = modalContent.querySelector('h1');
      if (h1) {
        modalTitle.textContent = h1.textContent.trim();
        h1.remove();
      }

      wireInsideModal();
    }).catch(()=>{
      modalContent.innerHTML = '<p class="modal-error">No se pudo cargar la información. Intenta nuevamente.</p>';
    });
  }

  function wireInsideModal(){
    // Enlaces internos del carrito/checkout
    modalContent.querySelectorAll('a[href]').forEach(a => {
      const href = a.getAttribute('href') || '';
      if (/\?r=cart\/remove\//.test(href) || /\?r=cart\/clear/.test(href) || /\?r=cart(\/|$)/.test(href) || /\?r=checkout\/form/.test(href)) {
        a.addEventListener('click', function(e){
          e.preventDefault();
          e.stopPropagation();
          modalContent.innerHTML = '<p class="modal-loading">Cargando...</p>';
          fetchHTML(href).then(html=>{
            modalContent.innerHTML = html;
            wireInsideModal();
          }).catch(()=>{
            modalContent.innerHTML = '<p class="modal-error">No se pudo cargar. Intenta nuevamente.</p>';
          });
        }, { once:true });
      }
    });

    // Form actualizar cantidades
    const formCart = modalContent.querySelector('form[action*="?r=cart/update"]');
    if (formCart) {
      formCart.addEventListener('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        const fd = new FormData(formCart);
        modalContent.innerHTML = '<p class="modal-loading">Actualizando...</p>';
        fetchHTML(formCart.action, { method:'POST', body: fd }).then(html=>{
          modalContent.innerHTML = html;
          wireInsideModal();
        }).catch(()=>{
          modalContent.innerHTML = '<p class="modal-error">No se pudo actualizar. Intenta nuevamente.</p>';
        });
      }, { once:true });
    }

    // Form de pago
    const formPay = modalContent.querySelector('form[action*="?r=checkout/pay"]');
    if (formPay) {
      if (!/partial=1/.test(formPay.action)) {
        formPay.action += (formPay.action.includes('?')?'&':'?') + 'partial=1';
      }
      formPay.addEventListener('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        const fd = new FormData(formPay);
        modalContent.innerHTML = '<p class="modal-loading">Procesando pago...</p>';
        fetchHTML(formPay.action, { method:'POST', body: fd }).then(html=>{
          modalContent.innerHTML = html;
          wireInsideModal();
        }).catch(()=>{
          modalContent.innerHTML = '<p class="modal-error">No se pudo procesar. Intenta nuevamente.</p>';
        });
      }, { once:true });
    }
  }

  // Cerrar modal
  closeBtn.addEventListener('click', closeModal);
  overlay.addEventListener('click', function(event){ if(event.target === overlay){ closeModal(); }});
  document.addEventListener('keydown', function(event){ if(event.key === 'Escape' && !overlay.hidden){ event.preventDefault(); closeModal(); } });

  // *********** Delegado global (clave): interceptar enlaces ***********
  document.addEventListener('click', function(e){
    const a = e.target.closest && e.target.closest('a'); if(!a) return;
    const href = a.getAttribute('href') || '';

    // ADD al carrito
    if (/\?r=cart\/add\//.test(href)) {
      e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation();
      fetchHTML(href).then(()=> {
        fetchModal(BASE + '?r=cart/view', 'Carrito de compras');
      }).catch(()=>{});
      return;
    }

    // Ver carrito
    if (/\?r=cart(\/|$)/.test(href)) {
      e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation();
      fetchModal(href, 'Carrito de compras');
      return;
    }

    // Checkout
    if (/\?r=checkout\/form/.test(href)) {
      e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation();
      fetchModal(href, 'Finalizar compra');
      return;
    }

    // **Detalle de producto en modal (lo que faltaba)**
    if (/\?r=product\/show\/\d+/.test(href)) {
      e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation();
      const url = href + (href.includes('?') ? '&' : '?') + 'partial=1';
      fetchModal(url, 'Detalle del producto');
      return;
    }
  }, true); // captura
});
</script>


