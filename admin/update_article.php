<?php
include '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$title = mysqli_real_escape_string($conn, $data['title']);
$date  = mysqli_real_escape_string($conn, $data['eventDate']);
$desc  = mysqli_real_escape_string($conn, $data['description']);

mysqli_query($conn,
  "UPDATE articles SET title='$title', eventDate='$date', description='$desc' WHERE id='$id'"
);
