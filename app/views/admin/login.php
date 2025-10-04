  <link rel="stylesheet" href="public/assets/css/stylesadmin.css">
<div class="form" style="max-width:420px;margin:40px auto">
  <h2>Ingresar al cPanel</h2>
  <?php if(isset($error)): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
  <form method="post" action="<?php echo BASE_URL; ?>?r=admin/doLogin">
    <label>Correo</label><input name="email" type="email" required>
    <label>Contraseña</label><input name="password" type="password" required>
    <button class="btn" type="submit">Entrar</button>
  </form>
  <!-- <p>Usuario demo: <code>admin@mercyshoes.local</code> — Contraseña: <code>admin123</code></p> -->
</div>
