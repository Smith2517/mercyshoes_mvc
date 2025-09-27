<h1>Productos</h1>
<p>
  <a class="btn" href="<?php echo BASE_URL; ?>?r=admin/product_create">
    <span class="badge badge-primary">Nuevo producto</span>
  </a>
</p><table class="table">
  <thead><tr><th>#</th><th>Imagen</th><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Stock</th><th></th></tr></thead>
  <tbody>
  <?php foreach($products as $p): ?>
    <tr>
      <td><?php echo $p['id']; ?></td>
      <td><img src="<?php echo $p['image'] ?: 'public/assets/placeholder.jpg'; ?>" style="width:60px;height:60px;object-fit:cover;border-radius:8px"></td>
      <td><?php echo htmlspecialchars($p['name']); ?></td>
      <td><?php echo htmlspecialchars($p['category_name']); ?></td>
      <td>S/ <?php echo number_format($p['price'],2); ?></td>
      <td><?php echo (int)$p['stock']; ?></td>
      <td>
        <a class="btn light" href="<?php echo BASE_URL; ?>?r=admin/product_edit/<?php echo $p['id']; ?>">Editar</a>
        <a class="btn light" href="javascript:void(0)" onclick="confirmDelete('<?php echo BASE_URL; ?>?r=admin/product_delete/<?php echo $p['id']; ?>','¿Eliminar producto?')">Eliminar</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
