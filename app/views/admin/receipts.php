<h1>Comprobantes de Pago</h1>
<p>Visualiza los comprobantes de pago cargados por los clientes al finalizar su compra.</p>

<?php if(empty($orders)): ?>
  <p>No hay comprobantes registrados por el momento.</p>
<?php else: ?>
  <?php $baseUrl = rtrim(preg_replace('#/index\.php$#','', BASE_URL), '/'); ?>
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr><th>#</th><th>Cliente</th><th>Fecha</th><th>Total</th><th>Comprobante</th></tr>
      </thead>
      <tbody>
        <?php foreach($orders as $order): ?>
          <?php $receiptUrl = $baseUrl . '/' . ltrim($order['payment_receipt'], '/'); ?>
          <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
            <td><?php echo htmlspecialchars($order['created_at']); ?></td>
            <td>S/ <?php echo number_format($order['total'], 2); ?></td>
            <td>
              <a class="btn light" href="<?php echo htmlspecialchars($receiptUrl); ?>" target="_blank" rel="noopener">Ver imagen</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
