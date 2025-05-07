<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

function clean_price($price) {
    return (float) str_replace(',', '', $price);
}

// If no checkboxes selected, use all items in the cart
$selectedIndexes = $_POST['selected_items'] ?? array_keys($cart);

$selectedItems = [];
$grandTotal = 0;

foreach ($selectedIndexes as $index) {
    if (isset($cart[$index])) {
        $item = $cart[$index];
        $price = clean_price($item['price']);
        $itemTotal = $price * $item['qty'];
        $grandTotal += $itemTotal;

        $selectedItems[] = [
            'name' => $item['name'],
            'img' => $item['img'],
            'qty' => $item['qty'],
            'price' => $price,
            'total' => $itemTotal,
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Checkout | UMA RACING</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="cart.css" />
  <link rel="stylesheet" href="footer.css" />
  <link href="https://fonts.googleapis.com/css2?family=Spartan&display=swap" rel="stylesheet" />
  <style>
    .checkout-summary {
      max-width: 700px;
      margin: 30px auto;
      padding: 20px;
      border: 2px solid #ccc;
      border-radius: 10px;
      background: #f9f9f9;
      font-family: 'Spartan', sans-serif;
    }
    .checkout-summary h2 {
      margin-bottom: 20px;
      text-align: center;
    }
    .checkout-item {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
    }
    .checkout-item img {
      height: 80px;
      margin-right: 15px;
    }
    .checkout-item-details {
      flex-grow: 1;
    }
    .checkout-total {
      text-align: right;
      font-size: 20px;
      margin-top: 20px;
      font-weight: bold;
    }
    .pay-btn {
      display: block;
      margin: 30px auto 0;
      padding: 10px 20px;
      background-color: #c20000;
      color: white;
      border: none;
      font-size: 18px;
      border-radius: 5px;
      cursor: pointer;
    }
    .pay-btn:hover {
      background-color: #a00000;
    }
  </style>
</head>
<body>

<script>
  document.querySelector('form[action="checkout.php"]').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('.product-checkbox:checked');
    if (checkboxes.length === 0) {
      e.preventDefault();
      alert('Please select at least one item to proceed to checkout.');
    }
  });
</script>


<div class="checkout-summary">
  <h2>Checkout Summary</h2>

  <?php if (empty($selectedItems)): ?>
    <p>No valid items found for checkout. <a href="cart.php">Return to Cart</a></p>
  <?php else: ?>
    <?php foreach ($selectedItems as $item): ?>
      <div class="checkout-item">
        <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <div class="checkout-item-details">
          <strong><?= htmlspecialchars($item['name']) ?></strong><br>
          ₱<?= number_format($item['price'], 2) ?> x <?= $item['qty'] ?> =
          <strong>₱<?= number_format($item['total'], 2) ?></strong>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="checkout-total">Grand Total: ₱<?= number_format($grandTotal, 2) ?></div>

    <form action="process-payment.php" method="POST">
      <?php foreach ($selectedIndexes as $index): ?>
        <input type="hidden" name="selected_items[]" value="<?= htmlspecialchars($index) ?>">
      <?php endforeach; ?>
      <button type="submit" class="pay-btn">Proceed to Payment</button>
    </form>
  <?php endif; ?>
</div>

</body>
</html>
