<?php
session_start();

// Ensure selected items are posted
if (!isset($_POST['selected_items']) || empty($_POST['selected_items'])) {
    echo "<script>alert('No items selected for checkout.'); window.location.href='cart.php';</script>";
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$selectedIndexes = $_POST['selected_items'];
$selectedItems = [];
$total = 0;

// Collect selected items from the cart
foreach ($selectedIndexes as $index) {
    if (isset($cart[$index])) {
        $item = $cart[$index];
        $price = (float) str_replace(',', '', $item['price']);
        $item['price'] = $price;
        $item['total'] = $price * $item['qty'];
        $total += $item['total'];
        $selectedItems[] = $item;
    }
}

// Here, you can also process the order (store in database, email, etc.)
// For now, we'll just clear the cart after placing the order.

unset($_SESSION['cart']); // Clear cart after successful order
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmation | UMA RACING</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Spartan&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Spartan', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .confirmation-container {
      max-width: 700px;
      margin: 40px auto;
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #7b0dbb;
    }
    .confirmation-item {
      border-bottom: 1px solid #ddd;
      padding: 15px 0;
    }
    .confirmation-item:last-child {
      border-bottom: none;
    }
    .confirmation-item p {
      margin: 5px 0;
      color: #333;
    }
    .total {
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      margin-top: 20px;
    }
    .btn-back {
      background-color: #7b0dbb;
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 8px;
      cursor: pointer;
      display: block;
      margin: 20px auto 0;
      text-decoration: none;
      font-weight: bold;
    }
    .btn-back:hover {
      background-color: #5c08b2;
    }
  </style>
</head>
<body>

<a href="cart.php" class="btn-back">← Back to Cart</a>

<div class="confirmation-container">
  <h1>Order Confirmation</h1>

  <?php if (empty($selectedItems)): ?>
    <p style="text-align: center;">No valid items selected.</p>
  <?php else: ?>
    <?php foreach ($selectedItems as $item): ?>
      <div class="confirmation-item">
        <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 100px; height: auto; display: block; margin: 0 auto;">
        <div class="item-details">
          <p><strong><?= htmlspecialchars($item['name']) ?></strong></p>
          <p>Price: ₱<?= number_format($item['price'], 2) ?></p>
          <p>Quantity: <?= $item['qty'] ?></p>
          <p>Subtotal: ₱<?= number_format($item['total'], 2) ?></p>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="total">Total: ₱<?= number_format($total, 2) ?></div>

  <?php endif; ?>
</div>

</body>
</html>
