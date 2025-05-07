<?php
session_start();
include("config.php"); // Database connection

// Fetch products from database
$query = mysqli_query($con, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UMA Racing | Official Store</title>
  <link rel="icon" href="images/uma-favicon.png" type="image/x-icon" />

  <!-- Fonts and Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>

  <!-- Styles -->
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="cart.css"/>
  <link rel="stylesheet" href="footer.css"/>
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
        <li><a class="active" href="index.php">Product</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="about.html">About</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container">


  <div class="row">
    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
      <div class="col-md-4">
        <div class="product-card text-center">
          <img src="images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-img">
          <h4 class="mt-3"><?php echo htmlspecialchars($row['name']); ?></h4>
          <p>₱<?php echo number_format($row['price'], 2); ?></p>
          <form method="post" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
            <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
            <input type="hidden" name="product_img" value="images/<?php echo $row['image']; ?>">
            <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
          </form>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<section id="Product1" class="section-p1">


  <div class="pro-container">
 
    <?php
      $static_products = [
        ["Performance ECU", 12500, "p1.png"],
        ["Racing Camshaft", 5000, "p2.png"],
        ["High Flow Air Filter", 600, "p3.png"],
        ["Throttle Body", 7990, "p4.png"],
        ["Super Head Standard", 15500, "p7.png"],
        ["Back Pressure Exhaust", 7000, "p8.png"],
        ["Pulley Set", 2100, "p15.png"],
        ["Radiator", 6050, "p10.png"],
        ["Cylinder Block", 5180, "p16.png"],
        ["Quick Throttle Set", 1490, "p9.png"],
        ["Plug Coil", 1700, "p11.png"],
        ["Utech Iriduim Spark Plug", 450, "p12.png"],
        ["Quick Shifter", 2300, "p13.png"],
        ["Racing CDI", 3900, "p5.png"],
        ["Timing Chain", 1450, "p14.png"],
        ["Racing Valve Spring", 1200, "p6.png"],
       
        
        
      ];

      foreach ($static_products as $product) {
        list($name, $price, $img) = $product;
    ?>

    <div class="pro">
      <img src="images/products/<?php echo $img; ?>" alt="<?php echo $name; ?>" />
      <div class="des">
        <span>UMA Racing</span>
        <h5><?php echo $name; ?></h5>
        <div class="star">
          <i class="fas fa-star"></i><i class="fas fa-star"></i>
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <h4>₱<?php echo number_format($price, 0); ?></h4>
      </div>
      <form action="add_to_cart.php" method="POST" style="position: absolute; right: 15px; bottom: 15px;">
        <input type="hidden" name="product_name" value="<?php echo $name; ?>">
        <input type="hidden" name="product_price" value="<?php echo $price; ?>">
        <input type="hidden" name="product_img" value="images/products/<?php echo $img; ?>">
        <button type="submit" style="padding: 10px 20px; background-color: #7b0dbb; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
          Buy Now
        </button>
      </form>
    </div>

    <?php } ?>

  </div>
</section>

</body>
</html>
