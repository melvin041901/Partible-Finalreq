<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

function clean_price($price) {
  return (float) str_replace(',', '', $price);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cart | UMA RACING Official Store</title>

  <link rel="icon" href="images/uma-favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="cart.css"/>
  <link rel="stylesheet" href="footer.css"/>
  <script src="https://kit.fontawesome.com/4a3b1f73a2.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Spartan&display=swap" rel="stylesheet" />
</head>
<body>

<nav>
  <div class="navbar">
    <div style="display: flex; align-items: center;">
      <img src="images/uma-logo.png" alt="UMA Racing Logo" style="height: 60px; margin-right: 25px;">
      <h2 style="font-size: 24px; color: #fff;">UMA RACING</h2>
    </div>
    <div class="highlight">
      <ul id="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="product.php">Product</a></li>
        <li><a class="active" href="cart.php">Cart</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="about.html">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<header>
  <h1>My Cart</h1>
</header>

<?php if (empty($cart)): ?>
  <p style="text-align: center;">No items in cart.</p>
<?php else: ?>
  <ul class="cart-items">
    <?php
      $grandTotal = 0;
      foreach ($cart as $index => $item):
        $price = clean_price($item['price']);
        $itemTotal = $price * $item['qty'];
        $grandTotal += $itemTotal;
    ?>
    <li class="cart-item">
      <input type="checkbox" value="<?= $index ?>" class="product-checkbox" />
      <img src="<?= htmlspecialchars($item['img']) ?>" class="product-image" alt="<?= htmlspecialchars($item['name']) ?>">
      <div class="item-details">
        <strong><?= htmlspecialchars($item['name']) ?></strong>
        <p>₱<?= number_format($price, 2) ?> x <?= $item['qty'] ?> =
          <strong>₱<?= number_format($itemTotal, 2) ?></strong>
        </p>

        <!-- Quantity controls -->
        <form action="update-quantity.php" method="POST" class="quantity-form">
          <input type="hidden" name="index" value="<?= $index ?>">
          <button type="submit" name="action" value="decrease">−</button>
          <?= $item['qty'] ?>
          <button type="submit" name="action" value="increase">+</button>
        </form>
      </div>

      <div class="actions">
        <!-- Delete -->
        <form action="remove-from-cart.php" method="POST" class="delete-form">
          <input type="hidden" name="index" value="<?= $index ?>">
          <button type="submit">Delete</button>
        </form>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>

  <h3 style="text-align: center;">Cart Total: ₱<?= number_format($grandTotal, 2) ?></h3>

  <!-- Checkout Selected -->
  <form id="checkout-selected-form" action="checkout-selected.php" method="POST">
    <div style="text-align: center; margin-top: 20px;">
      <button type="submit" class="btn">Checkout Selected</button>
    </div>
  </form>

  <script>
    document.getElementById('checkout-selected-form').addEventListener('submit', function (e) {
      const checkboxes = document.querySelectorAll('.product-checkbox:checked');
      if (checkboxes.length === 0) {
        e.preventDefault();
        alert('Please select at least one item to proceed to checkout.');
        return;
      }

      checkboxes.forEach(cb => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'selected_items[]';
        hiddenInput.value = cb.value;
        this.appendChild(hiddenInput);
      });
    });
  </script>
<?php endif; ?>

</body>
</html>
