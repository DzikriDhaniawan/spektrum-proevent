<?php
session_start();
include '../config/database.php';

if (isset($_POST['login'])) {
  $user = $_POST['username'];
  $pass = $_POST['password'];

  $q = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user'");
  $admin = mysqli_fetch_assoc($q);

  if ($admin && password_verify($pass, $admin['password'])) {
    $_SESSION['admin'] = true;
    header("Location: admin.php");
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body { display:flex; justify-content:center; align-items:center; height:100vh; font-family:Arial; background:#111 }
    form { background:#fff; padding:30px; border-radius:10px; width:300px }
    input, button { width:100%; padding:10px; margin-top:10px }
    button { background:#4f46e5; color:white; border:none }
    p { color:red }
  </style>
</head>
<body>

<form method="POST">
  <h2>Admin Login</h2>
  <?php if(isset($error)) echo "<p>$error</p>"; ?>
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button name="login">Login</button>
</form>

</body>
</html>
