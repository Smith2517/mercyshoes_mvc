// public/assets/js/cart-modal.js
// Abre un único modal con un <iframe name="cartFrame"> y direcciona
// "Añadir", "Ver Carrito" y "Checkout" para que siempre se carguen dentro del iframe.

(function () {
  var BASE = (window.BASE_URL || '').replace(/\/+$/,'');
  var overlay = document.getElementById('cartOverlay');
  var modal   = document.getElementById('cartModal');
  var frame   = document.getElementById('cartFrame');
  var closeBtn= document.getElementById('cartClose');

  if(!overlay || !modal || !frame || !closeBtn){ return; }

  function open(){ overlay.hidden=false; overlay.classList.add('open'); modal.classList.add('open'); }
  function close(){ overlay.classList.remove('open'); modal.classList.remove('open'); setTimeout(()=>overlay.hidden=true,160); }

  closeBtn.addEventListener('click', function(e){ e.preventDefault(); close(); });
  overlay.addEventListener('click', function(e){ if(e.target===overlay) close(); });

  // Interceptar "Añadir", "Ver Carrito" y "Checkout" para abrir en el iframe
  document.addEventListener('click', function(e){
    var a = e.target.closest && e.target.closest('a'); if(!a) return;
    var href = a.getAttribute('href') || '';

    // 1) Añadir al carrito: cargar add&partial=1 dentro del iframe y luego ver&partial=1
    if (/\?r=cart\/add\//.test(href)) {
      e.preventDefault();
      var addUrl = href + (href.includes('?') ? '&' : '?') + 'partial=1';
      frame.src = addUrl;
      frame.addEventListener('load', function onAdd(){
        frame.removeEventListener('load', onAdd);
        frame.src = BASE + '?r=cart/view&partial=1';
        open();
      }, { once:true });
      return;
    }

    // 2) Ver carrito directo
    if (/\?r=cart(\/|$)/.test(href)) {
      e.preventDefault();
      var vurl = href + (href.includes('?') ? '&' : '?') + (href.includes('partial=1')?'':'partial=1');
      frame.src = vurl;
      open();
      return;
    }

    // 3) Checkout dentro del modal
    if (/\?r=checkout\/form/.test(href)) {
      e.preventDefault();
      var ck = href + (href.includes('?') ? '&' : '?') + (href.includes('partial=1')?'':'partial=1');
      frame.src = ck;
      open();
      return;
    }
  }, true);
})();
