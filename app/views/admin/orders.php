<h1>Pedidos</h1>
<table class="table">
  <thead><tr><th>#</th><th>Cliente</th><th>Fecha</th><th>Total</th><th>Estado</th><th>Comprobante</th><th>Detalle</th></tr></thead>
  <tbody>
  <?php foreach($orders as $o): ?>
    <tr>
      <td><?php echo $o['id']; ?></td>
      <td><?php echo htmlspecialchars($o['customer_name']); ?></td>
      <td><?php echo $o['created_at']; ?></td>
      <td>S/ <?php echo number_format($o['total'],2); ?></td>
      <td data-status="<?php echo htmlspecialchars($o['status']); ?>"><?php echo htmlspecialchars($o['status']); ?></td>
      <td>
        <?php if(!empty($o['payment_receipt'])): ?>
          <?php $receiptUrl = rtrim(preg_replace('#/index\.php$#','', BASE_URL), '/') . '/' . ltrim($o['payment_receipt'],'/'); ?>
          <a class="btn light" href="<?php echo htmlspecialchars($receiptUrl); ?>" target="_blank" rel="noopener">Ver</a>
        <?php else: ?>
          —
        <?php endif; ?>
      </td>
      <td><a class="btn light" href="<?php echo BASE_URL; ?>?r=admin/order/<?php echo $o['id']; ?>">Ver</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
