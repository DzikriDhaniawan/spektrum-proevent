<?php
include '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$name = mysqli_real_escape_string($conn, $data['nama']);
$category = mysqli_real_escape_string($conn, $data['category']);

mysqli_query($conn,
  "UPDATE products SET nama='$name', category='$category' WHERE id='$id'"
);
