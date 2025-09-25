// Simple helpers
function confirmDelete(url, msg){ if(confirm(msg||'¿Eliminar?')){ window.location=url; } }
function printPage(){ window.print(); }

document.addEventListener('DOMContentLoaded', function(){
  const overlay = document.getElementById('modal-overlay');
  if(!overlay){ return; }

  const modalContent = overlay.querySelector('[data-modal-content]');
  const modalTitle = overlay.querySelector('[data-modal-title]');
  const closeBtn = overlay.querySelector('[data-modal-close]');
  const cartCountEl = document.querySelector('[data-cart-count]');
  const defaultCartTitle = 'Carrito de compras';

  function openModal(title){
    if(title !== undefined){ modalTitle.textContent = title; }
    overlay.hidden = false;
    overlay.classList.add('active');
    overlay.removeAttribute('hidden');
    document.body.classList.add('modal-open');
  }

  function closeModal(){
    overlay.classList.remove('active');
    overlay.hidden = true;
    overlay.setAttribute('hidden', 'hidden');
    document.body.classList.remove('modal-open');
    modalTitle.textContent = '';
    modalContent.innerHTML = '';
  }

  function setModalContent(html){
    modalContent.innerHTML = html;
  }

  function showError(message){
    setModalContent('<p class="modal-error">' + message + '</p>');
  }

  function updateCartCount(count){
    if(cartCountEl){ cartCountEl.textContent = count; }
  }

  function fetchCart(url, options){
    const fetchOptions = Object.assign({ method: 'GET' }, options || {});
    const headers = new Headers(fetchOptions.headers || {});
    headers.set('X-Requested-With', 'XMLHttpRequest');
    headers.set('Accept', 'application/json');
    fetchOptions.headers = headers;
    return fetch(url, fetchOptions).then(function(response){
      if(!response.ok){ throw new Error('network'); }
      const contentType = response.headers.get('content-type') || '';
      if(contentType.includes('application/json')){
        return response.json();
      }
      throw new Error('invalid');
    });
  }

  function loadCart(url, options, title){
    openModal(title || defaultCartTitle);
    setModalContent('<p class="modal-loading">Cargando...</p>');
    fetchCart(url, options).then(function(data){
      if(typeof data.count !== 'undefined'){ updateCartCount(data.count); }
      if(typeof data.html === 'string'){ setModalContent(data.html); }
      modalTitle.textContent = data.title || title || defaultCartTitle;
    }).catch(function(){
      showError('No se pudo cargar la información. Intenta nuevamente.');
    });
  }

  function loadHtmlModal(url, title){
    openModal(title || '');
    setModalContent('<p class="modal-loading">Cargando...</p>');
    fetch(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'text/html'
      }
    }).then(function(response){
      if(!response.ok){ throw new Error('network'); }
      return response.text();
    }).then(function(html){
      setModalContent(html);
      modalTitle.textContent = title || modalTitle.textContent;
    }).catch(function(){
      showError('No se pudo cargar la información. Intenta nuevamente.');
    });
  }

  if(closeBtn){ closeBtn.addEventListener('click', closeModal); }
  overlay.addEventListener('click', function(event){ if(event.target === overlay){ closeModal(); } });
  document.addEventListener('keydown', function(event){
    if(event.key === 'Escape' && !overlay.hidden){
      event.preventDefault();
      closeModal();
    }
  });

  document.addEventListener('click', function(event){
    const cartLink = event.target.closest('a[data-cart-action]');
    if(cartLink){
      event.preventDefault();
      loadCart(cartLink.href, null, cartLink.getAttribute('data-modal-title'));
      return;
    }
    const modalLink = event.target.closest('a[data-modal="detail"]');
    if(modalLink){
      event.preventDefault();
      loadHtmlModal(modalLink.href, modalLink.getAttribute('data-modal-title'));
    }
  });

  document.addEventListener('submit', function(event){
    const form = event.target.closest('form[data-cart-form="update"]');
    if(form){
      event.preventDefault();
      const formData = new FormData(form);
      loadCart(form.action, {
        method: (form.method || 'POST').toUpperCase(),
        body: formData
      }, form.getAttribute('data-modal-title'));
    }
  });

  if(modalContent){
    modalContent.addEventListener('change', function(event){
      const input = event.target.closest('input[data-cart-qty]');
      if(input){
        const form = input.closest('form[data-cart-form="update"]');
        if(form){
          const formData = new FormData(form);
          loadCart(form.action, {
            method: (form.method || 'POST').toUpperCase(),
            body: formData
          }, form.getAttribute('data-modal-title'));
        }
      }
    });
  }
});
