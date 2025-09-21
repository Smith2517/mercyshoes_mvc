<?php
$badge = [
  'PENDIENTE'=>'badge warn',
  'PAGADO'=>'badge success',
  'ENVIADO'=>'badge success',
  'CANCELADO'=>'badge danger'
][$order['status']];
?>
<div class="form">
  <div style="display:flex;justify-content:space-between;align-items:center">
    <h2>Comprobante #<?php echo $order['id']; ?></h2>
    <span class="<?php echo $badge; ?>"><?php echo $order['status']; ?></span>
  </div>
  <p><strong><?php echo htmlspecialchars($settings['company_name']); ?></strong><br>
  RUC: <?php echo htmlspecialchars($settings['company_ruc']); ?><br>
  <?php echo htmlspecialchars($settings['company_address']); ?><br>
  Tel: <?php echo htmlspecialchars($settings['company_phone']); ?> — <?php echo htmlspecialchars($settings['company_email']); ?></p>

  <p><strong>Cliente:</strong> <?php echo htmlspecialchars($order['customer_name']); ?><br>
  <strong>Fecha:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>

  <table class="table">
    <thead><tr><th>Producto</th><th>Cant.</th><th>P. Unit</th><th>Subtotal</th></tr></thead>
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
  <p style="text-align:right"><strong>Total: S/ <?php echo number_format($order['total'],2); ?></strong></p>
  <p><button class="btn light" onclick="printPage()">Imprimir / Guardar PDF</button>
  <a class="btn" href="<?php echo BASE_URL; ?>">Seguir comprando</a></p>
</div>
