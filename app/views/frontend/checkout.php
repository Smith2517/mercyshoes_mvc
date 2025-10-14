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

    <!-- Columna Izquierda: Datos del cliente + Comprobante (dentro del form) -->
    <h3>Datos del cliente</h3>
    <label>Nombre completo</label><input required name="name">
    <label>Correo</label><input type="email" required name="email">
    <label>Teléfono</label><input name="phone">
    <label>Dirección</label><textarea name="address" rows="3"></textarea>

    <h3>Resumen</h3>
    <ul>
      <?php $total=0; foreach($cart as $c): $sub=$c['qty']*$c['price']; $total+=$sub; ?>
        <li><?php echo (int)$c['qty'].'× '.htmlspecialchars($c['name']).' — S/ '.number_format($sub,2); ?></li>
      <?php endforeach; ?>
    </ul>
    <p><strong>Total: S/ <?php echo number_format($total,2); ?></strong></p>
    <hr>
    
    <h3>Subir Comprobante</h3>
    <label></label><input type="file" name="image" accept="image/*">

    <br><br>
    <button class="btn" type="submit">Confirmar y generar comprobante</button>

  </form>

  <!-- Columna Derecha: Resumen + Formas de pago (fuera del form, solo informativo) -->
  <div>
    

    <p><strong>Formas de pago: </strong></p>
    <img src="public/assets/yape.jpeg" alt="yape" style="display:block;margin:0 auto;max-width:180px;border-radius:8px">
    <p><strong>CAJA PIURA</strong></p>
    <p>20210011647022</p>
    <p>Ruth Mercy Carrasco Alarcón</p>
    <p><strong>BCP</strong></p>
    <p>43502965835010</p>
    <p>CCI: 00243510296583501061</p>
    <p>Ruth Mercy Carrasco Alarcón</p>
  </div>
</div>

