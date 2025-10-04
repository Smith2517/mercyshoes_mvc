<?php
// ==== RECIBO (PARCIAL PARA MODAL O PÁGINA LIMPIA) ====
// Este view funciona en 3 modos:
// - Modal/AJAX (partial=1): se embebe en el checkout
// - Página normal (sin partial): se ve dentro del layout general
// - Página limpia auto-imprimible (partial=1&autoprint=1): abre 1 hoja y lanza print()

$badgeClass = [
  'PENDIENTE' => 'badge warn',
  'PAGADO'    => 'badge success',
  'ENVIADO'   => 'badge success',
  'CANCELADO' => 'badge danger'
][$order['status']] ?? 'badge';

$ASSETS_BASE = rtrim(preg_replace('#/index\.php$#','', BASE_URL), '/');
$inPartial   = !empty($_GET['partial']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest');
$autoPrint   = !empty($_GET['autoprint']); // si viene, abrimos en blanco y disparamos print()

// Cuando abrimos en ventana limpia, entregamos un HTML mínimo sin el layout del sitio
if ($inPartial && $autoPrint) {
  ?><!doctype html>
  <html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Comprobante #<?php echo (int)$order['id']; ?></title>

    <!-- Estilos mínimos solo para el comprobante -->
    <style>
      /* Base */
      body{margin:0;background:#fff;font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;color:#111}
      .receipt-wrap{padding:16px;}
      .receipt-wrap .table{width:100%;border-collapse:collapse;margin-top:12px}
      .receipt-wrap .table th,.receipt-wrap .table td{border:1px solid #e5e7eb;padding:8px 10px}
      .receipt-wrap .table th{background:#f8fafc;text-align:left}
      .receipt-wrap .badge{display:inline-block;padding:4px 10px;border-radius:999px;font-weight:700;font-size:12px}
      .receipt-wrap .badge.warn{background:#fff3cd;color:#664d03}
      .receipt-wrap .badge.success{background:#d1fae5;color:#065f46}
      .receipt-wrap .badge.danger{background:#fee2e2;color:#991b1b}
      .receipt-wrap .header-line{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}

      /* impresión 1 sola página (si cabe) */
      @media print{
        @page{size:A4;margin:12mm}
        .receipt-wrap .btn{display:none!important}
      }
    </style>
  </head>
  <body>
  <?php
}

// ----------- CONTENIDO DEL COMPROBANTE (se reutiliza en los 3 modos) -----------
?>
<style>
  /* Estilos mínimos, acotados al recibo (no pisan el resto) */
  .receipt-wrap { font-family: inherit; color:#111; }
  .receipt-wrap .table{width:100%;border-collapse:collapse;margin-top:12px}
  .receipt-wrap .table th,.receipt-wrap .table td{border:1px solid #e5e7eb;padding:8px 10px}
  .receipt-wrap .table th{background:#f8fafc;text-align:left}
  .receipt-wrap .badge{display:inline-block;padding:4px 10px;border-radius:999px;font-weight:700;font-size:12px}
  .receipt-wrap .badge.warn{background:#fff3cd;color:#664d03}
  .receipt-wrap .badge.success{background:#d1fae5;color:#065f46}
  .receipt-wrap .badge.danger{background:#fee2e2;color:#991b1b}
  .receipt-wrap .btn{display:inline-block;padding:10px 16px;border-radius:8px;text-decoration:none;border:1px solid transparent;cursor:pointer}
  .receipt-wrap .btn.light{background:#f3f4f6;border-color:#e5e7eb;color:#111}
  .receipt-wrap .btn.primary{background:#111;color:#fff}
  .receipt-wrap .header-line{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}

  /* --- Respaldo: si alguien imprime esta vista dentro del layout, oculta todo salvo el recibo --- */
  @media print {
    html,body{background:#fff!important;margin:0!important;padding:0!important}
    /* Oculta todo lo que no sea el recibo ni sus padres */
    body *:not(.receipt-wrap):not(.receipt-wrap *):not(:has(.receipt-wrap)){
      display:none!important;background:none!important;box-shadow:none!important;
    }
    .receipt-wrap{display:block!important;margin:0 auto!important;width:180mm!important;max-width:100%!important;background:#fff!important;border:0!important;box-shadow:none!important}
    .receipt-wrap table{display:table!important;width:100%!important;border-collapse:collapse!important;page-break-inside:auto}
    .receipt-wrap thead{display:table-header-group!important}
    .receipt-wrap tr,.receipt-wrap th,.receipt-wrap td{page-break-inside:avoid}
    .receipt-wrap .btn{display:none!important}
    @page{size:A4;margin:12mm}
  }
</style>

<div class="receipt-wrap">
  <div class="form" style="background:#fff;border-radius:12px">
    <div class="header-line">
      <h2 style="margin:0">Comprobante #<?php echo (int)$order['id']; ?></h2>
      <span class="<?php echo $badgeClass; ?>"><?php echo htmlspecialchars($order['status']); ?></span>
    </div>

    <p style="margin:12px 0 0">
      <strong><?php echo htmlspecialchars($settings['company_name']); ?></strong><br>
      RUC: <?php echo htmlspecialchars($settings['company_ruc']); ?><br>
      <?php echo htmlspecialchars($settings['company_address']); ?><br>
      Tel: <?php echo htmlspecialchars($settings['company_phone']); ?> — <?php echo htmlspecialchars($settings['company_email']); ?>
    </p>

    <p style="margin:12px 0">
      <strong>Cliente:</strong> <?php echo htmlspecialchars($order['customer_name']); ?><br>
      <strong>Fecha:</strong> <?php echo htmlspecialchars($order['created_at']); ?>
    </p>

    <table class="table">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cant.</th>
          <th>P. Unit</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($items as $it): ?>
          <tr>
            <td><?php echo htmlspecialchars($it['name']); ?></td>
            <td><?php echo (int)$it['quantity']; ?></td>
            <td>S/ <?php echo number_format($it['unit_price'],2); ?></td>
            <td>S/ <?php echo number_format($it['subtotal'],2); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <p style="text-align:right;margin:12px 0">
      <strong>Total: S/ <?php echo number_format($order['total'],2); ?></strong>
    </p>

    <p style="display:flex;gap:8px;flex-wrap:wrap">
      <!-- En checkout (modal), este link abre una página limpia que auto-imprime -->
      <a class="btn light" href="<?php echo BASE_URL; ?>?r=checkout/receipt/<?php echo (int)$order['id']; ?>&partial=1&autoprint=1" target="_blank" rel="noopener">Imprimir / Guardar PDF</a>
  
    </p>
  </div>
</div>

<?php
// Si estamos en la página limpia, dispara el print automáticamente y cierra
if ($inPartial && $autoPrint) {
  ?>
  <script>
    // Auto-imprimir cuando la página termina de dibujar
    (function(){ 
      try {
        window.addEventListener('load', function(){
          window.focus();
          window.print();
          // Cierra la ventana si el navegador lo permite
          setTimeout(function(){ window.close(); }, 300);
        });
      } catch(e){}
    })();
  </script>
  </body></html>
  <?php
}
