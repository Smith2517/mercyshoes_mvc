<h1>Finalizar compra</h1>
<?php if(isset($error)): ?><div class="alert">⚠️ <?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<div class="grid" style="grid-template-columns: 1.2fr .8fr; gap:20px">
  <form class="form" method="post" action="<?php echo BASE_URL; ?>?r=checkout/pay">
    <h3>Datos del cliente</h3>
    <label>Nombre completo</label><input required name="name">
    <label>Correo</label><input type="email" required name="email">
    <label>Teléfono</label><input name="phone">
    <label>Dirección</label><textarea name="address" rows="3"></textarea>
    <button class="btn" type="submit">Confirmar y generar comprobante</button>
  </form>
  <div class="form">
    <h3>Resumen</h3>
    <ul>
      <?php $total=0; foreach($cart as $c): $sub=$c['qty']*$c['price']; $total+=$sub; ?>
        <li><?php echo $c['qty'].'× '.htmlspecialchars($c['name']).' — S/ '.number_format($sub,2); ?></li>
      <?php endforeach; ?>
    </ul>
    <hr>
    <p><strong>Total: S/ <?php echo number_format($total,2); ?></strong></p>
    <p><em>Pago simulado (contra entrega / transferencia). Este demo no integra pasarela.</em></p>
  </div>
</div>
