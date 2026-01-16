<?php
session_start();
include 'config/database.php';

$email = $_POST['email'] ?? '';
$pass  = $_POST['password'] ?? '';

$user = mysqli_fetch_assoc(
  mysqli_query($conn, "SELECT * FROM users WHERE email='$email'")
);

if ($user && password_verify($pass, $user['password'])) {
  $_SESSION['user_id']   = $user['id'];
  $_SESSION['user_name'] = $user['name'];
  $_SESSION['user_phone']= $user['phone'];

  echo json_encode(['success' => true]);
} else {
  echo json_encode([
    'success' => false,
    'message' => 'Email atau password salah'
  ]);
}
