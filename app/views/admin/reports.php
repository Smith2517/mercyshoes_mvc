<h1>Reportes</h1>
<div class="form">
  <h3>Ventas por mes</h3>
  <table class="table">
    <thead><tr><th>Mes</th><th>Pedidos</th><th>Total (S/)</th></tr></thead>
    <tbody>
      <?php foreach($rows as $r): ?>
        <tr><td><?php echo $r['ym']; ?></td><td><?php echo $r['pedidos']; ?></td><td><?php echo number_format($r['total'],2); ?></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
