<?php
// ==== RECIBO (PARCIAL PARA MODAL) ====
// No <html>, no overlay, no JS. Solo contenido estilado para el modal.

$badgeClass = [
  'PENDIENTE' => 'badge warn',
  'PAGADO'    => 'badge success',
  'ENVIADO'   => 'badge success',
  'CANCELADO' => 'badge danger'
][$order['status']] ?? 'badge';

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
      <button class="btn light" onclick="window.print()">Imprimir / Guardar PDF</button>
      <a class="btn primary" href="<?php echo BASE_URL; ?>">Seguir comprando</a>
    </p>
  </div>
</div>
