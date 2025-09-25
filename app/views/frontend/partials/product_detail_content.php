<div class="grid" style="grid-template-columns: 1fr 1fr; gap: 24px;">
  <div>
    <img src="<?php echo $product['image'] ?: 'public/assets/placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width:100%;height:420px;object-fit:cover;border-radius:16px">
  </div>
  <div>
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    <p>Stock: <strong><?php echo (int)$product['stock']; ?></strong></p>
    <div class="price">S/ <?php echo number_format($product['price'],2); ?></div>
    <a class="btn" href="<?php echo BASE_URL; ?>?r=cart/add/<?php echo $product['id']; ?>">Añadir al carrito</a>
  </div>
</div>
