<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = [
  'id'    => $data['id'],
  'name'  => $data['product'] . ' - ' . $data['variant'],
  'price' => $data['price'],
  'qty'   => $data['qty'],
  'days'  => $data['days']
];

echo json_encode(['success' => true]);
