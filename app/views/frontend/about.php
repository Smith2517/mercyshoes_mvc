<?php $s=$settings; ?>
<h1>Sobre nosotros</h1>
<p><?php echo htmlspecialchars($s['company_name']); ?> nació con la misión de ofrecer calzado de calidad al mejor precio. En esta sección puedes actualizar el contenido desde el cPanel (Ajustes).</p>
<ul>
  <li>Correo: <?php echo htmlspecialchars($s['company_email']); ?></li>
  <li>Teléfono: <?php echo htmlspecialchars($s['company_phone']); ?></li>
  <li>Dirección: <?php echo htmlspecialchars($s['company_address']); ?></li>
</ul>
