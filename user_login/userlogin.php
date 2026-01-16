<?php
session_start();
include 'config/database.php';

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $pass  = $_POST['password'];

  $user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM users WHERE email='$email'")
  );

  if ($user && password_verify($pass, $user['password'])) {
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_phone']= $user['phone'];

    header("Location: order.php");
  } else {
    $error = "Email atau password salah";
  }
}
?>

<h2>Login</h2>
<?= $error ?? '' ?>

<form method="POST">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button name="login">Login</button>
</form>

<p>Belum punya akun? <a href="./user_login/userregister.php">Daftar</a></p>
