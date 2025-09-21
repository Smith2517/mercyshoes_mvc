<h1>Ajustes</h1>
<form class="form" method="post" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>?r=admin/settings_save">
  <input type="hidden" name="id" value="<?php echo $settings['id']; ?>">
  <label>Nombre de la empresa</label><input name="company_name" value="<?php echo htmlspecialchars($settings['company_name']); ?>">
  <label>RUC</label><input name="company_ruc" value="<?php echo htmlspecialchars($settings['company_ruc']); ?>">
  <label>Correo</label><input name="company_email" value="<?php echo htmlspecialchars($settings['company_email']); ?>">
  <label>Teléfono</label><input name="company_phone" value="<?php echo htmlspecialchars($settings['company_phone']); ?>">
  <label>Dirección</label><input name="company_address" value="<?php echo htmlspecialchars($settings['company_address']); ?>">
  <label>Logo</label><input type="file" name="logo" accept="image/*">
  <?php if($settings['logo_path']): ?><p><img src="<?php echo $settings['logo_path']; ?>" style="height:80px"></p><?php endif; ?>
  <button class="btn" type="submit">Guardar</button>
</form>
