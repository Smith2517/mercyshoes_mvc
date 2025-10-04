
<h1>Categorías</h1>
<div class="grid" style="grid-template-columns:1fr 2fr;gap:16px">
  <form class="form" method="post" action="<?php echo BASE_URL; ?>?r=admin/category_store">
    <h3>Nueva categoría</h3>
    <label>Nombre</label><input name="name" required>
    <label>Descripción</label><textarea name="description" rows="3"></textarea>
    <button class="btn" type="submit">Crear</button>
  </form>
  <div class="form">
    <h3>Listado</h3>
    <div class="table-wrap">
    <table class="table">
      <thead><tr><th>#</th><th>Nombre</th><th>Descripción</th><th></th></tr></thead>
      <tbody>
        <?php foreach($cats as $c): ?>
          <tr>
            <td><?php echo $c['id']; ?></td>
            <td><?php echo htmlspecialchars($c['name']); ?></td>
            <td><?php echo htmlspecialchars($c['description']); ?></td>
            <td>
              <form style="display:inline" method="post" action="<?php echo BASE_URL; ?>?r=admin/category_update/<?php echo $c['id']; ?>">
                <input name="name" value="<?php echo htmlspecialchars($c['name']); ?>">
                <input name="description" value="<?php echo htmlspecialchars($c['description']); ?>">
                <button class="btn light" type="submit" >Actualizar</button>
              </form>
              <a class="btn light" href="javascript:void(0)" onclick="confirmDelete('<?php echo BASE_URL; ?>?r=admin/category_delete/<?php echo $c['id']; ?>','¿Eliminar categoría?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
  </div>
</div>
