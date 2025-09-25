<link rel="stylesheet" href="public/assets/css/styleproducts.css">
<h1 style="text-align: center; font-size: 45px; text-shadow: 2.5px 2.5px 2.5px rgba(255, 255, 255, 0.9);">Catálogo</h1>
<div class="grid">
<?php foreach($products as $p): ?>
  <div class="card">
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

  function openModal(title){
    modalTitle.textContent = title;
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

  function fetchModal(url, title){
    modalContent.innerHTML = '<p class="modal-loading">Cargando...</p>';
    openModal(title);
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
      .then(function(response){
        if(!response.ok){ throw new Error('Error de red'); }
        return response.text();
      })
      .then(function(html){
        modalContent.innerHTML = html;
      })
      .catch(function(){
        modalContent.innerHTML = '<p class="modal-error">No se pudo cargar la información. Intenta nuevamente.</p>';
      });
  }

  closeBtn.addEventListener('click', closeModal);
  overlay.addEventListener('click', function(event){
    if(event.target === overlay){ closeModal(); }
  });
  document.addEventListener('keydown', function(event){
    if(event.key === 'Escape' && !overlay.hidden){
      event.preventDefault();
      closeModal();
    }
  });

  document.querySelectorAll('.add-to-cart').forEach(function(link){
    link.addEventListener('click', function(event){
      event.preventDefault();
      fetchModal(link.href, 'Carrito de compras');
    });
  });

  document.querySelectorAll('.view-detail').forEach(function(link){
    link.addEventListener('click', function(event){
      event.preventDefault();
      fetchModal(link.href, 'Detalle del producto');
    });
  });
});
</script>
