<?php
// ¿Es iframe? (viene con ?partial=1)
$inFrame = !empty($_GET['partial']);
$tgt = $inFrame ? 'cartFrame' : '_self';

// Construye ruta ABSOLUTA a /public sin index.php
$ASSETS_BASE = rtrim(preg_replace('#/index\.php$#','', BASE_URL), '/');
if ($inFrame) {
    echo '<link rel="stylesheet" href="'.$ASSETS_BASE.'/public/assets/css/styleproducts.css">';
    // Si tienes un CSS global adicional, descomenta:
    echo '<link rel="stylesheet" href="'.$ASSETS_BASE.'/public/assets/css/style.css">';
}
?>

<?php if(empty($cart)): ?>
  <p>Tu carrito está vacío.</p>
<?php else: ?>
  <form method="post" action="<?php echo BASE_URL; ?>?r=cart/update<?php echo $inFrame ? '&partial=1' : ''; ?>" target="<?php echo $tgt; ?>">
    <table class="table">
      <thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th><th></th></tr></thead>
      <tbody>
      <?php $total=0; foreach($cart as $id=>$c): $sub=$c['qty']*$c['price']; $total+=$sub; ?>
        <tr>
          <td><?php echo htmlspecialchars($c['name']); ?></td>
          <td><input type="number" min="0" name="qty[<?php echo $id; ?>]" value="<?php echo $c['qty']; ?>"></td>
          <td>S/ <?php echo number_format($c['price'],2); ?></td>
          <td>S/ <?php echo number_format($sub,2); ?></td>
          <td>
            <a href="<?php echo BASE_URL; ?>?r=cart/remove/<?php echo $id; ?><?php echo $inFrame ? '&partial=1':''; ?>" target="<?php echo $tgt; ?>">Quitar</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <div style="display:flex;justify-content:space-between;align-items:center">
      <div>
        <a class="btn light" href="<?php echo BASE_URL; ?>?r=cart/clear<?php echo $inFrame ? '&partial=1':''; ?>" target="<?php echo $tgt; ?>">Vaciar</a>
      </div>
      <div><strong>Total: S/ <?php echo number_format($total,2); ?></strong></div>
    </div>

    <p style="margin-top:10px">
      <button class="btn" type="submit">Actualizar cantidades</button>
      <a class="btn" href="<?php echo BASE_URL; ?>?r=checkout/form<?php echo $inFrame ? '&partial=1':''; ?>" target="<?php echo $tgt; ?>">Pagar</a>
    </p>
  </form>
<?php endif; ?>
