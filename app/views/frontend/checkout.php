<?php
// ¿Se está mostrando en modo parcial? (AJAX o ?partial=1)
$inPartial = !empty($_GET['partial']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest');

// Ruta ABSOLUTA a /public sin index.php
$ASSETS_BASE = rtrim(preg_replace('#/index\.php$#','', BASE_URL), '/');

if ($inPartial) {
    // Carga estilos con URL absoluta (sin index.php)
    echo '<link rel="stylesheet" href="'.$ASSETS_BASE.'/public/assets/css/styleproducts.css">';
    // Si tienes un CSS global adicional, descomenta:
    echo '<link rel="stylesheet" href="'.$ASSETS_BASE.'/public/assets/css/style.css">';
} else {
    // Vista normal con layout
    echo '<link rel="stylesheet" href="public/assets/css/styleproducts.css">';
}

$payAction = BASE_URL . '?r=checkout/pay' . ($inPartial ? '&partial=1' : '');
?>

<h1>Finalizar compra</h1>
<?php if(isset($error)): ?><div class="alert">⚠️ <?php echo htmlspecialchars($error); ?></div><?php endif; ?>

<div class="grid" style="grid-template-columns: 1.2fr .8fr; gap:20px">
  <form class="form" method="post" action="<?php echo $payAction; ?>">
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
        <li><?php echo (int)$c['qty'].'× '.htmlspecialchars($c['name']).' — S/ '.number_format($sub,2); ?></li>
      <?php endforeach; ?>
    </ul>
    <hr>
    <p><strong>Total: S/ <?php echo number_format($total,2); ?></strong></p>
    <p><em>Pago simulado (contra entrega / transferencia). Este demo no integra pasarela.</em></p>
  </div>
</div>
