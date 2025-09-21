<h1>Pedidos</h1>
<table class="table">
  <thead><tr><th>#</th><th>Cliente</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th></tr></thead>
  <tbody>
  <?php foreach($orders as $o): ?>
    <tr>
      <td><?php echo $o['id']; ?></td>
      <td><?php echo htmlspecialchars($o['customer_name']); ?></td>
      <td><?php echo $o['created_at']; ?></td>
      <td>S/ <?php echo number_format($o['total'],2); ?></td>
      <td><?php echo htmlspecialchars($o['status']); ?></td>
      <td><a class="btn light" href="<?php echo BASE_URL; ?>?r=admin/order/<?php echo $o['id']; ?>">Ver</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
