<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
include '../config/database.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Spektrum</title>
  <link rel="stylesheet" href="admin.css">
  <script src="admin.js" defer></script>
</head>
<body>

<div class="admin-wrapper">
<h1>Admin Dashboard Spektrum</h1>

<!-- ================= TAMBAH PRODUK ================= -->
<div class="card">
<h2>Tambah Produk</h2>
<form method="POST" enctype="multipart/form-data">
  <input type="text" name="p_nama" placeholder="Nama Produk" required>
  <input type="text" name="p_category" placeholder="Kategori" required>
  <input type="file" name="p_image" required>
  <button name="add_product">Simpan Produk</button>
</form>
</div>

<?php
if (isset($_POST['add_product'])) {
  $name = $_POST['p_nama'];
  $cat  = $_POST['p_category'];
  $img  = time().'_'.$_FILES['p_image']['nama'];

  move_uploaded_file($_FILES['p_image']['tmp_name'], "../uploads/".$img);
  mysqli_query($conn, "INSERT INTO products (nama, category, image) VALUES ('$name','$cat','$img')");
  header("Location: admin.php");
}
?>

<!-- ================= DAFTAR PRODUK ================= -->
<div class="card">
<h2>Daftar Produk</h2>

<table>
<tr>
  <th>Image</th>
  <th>Nama</th>
  <th>Kategori</th>
  <th>Action</th>
</tr>

<?php
$products = mysqli_query($conn, "SELECT * FROM products");
while ($p = mysqli_fetch_assoc($products)):
?>
<tr>
  <th><img src="../uploads/<?= $p['image'] ?>" width="70"></th>

  <th contenteditable="true"
      class="editable-product"
      data-id="<?= $p['id'] ?>"
      data-field="nama">
    <?= $p['nama'] ?>
  </th>

  <th contenteditable="true"
      class="editable-product"
      data-id="<?= $p['id'] ?>"
      data-field="category">
    <?= $p['category'] ?>
  </th>

<th>
  <button onclick="saveProduct(<?= $p['id'] ?>)">Save</button>
  <button type="button" onclick="openImageModal(<?= $p['id'] ?>)">
  Edit Image
</button>
  <a href="?del_product=<?= $p['id'] ?>" class="delete"
     onclick="return confirm('Hapus produk?')">Delete</a>
</th>

</tr>
<?php endwhile; ?>
</table>

<!-- MODAL EDIT IMAGE -->
<div id="imageModal" class="modal">
  <div class="modal-content">
    <h3>Update Gambar Produk</h3>

    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="product_id" id="modalProductId">
      <input type="file" name="new_image" required>

      <div class="modal-action">
        <button name="update_image">Update</button>
        <button type="button" onclick="closeImageModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>


</div>

<?php
if (isset($_GET['del_product'])) {
  mysqli_query($conn, "DELETE FROM products WHERE id='$_GET[del_product]'");
  header("Location: admin.php");
}
?>

<!-- ================= TAMBAH ARTIKEL ================= -->
<div class="card">
<h2>Tambah Artikel</h2>
<form method="POST" enctype="multipart/form-data">
  <input type="text" name="a_title" placeholder="Judul Artikel" required>
  <input type="date" name="a_date" required>
  <input type="file" name="a_image" required>
  <textarea name="a_desc" placeholder="Deskripsi" required></textarea>
  <button name="add_article">Simpan Artikel</button>
</form>
</div>

<?php
if (isset($_POST['add_article'])) {
  $title = $_POST['a_title'];
  $date  = $_POST['a_date'];
  $desc  = $_POST['a_desc'];
  $img   = time().'_'.$_FILES['a_image']['nama'];

  move_uploaded_file($_FILES['a_image']['tmp_name'], "../uploads/".$img);
  mysqli_query($conn,
    "INSERT INTO articles (title, image, eventDate, description)
     VALUES ('$title','$img','$date','$desc')"
  );
  header("Location: admin.php");
}
?>

<!-- ================= DAFTAR ARTIKEL ================= -->
<div class="card">
<h2>Daftar Artikel</h2>

<table>
<tr>
  <th>Image</th>
  <th>Judul</th>
  <th>Tanggal</th>
  <th>Deskripsi</th>
  <th>Action</th>
</tr>

<?php
$articles = mysqli_query($conn, "SELECT * FROM articles");
while ($a = mysqli_fetch_assoc($articles)):
?>
<tr>
  <th><img src="../uploads/<?= $a['image'] ?>" width="70"></th>

  <th contenteditable="true"
      class="editable-article"
      data-id="<?= $a['id'] ?>"
      data-field="title">
    <?= $a['title'] ?>
  </th>

  <th contenteditable="true"
      class="editable-article"
      data-id="<?= $a['id'] ?>"
      data-field="eventDate">
    <?= $a['eventDate'] ?>
  </th>

<th contenteditable="true"
    class="editable-article"
    data-id="<?= $a['id'] ?>"
    data-field="description">       
    <?= $a['description'] ?>

  <th>
    <button onclick="saveArticle(<?= $a['id'] ?>)">Save</button>
    <a href="?del_article=<?= $a['id'] ?>" class="delete"
       onclick="return confirm('Hapus artikel?')">Delete</a>
  </th>
</tr>
<?php endwhile; ?>
</table>


</div>

<?php
if (isset($_GET['del_article'])) {
  mysqli_query($conn, "DELETE FROM articles WHERE id='$_GET[del_article]'");
  header("Location: admin.php");
}
?>

</div>

<!-- ================= JAVASCRIPT ================= -->
<script>
function saveProduct(id) {
  let data = { id };
  document.querySelectorAll(`.editable-product[data-id='${id}']`)
    .forEach(el => data[el.dataset.field] = el.innerText.trim());

  fetch('update_product.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  }).then(() => alert('Produk berhasil diupdate'));
}

function saveArticle(id) {
  let data = { id };
  document.querySelectorAll(`.editable-article[data-id='${id}']`)
    .forEach(el => data[el.dataset.field] = el.innerText.trim());

  fetch('update_article.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  }).then(() => alert('Artikel berhasil diupdate'));
}
</script>

<?php
if (isset($_POST['update_image'])) {
  $id = $_POST['product_id'];
  $img = time().'_'.$_FILES['new_image']['name'];

  move_uploaded_file($_FILES['new_image']['tmp_name'], "../uploads/".$img);

  mysqli_query($conn,
    "UPDATE products SET image='$img' WHERE id='$id'"
  );

  header("Location: admin.php");
}
?>


</body>
</html>
