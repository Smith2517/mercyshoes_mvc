// public/assets/js/receipt-modal.js
// Abre SOLO el comprobante (?r=checkout/receipt/{id}) en el modal sin cambiar de página.
(function(){
  function $(s,c){ return (c||document).querySelector(s); }

  var overlay, content, titleEl, closeBtn;

  function openModal(){
    overlay.hidden = false;
    overlay.classList.add('active');
    document.body.classList.add('receipt-open');
  }
  function closeModal(){
    overlay.classList.remove('active');
    document.body.classList.remove('receipt-open');
    setTimeout(function(){ overlay.hidden = true; content.innerHTML=''; }, 150);
  }
  function ensurePartial(url){
    return url + (url.indexOf('?')>-1 ? '&' : '?') + 'partial=1';
  }
  function fetchHTML(url){
    return fetch(url, {
      headers: { 'X-Requested-With':'XMLHttpRequest' },
      credentials: 'same-origin'
    }).then(function(r){
      if(!r.ok) throw new Error('Network');
      return r.text();
    });
  }
  function loadReceipt(url){
    titleEl.textContent = 'Comprobante';
    content.innerHTML = '<p class="receipt-loading">Cargando comprobante…</p>';
    openModal();
    fetchHTML(ensurePartial(url))
      .then(function(html){
        content.innerHTML = html;
      })
      .catch(function(){
        content.innerHTML = '<p class="receipt-error">No se pudo cargar el comprobante. Intenta nuevamente.</p>';
      });
  }

  function init(){
    overlay = $('#receiptOverlay');
    if(!overlay) return; // por si esta vista no tiene el modal
    content = $('#receiptContent', overlay);
    titleEl = $('#receiptTitle', overlay);
    closeBtn = $('.receipt-close', overlay);

    // Cierre del modal
    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function(e){ if(e.target===overlay) closeModal(); });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape' && !overlay.hidden) closeModal(); });

    // Intercepta SOLO enlaces a ?r=checkout/receipt/{id}
    document.addEventListener('click', function(e){
      var a = e.target && e.target.closest ? e.target.closest('a') : null;
      if(!a) return;
      var href = a.getAttribute('href') || '';
      if(/\?r=checkout\/receipt\//.test(href)){
        e.preventDefault(); // evita navegación (no cambia de página)
        loadReceipt(href);  // carga parcial dentro del modal
      }
    }, true);
  }

  if(document.readyState==='loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
