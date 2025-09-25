<?php if(empty($cart)): ?>
  <p>Tu carrito está vacío.</p>
<?php else: ?>
  <form method="post" action="<?php echo BASE_URL; ?>?r=cart/update" data-cart-form="update">
    <table class="table">
      <thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th><th></th></tr></thead>
      <tbody>
      <?php $total=0; foreach($cart as $id=>$c): $sub=$c['qty']*$c['price']; $total+=$sub; ?>
        <tr>
          <td><?php echo htmlspecialchars($c['name']); ?></td>
          <td><input type="number" min="0" name="qty[<?php echo $id; ?>]" value="<?php echo $c['qty']; ?>" data-cart-qty></td>
          <td>S/ <?php echo number_format($c['price'],2); ?></td>
          <td>S/ <?php echo number_format($sub,2); ?></td>
          <td><a href="<?php echo BASE_URL; ?>?r=cart/remove/<?php echo $id; ?>" data-cart-action="remove">Quitar</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div style="display:flex;justify-content:space-between;align-items:center">
      <div><a class="btn light" href="<?php echo BASE_URL; ?>?r=cart/clear" data-cart-action="clear">Vaciar</a></div>
      <div><strong>Total: S/ <?php echo number_format($total,2); ?></strong></div>
    </div>
    <p style="margin-top:10px">
      <button class="btn" type="submit" data-cart-update>Actualizar cantidades</button>
      <a class="btn" href="<?php echo BASE_URL; ?>?r=checkout/form">Pagar</a>
    </p>
  </form>
<?php endif; ?>
