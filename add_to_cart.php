<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = [
        'name' => $_POST['product_name'],
        'price' => $_POST['product_price'],
        'img' => $_POST['product_img'],
        'qty' => 1
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if item already exists
    $found = false;
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['name'] == $item['name']) {
            $cartItem['qty']++;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = $item;
    }

    header("Location: cart.php");
    exit();
}
?>
