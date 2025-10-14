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

<div class="checkout-layout">
  <form class="form checkout-form" method="post" action="<?php echo $payAction; ?>" enctype="multipart/form-data">

    <!-- Columna Izquierda: Datos del cliente + Comprobante (dentro del form) -->
    <h3>Datos del cliente</h3>
    <label>Nombre completo</label><input required name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
    <label>Correo</label><input type="email" required name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    <label>Teléfono</label><input name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
    <label>Dirección</label><textarea name="address" rows="3"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>

    <h3>Resumen</h3>
    <ul>
      <?php $total=0; foreach($cart as $c): $sub=$c['qty']*$c['price']; $total+=$sub; ?>
        <li><?php echo (int)$c['qty'].'× '.htmlspecialchars($c['name']).' — S/ '.number_format($sub,2); ?></li>
      <?php endforeach; ?>
    </ul>
    <p><strong>Total: S/ <?php echo number_format($total,2); ?></strong></p>
    <hr>
    
    <h3>Subir Comprobante</h3>
    <p style="margin:0 0 8px;font-size:14px;color:#555;">Adjunta la foto o captura del pago (formatos permitidos: JPG, PNG, WEBP).</p>
    <input type="file" class="file-input" name="payment_receipt" accept="image/png,image/jpeg,image/webp" required>

    <br><br>
    <button class="btn" type="submit">Confirmar y generar comprobante</button>

  </form>

  <!-- Columna Derecha: Resumen + Formas de pago (fuera del form, solo informativo) -->
  <div class="checkout-info">
    

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

