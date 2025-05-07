<?php
  session_start();
  include("config.php");
  if (!isset($_SESSION['valid'])) {
      header("Location: login.php");
      exit;
  }
  
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
<form action="Product.php" method="POST" style="position: absolute; right: 100px; top: 1100px;">
       
       <button type="submit" style="padding: 5px 5px; background-color: #fff; color: #7b0dbb; border: none; border-radius: 10px; font-weight: bold; cursor: pointer;">
         See All
       </button>
      </form> 

  <!-- Header -->
  <section>
    <div class="header">
      <div class="container">
        <nav>
          <div class="navbar">
      
          <div style="display: flex; align-items: center;">
    <img src="images/uma-logo.png" alt="UMA Racing Logo" style="height: 60px; margin-right: 25px;">
    <h2 style="font-size: 24px; color: #fff;">UMA RACING</h2>
  </div>
            
            <div class="highlight">
              <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="product.php">Product</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="about.html">About</a></li>
                
              
              </ul>
            </div>
          </div>
        </nav>

        <!-- Banner -->
        <div class="banner">
          <div class="column">
            <h1>Push Your Limits<br> With UMA Racing Performance Parts</h1>
            <p>Discover the latest racing upgrades, CDI units, and motorcycle accessories built for champions.</p>
          </div>
          <div class="column">
            <img src="images/banner/uma-banner.png" alt="UMA Racing banner" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Advertisements -->
  <div class="slider">
    <h2>Featured Drops</h2>
    <p>High-performance UMA Racing parts and accessories</p>
  </div>

  <div class="slideshow-container" style="text-align: center;">

    <div class="mySlides fade"><img src="images/advertise/ads1.png" style="width: 50%" /></div>
    <div class="mySlides fade"><img src="images/advertise/ads2.png" style="width: 50%" /></div>
    <div class="mySlides fade"><img src="images/advertise/ads3.png" style="width: 50%" /></div>
  </div>
  <br/>
  <div style="text-align: center">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    
  </div>
    

  <!-- Products -->
  <section id="Product1" class="section-p1">
 
  <div class="pro-container">

    <?php
      $static_products = [
        ["Performance ECU", 12500, "p1.png"],
        ["Racing Camshaft", 5000, "p2.png"],
        ["High Flow Air Filter", 600, "p3.png"],
        ["Throttle Body", 7990, "p4.png"],
        ["Racing CDI", 3900, "p5.png"],
        ["Racing Valve Spring", 1200, "p6.png"],
        ["Super Head Standard", 15500, "p7.png"],
        ["Back Pressure Exhaust", 7000, "p8.png"]
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


    </div>
  </section>

  <!-- Footer -->
  <footer class="section-p1">
    <div class="col">
      <div class="logo">UMA RACING</div>
      <h4>Contact</h4>
      <address>
        <p>Address:<br> 123 Racing Street, Valenzuela City, Philippines</p>
        <p>Phone: <a href="tel:+639171234567">+63 917 123 4567</a></p>
        <p>Email: <a href="mailto:support@umaracing.com">support@umaracing.com</a></p>
        <p>Hours: 9:00 AM – 6:00 PM PHT</p>
      </address>
      <div class="follow">
        <h4>Follow us</h4>
        <div class="icon">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>

    <div class="col">
      <h4>About UMA Racing</h4>
      <a href="about.html">Our Story</a>
      <a href="#">Careers</a>
      <a href="#">Innovation</a>
      <a href="#">Privacy Policy</a>
    </div>

    <div class="col">
      <h4>My Account</h4>
      <a href="login.php">Sign In</a>
      <a href="cart.html">Cart</a>
      <a href="#">Wishlist</a>
      <a href="#">Order Tracking</a>
      <a href="contact.html">Help Center</a>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>
