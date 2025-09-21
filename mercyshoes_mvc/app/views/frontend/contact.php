<?php $s=$settings; ?>
<h1>Contacto</h1>
<p>¿Tienes dudas o quieres un modelo especial? Escríbenos.</p>
<ul>
  <li>Correo: <a href="mailto:<?php echo htmlspecialchars($s['company_email']); ?>"><?php echo htmlspecialchars($s['company_email']); ?></a></li>
  <li>Teléfono: <?php echo htmlspecialchars($s['company_phone']); ?></li>
  <li>Dirección: <?php echo htmlspecialchars($s['company_address']); ?></li>
</ul>
