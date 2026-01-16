<?php
session_start();
include 'config/database.php';

$query = mysqli_query($conn, "
  SELECT 
    c.name AS category_name,
    p.id AS product_order_id,
    p.name AS product_name,
    p.image,
    v.id AS variant_id,
    v.variant_name,
    v.price_per_day
  FROM categories c
  JOIN products_order p ON p.category_id = c.id
  JOIN product_order_variants v ON v.product_order_id = p.id
  ORDER BY c.name, p.name
");

$categories = [];

while ($row = mysqli_fetch_assoc($query)) {
  $categories[$row['category_name']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Order Barang | Spektrum</title>
  <link rel="stylesheet" href="./style/order.css">
  <link rel="stylesheet" href="./style/modal.css">
  <script src="./js/order.js" defer></script>
  <script src="./js/modal.js"></script>
</head>
<body>

<div class="order-container">
  <h1>Order Barang</h1>

  <?php foreach ($categories as $category => $items): ?>
    <div class="category">

      <?php
      $currentProduct = null;
      foreach ($items as $item):
        if ($currentProduct != $item['product_order_id']):
          if ($currentProduct !== null) echo "</div></div>";
          $currentProduct = $item['product_order_id'];
      ?>
        <div class="product-card">

          <div class="variant-list">
            <h3><?= $item['product_name'] ?></h3>
      <?php endif; ?>

      
        <div class="variant">
          <span><?= $item['variant_name'] ?></span>
          <span class="price">Rp <?= number_format($item['price_per_day']) ?>/hari</span>
          <button class="btn"
  onclick="openOrderModal(
    <?= $item['variant_id'] ?>,
    '<?= $item['product_name'] ?>',
    '<?= $item['variant_name'] ?>',
    <?= $item['price_per_day'] ?>
  )">
  Order
</button>

        </div>

      <?php endforeach; ?>
          </div>
        </div>
    </div>
  <?php endforeach; ?>

</div>

<!-- Popup Modal Untuk Add Unit dan Lama Sewa -->

  <div id="orderModal" class="modal">
    <div class="modal-box">
      <h3 id="modalTitle"></h3>

      <label>Jumlah Unit</label>
      <input type="number" id="qty" min="1" value="1">

      <label>Lama Sewa (hari)</label>
      <input type="number" id="days" min="1" value="1">

      
      <div class="modal-actions">
        <button onclick="closeModal()">Cancel</button>
        <button onclick="addToCart()">Add to Cart</button>
      </div>
    </div>
  </div>

<div class="cart-container">
  <h2>Keranjang Anda</h2>

  <?php if (!empty($_SESSION['cart'])): ?>
    <table>
      <tr>
        <th>Barang</th>
        <th>Unit</th>
        <th>Hari</th>
        <th>Subtotal</th>
      </tr>

      <?php
      $total = 0;
      foreach ($_SESSION['cart'] as $item):
        $sub = $item['price'] * $item['qty'] * $item['days'];
        $total += $sub;
      ?>
      <tr>
        <td><?= $item['name'] ?></td>
        <td><?= $item['qty'] ?></td>
        <td><?= $item['days'] ?></td>
        <td>Rp <?= number_format($sub) ?></td>
      </tr>
      <?php endforeach; ?>

      <tr>
        <td colspan="3"><b>Total</b></td>
        <td><b>Rp <?= number_format($total) ?></b></td>
      </tr>
    </table>

    <form action="checkout.php" method="POST">
      <label>Tanggal Mulai</label>
      <input type="date" name="start_date" required>

      <label>Tanggal Selesai</label>
      <input type="date" name="end_date" required>

      <button>Order Sekarang</button>
    </form>

  <?php else: ?>
    <p>Keranjang masih kosong</p>
  <?php endif; ?>
</div>

<!-- LOGIN MODAL -->
<div id="loginModal" class="modal-overlay">
  <div class="modal-box">
    <span class="close-btn" onclick="closeLoginModal()">×</span>

    <h2>Login untuk Melanjutkan</h2>
    <p>Silakan login agar bisa melakukan pemesanan</p>

    <form id="loginForm">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>

      <button type="submit">Login</button>
    </form>

    <p class="register-text">
      Belum punya akun?
      <a href="./user_login/userregister.php">Daftar sekarang</a>
    </p>

    <div id="loginError"></div>
  </div>
</div>

</body>
</html>
