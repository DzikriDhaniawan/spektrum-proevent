<?php
include 'config/database.php';

if (isset($_POST['register'])) {
  $name  = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

  mysqli_query($conn, "
    INSERT INTO users (name, email, phone, password)
    VALUES ('$name','$email','$phone','$pass')
  ");

  header("Location: userlogin.php");
}
?>

<h2>Daftar Akun</h2>
<form method="POST">
  <input name="name" placeholder="Nama" required>
  <input name="email" type="email" placeholder="Email" required>
  <input name="phone" placeholder="No HP" required>
  <input name="password" type="password" placeholder="Password" required>
  <button name="register">Daftar</button>
</form>
