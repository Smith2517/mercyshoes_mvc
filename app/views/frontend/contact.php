<?php $s=$settings; ?>

<section class="contacto">
  <h1 class="titulo-contacto">Contacto</h1>
  <p class="intro-contacto">¿Tienes dudas o quieres un modelo especial? Escríbenos y con gusto te atenderemos.</p>

  <div class="cards-contacto">
    <div class="card">
      <h3>📧 Correo</h3>
      <p>
        <a href="mailto:<?php echo htmlspecialchars($s['company_email']); ?>">
          <?php echo htmlspecialchars($s['company_email']); ?>
        </a>
      </p>
    </div>

    <div class="card">
      <h3>📞 Teléfono</h3>
      <p><?php echo htmlspecialchars($s['company_phone']); ?></p>
    </div>

    <div class="card">
      <h3>📍 Dirección</h3>
      <p><?php echo htmlspecialchars($s['company_address']); ?></p>
    </div>
  </div>
</section>
