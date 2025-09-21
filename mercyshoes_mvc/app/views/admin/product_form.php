<h1><?php echo isset($p)?'Editar':'Nuevo'; ?> producto</h1>
<form class="form" method="post" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>?r=<?php echo isset($p)?'admin/product_update/'.$p['id']:'admin/product_store'; ?>">
  <label>Nombre</label><input name="name" required value="<?php echo htmlspecialchars($p['name'] ?? ''); ?>">
  <label>Categoría</label>
  <select name="category_id">
    <?php foreach($cats as $c): ?>
      <option value="<?php echo $c['id']; ?>" <?php if(isset($p) && $p['category_id']==$c['id']) echo 'selected'; ?>><?php echo htmlspecialchars($c['name']); ?></option>
    <?php endforeach; ?>
  </select>
  <label>Descripción</label><textarea name="description" rows="4"><?php echo htmlspecialchars($p['description'] ?? ''); ?></textarea>
  <div style="display:flex;gap:12px">
    <div style="flex:1">
      <label>Precio (S/)</label><input name="price" type="number" min="0" step="0.01" required value="<?php echo htmlspecialchars($p['price'] ?? '0'); ?>">
    </div>
    <div style="flex:1">
      <label>Stock</label><input name="stock" type="number" min="0" required value="<?php echo htmlspecialchars($p['stock'] ?? '0'); ?>">
    </div>
  </div>
  <label>Imagen</label><input type="file" name="image" accept="image/*">
  <?php if(isset($p) && $p['image']): ?><p><img src="<?php echo $p['image']; ?>" style="height:80px;border-radius:8px"></p><?php endif; ?>
  <button class="btn" type="submit">Guardar</button>
  <a class="btn light" href="<?php echo BASE_URL; ?>?r=admin/products">Volver</a>
</form>
