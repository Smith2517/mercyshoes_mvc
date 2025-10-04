<?php /* products.php (agrupado por categorías + filtros + modal) */ ?>
<link rel="stylesheet" href="public/assets/css/styleproducts.css">

<?php
// 1) Agrupar en servidor
$groups = [];
$categories = [];
foreach ($products as $p) {
  $cat = trim($p['category_name'] ?? 'Sin categoría');
  $groups[$cat][] = $p;
  $categories[$cat] = true;
}
$categories = array_keys($categories);

// helper para slug/id
function slug($t) {
  $s = iconv('UTF-8','ASCII//TRANSLIT',$t);
  $s = preg_replace('~[^\\pL\\d]+~u','-', $s);
  $s = trim($s,'-');
  $s = strtolower($s);
  return $s ?: 'sin-categoria';
}
?>

<h1 style="text-align:center;font-size:45px;text-shadow:2.5px 2.5px 2.5px rgba(255,255,255,.9);">Catálogo</h1>

<!-- 2) Filtros -->
<div class="cat-filters" style="display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin:10px 0 20px">
  <button class="chip active" data-filter="*">Todos</button>
  <?php foreach ($categories as $cat): ?>
    <button class="chip" data-filter="<?php echo slug($cat); ?>">
      <?php echo htmlspecialchars($cat); ?>
    </button>
  <?php endforeach; ?>
</div>

<!-- 3) Secciones por categoría -->
<div id="catalog-container">
  <?php foreach ($groups as $cat => $items): $catId = slug($cat); ?>
    <section class="cat-section" data-category="<?php echo $catId; ?>">
      <h2 class="cat-title" style="margin:16px 0 12px;font-size:22px">
        <?php echo htmlspecialchars($cat); ?>
      </h2>
      <div class="grid">
        <?php foreach ($items as $p): ?>
          <div class="card" data-category="<?php echo $catId; ?>">
            <img src="<?php echo $p['image'] ?: 'public/assets/placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="p">
              <strong><?php echo htmlspecialchars($p['name']); ?></strong><br>
              <small><?php echo htmlspecialchars($p['category_name'] ?? ''); ?></small>
              <div class="price">S/ <?php echo number_format($p['price'],2); ?></div>
              <a class="btn add-to-cart" href="<?php echo BASE_URL; ?>?r=cart/add/<?php echo $p['id']; ?>" data-product-id="<?php echo $p['id']; ?>">Añadir</a>
              <a class="btn light view-detail" href="<?php echo BASE_URL; ?>?r=product/show/<?php echo $p['id']; ?>" data-product-id="<?php echo $p['id']; ?>">Detalle</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>
</div>

<!-- MODAL -->
<div id="modal-overlay" class="modal-overlay" hidden>
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <button type="button" class="modal-close" aria-label="Cerrar">&times;</button>
    <h2 id="modal-title" class="modal-title"></h2>
    <div id="modal-content"></div>
  </div>
</div>

<style>
  /* Chips de filtro */
  .chip { border:1px solid #ddd; background:#fff; border-radius:999px; padding:8px 14px; cursor:pointer; }
  .chip.active { border-color:#111; box-shadow:0 0 0 2px rgba(0,0,0,.05) inset; }
  /* Modal mínimo (por si no está en tu CSS) */
  .modal-open { overflow:hidden; }
  .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,.45); display:grid; place-items:center; padding:24px; z-index:9999; opacity:0; pointer-events:none; transition:opacity .2s ease; }
  .modal-overlay.active { opacity:1; pointer-events:auto; }
  .modal { width:min(900px,100%); max-height:85vh; overflow:auto; background:#fff; border-radius:16px; padding:20px 16px 16px; box-shadow:0 20px 60px rgba(0,0,0,.25); position:relative; }
  .modal-title { margin:0 40px 12px 8px; font-size:20px; }
  .modal-close { position:absolute; right:18px; top:12px; border:0; background:transparent; font-size:28px; line-height:1; cursor:pointer; }
  .modal-loading,.modal-error{ padding:16px; text-align:center; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const overlay = document.getElementById('modal-overlay');
  const modalContent = document.getElementById('modal-content');
  const modalTitle = document.getElementById('modal-title');
  const closeBtn = overlay.querySelector('.modal-close');
  const BASE = "<?php echo BASE_URL; ?>";

  // === Filtros por categoría (cliente) ===
  const filterBtns = document.querySelectorAll('.cat-filters .chip');
  const sections = document.querySelectorAll('.cat-section');

  function applyFilter(key){
    sections.forEach(sec => {
      const secKey = sec.getAttribute('data-category');
      if (key === '*' || key === secKey) {
        sec.style.display = '';
      } else {
        sec.style.display = 'none';
      }
    });
  }

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const key = btn.getAttribute('data-filter');
      applyFilter(key);
    });
  });

  // === Modal helpers ===
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
      const h1 = modalContent.querySelector('h1');
      if (h1) { modalTitle.textContent = h1.textContent.trim(); h1.remove(); }
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

  // Delegado global
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

    // Detalle en modal
    if (/\?r=product\/show\/\d+/.test(href)) {
      e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation();
      const url = href + (href.includes('?') ? '&' : '?') + 'partial=1';
      fetchModal(url, 'Detalle del producto');
      return;
    }
  }, true);
});
</script>
