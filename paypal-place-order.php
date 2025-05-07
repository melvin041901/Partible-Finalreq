<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false]);
    exit;
}

// Simulate saving order to database (or file)
file_put_contents('orders/paypal_order_' . time() . '.json', json_encode($data));

echo json_encode(['success' => true]);
