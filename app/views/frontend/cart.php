<h1>Carrito</h1>
<?php include __DIR__ . '/partials/cart_content.php'; ?>

<!-- ========= MODAL CARRITO (agregado al final) ========= -->
<style>
  [hidden]{display:none!important}
  .cart-overlay{position:fixed;inset:0;display:grid;place-items:center;background:rgba(0,0,0,.5);z-index:9999;opacity:0;pointer-events:none;transition:opacity .16s}
  .cart-overlay.open{opacity:1;pointer-events:auto}
  .cart-modal{width:min(920px,95vw);max-height:80vh;background:#fff;color:#111;border-radius:12px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.35);transform:translateY(10px);opacity:0;transition:transform .16s,opacity .16s}
  .cart-modal.open{transform:translateY(0);opacity:1}
  .cart-head{display:flex;justify-content:space-between;align-items:center;padding:12px 16px;border-bottom:1px solid #e5e7eb;background:#f9fafb}
  .cart-close{background:#eee;border:0;padding:6px 10px;border-radius:8px;cursor:pointer}
  .cart-frame{width:100%;height:calc(80vh - 54px);border:0;display:block}
</style>

<div id="cartOverlay" class="cart-overlay" hidden>
  <div id="cartModal" class="cart-modal" role="dialog" aria-modal="true">
    <div class="cart-head">
      <strong>Carrito</strong>
      <button id="cartClose" class="cart-close">Cerrar</button>
    </div>
    <iframe id="cartFrame" name="cartFrame" class="cart-frame" src="about:blank" title="Carrito"></iframe>
  </div>
</div>

<script>
(function(){
  var overlay=document.getElementById('cartOverlay');
  var modal=document.getElementById('cartModal');
  var frame=document.getElementById('cartFrame');
  var closeBtn=document.getElementById('cartClose');

  function open(){ overlay.hidden=false; overlay.classList.add('open'); modal.classList.add('open'); }
  function close(){ overlay.classList.remove('open'); modal.classList.remove('open'); setTimeout(()=>overlay.hidden=true,160); }
  closeBtn.addEventListener('click',function(e){e.preventDefault();close();});
  overlay.addEventListener('click',function(e){ if(e.target===overlay) close(); });

  document.addEventListener('click',function(e){
    var a=e.target.closest && e.target.closest('a'); if(!a) return;
    var href=a.getAttribute('href')||'';

    if(/\?r=cart\/add\//.test(href)){
      e.preventDefault();
      var addUrl = href + (href.includes('?')?'&':'?') + 'partial=1';
      frame.src = addUrl;
      frame.addEventListener('load', function onAdd(){
        frame.removeEventListener('load', onAdd);
        frame.src = '<?php echo BASE_URL; ?>?r=cart/view&partial=1';
        open();
      }, { once:true });
      return;
    }

    if(/\?r=cart(\/|$)/.test(href)){
      e.preventDefault();
      var vurl = href + (href.includes('partial=1')?'':(href.includes('?')?'&':'?')+'partial=1');
      frame.src = vurl;
      open();
      return;
    }

    if(/\?r=checkout\/form/.test(href)){
      e.preventDefault();
      var ck = href + (href.includes('partial=1')?'':(href.includes('?')?'&':'?')+'partial=1');
      frame.src = ck;
      open();
      return;
    }
  }, true);
})();
</script>
<!-- ======== FIN MODAL CARRITO ======== -->
