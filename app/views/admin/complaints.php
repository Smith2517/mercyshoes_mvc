<h1>Libro de Reclamaciones</h1>
<p>Listado de registros enviados por los clientes desde el libro de reclamaciones.</p>

<?php if(empty($complaints)): ?>
  <p>No hay registros disponibles.</p>
<?php else: ?>
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Cliente</th>
          <th>Tipo</th>
          <th>Contacto</th>
          <th>Fecha</th>
          <th>Detalle</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($complaints as $row): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td>
              <strong><?php echo htmlspecialchars($row['full_name']); ?></strong><br>
              <?php if(!empty($row['document'])): ?>Documento: <?php echo htmlspecialchars($row['document']); ?><br><?php endif; ?>
              <?php if(!empty($row['order_code'])): ?>Pedido: <?php echo htmlspecialchars($row['order_code']); ?><?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($row['type']); ?></td>
            <td>
              <div><?php echo htmlspecialchars($row['email']); ?></div>
              <?php if(!empty($row['phone'])): ?><div><?php echo htmlspecialchars($row['phone']); ?></div><?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
