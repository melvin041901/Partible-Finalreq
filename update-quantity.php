<?php
session_start();

if (isset($_POST['index']) && isset($_POST['action'])) {
    $index = (int) $_POST['index'];
    $action = $_POST['action'];

    if (isset($_SESSION['cart'][$index])) {
        if ($action === 'increase') {
            $_SESSION['cart'][$index]['qty']++;
        } elseif ($action === 'decrease' && $_SESSION['cart'][$index]['qty'] > 1) {
            $_SESSION['cart'][$index]['qty']--;
        }
    }
}

header("Location: cart.php");
exit;
