<h1>Pedido #<?php echo $order['id']; ?></h1>
<p><strong>Cliente:</strong> <?php echo htmlspecialchars($order['customer_name']); ?> — <?php echo htmlspecialchars($order['customer_email']); ?></p>
<p><strong>Dirección:</strong> <?php echo htmlspecialchars($order['customer_address']); ?> | <strong>Tel:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
<table class="table">
<thead><tr><th>Producto</th><th>Cant.</th><th>P.Unit</th><th>Subtotal</th></tr></thead>
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

<form method="post" action="<?php echo BASE_URL; ?>?r=admin/status">
  <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
  <label>Cambiar estado:</label>
  <select name="status">
    <?php foreach(['PENDIENTE','PAGADO','ENVIADO','CANCELADO'] as $s): ?>
      <option value="<?php echo $s; ?>" <?php if($order['status']==$s) echo 'selected'; ?>><?php echo $s; ?></option>
    <?php endforeach; ?>
  </select>
  <button class="btn" type="submit">Guardar</button>
</form>
<p><a class="btn light" href="<?php echo BASE_URL; ?>?r=checkout/receipt/<?php echo $order['id']; ?>">Ver comprobante</a></p>
