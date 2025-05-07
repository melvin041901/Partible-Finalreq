<?php
session_start();

if (!isset($_POST['selected_items']) || empty($_POST['selected_items'])) {
    echo "<script>alert('No items selected for checkout.'); window.location.href='cart.php';</script>";
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$selectedIndexes = $_POST['selected_items'];
$selectedItems = [];
$total = 0;

// Collect valid items
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout | UMA RACING</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Spartan&display=swap" rel="stylesheet" />
  <script src="https://www.paypal.com/sdk/js?client-id=ASwWOjMBUo2OrJhr77tZqq-OpkLz0vMx6PCRSLrdgeVxxSuYgVrxgbx8l4FjN43fzB9SGqZgdpYQr_If&currency=PHP"></script>

  <style>
    body {
      font-family: 'Spartan', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .checkout-container {
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
    .checkout-item {
      border-bottom: 1px solid #ddd;
      padding: 15px 0;
    }
    .checkout-item:last-child {
      border-bottom: none;
    }
    .checkout-item p {
      margin: 5px 0;
      color: #333;
    }
    .total {
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      margin-top: 20px;
    }
    .btn-order {
      background-color: #7b0dbb;
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 8px;
      cursor: pointer;
      display: block;
      margin: 20px auto 0;
    }
    .btn-order:hover {
      background-color: #7b0dbb;
    }
  </style>
</head>
<body>
<div style="text-align: left; margin-top: 15px;">
  <a href="cart.php" class="btn-back"><strong>← Back to Cart</strong></a>
</div>

<div class="checkout-container">
  <h1>Checkout Product</h1>

  <?php if (empty($selectedItems)): ?>
    <p style="text-align: center;">No valid items selected.</p>
  <?php else: ?>
    <?php foreach ($selectedItems as $item): ?>
      <div class="checkout-item">
        <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <div class="item-details">
          <p><strong><?= htmlspecialchars($item['name']) ?></strong></p>
          <p>Price: ₱<?= number_format($item['price'], 2) ?></p>
          <p>Quantity: <?= $item['qty'] ?></p>
          <p>Subtotal: ₱<?= number_format($item['total'], 2) ?></p>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="total">Total: ₱<?= number_format($total, 2) ?></div>

    <!-- Traditional Order Form -->
    <form action="place-order.php" method="POST">
      <?php foreach ($selectedIndexes as $i): ?>
        <input type="hidden" name="selected_items[]" value="<?= $i ?>">
      <?php endforeach; ?>
      <button type="submit" class="btn-order">Place Order</button>
    </form>

    <!-- PayPal Button -->
    <div id="paypal-button-container" style="margin-top: 20px;"></div>
    <script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '<?= number_format($total, 2, '.', '') ?>'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        // Send data to the server
        fetch('paypal-place-order.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            payer: details.payer,
            orderID: data.orderID,
            items: <?= json_encode($selectedItems) ?>,
            total: <?= json_encode($total) ?>
          })
        })
        .then(res => res.json())
        .then(response => {
          if (response.success) {
            alert('Transaction completed by ' + details.payer.name.given_name + '!');
            window.location.href = 'paypal-success.php';
          } else {
            alert('Something went wrong while saving your order.');
          }
        });
      });
    }
  }).render('#paypal-button-container');
</script>


  <?php endif; ?>
</div>

</body>
</html>
