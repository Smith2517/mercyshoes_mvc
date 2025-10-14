<h1>Libro de Reclamaciones</h1>
<p>En cumplimiento de la normativa vigente, puedes registrar aquí tu reclamo o queja. Nuestro equipo revisará tu solicitud y se comunicará contigo en un plazo máximo de 48 horas hábiles.</p>

<?php if(!empty($error)): ?>
  <div class="alert">⚠️ <?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if(!empty($success)): ?>
  <div class="alert" style="border-left-color:#16a34a;">✅ <?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<?php $oldData = $old ?? []; ?>
<form class="form" method="post" action="<?php echo BASE_URL; ?>?r=home/complaint_submit">
  <label>Nombre completo*</label>
  <input name="full_name" required value="<?php echo htmlspecialchars($oldData['full_name'] ?? ''); ?>">

  <label>Documento de identidad</label>
  <input name="document" value="<?php echo htmlspecialchars($oldData['document'] ?? ''); ?>">

  <label>Correo electrónico*</label>
  <input type="email" name="email" required value="<?php echo htmlspecialchars($oldData['email'] ?? ''); ?>">

  <label>Teléfono de contacto</label>
  <input name="phone" value="<?php echo htmlspecialchars($oldData['phone'] ?? ''); ?>">

  <label>Nº de pedido (opcional)</label>
  <input name="order_code" value="<?php echo htmlspecialchars($oldData['order_code'] ?? ''); ?>">

  <label>Tipo de registro</label>
  <?php $type = $oldData['type'] ?? 'Reclamo'; ?>
  <select name="type">
    <?php foreach(['Reclamo','Queja','Consulta'] as $option): ?>
      <option value="<?php echo $option; ?>" <?php if($type === $option) echo 'selected'; ?>><?php echo $option; ?></option>
    <?php endforeach; ?>
  </select>

  <label>Detalle*</label>
  <textarea name="description" rows="5" required><?php echo htmlspecialchars($oldData['description'] ?? ''); ?></textarea>

  <button class="btn" type="submit">Enviar registro</button>
</form>
