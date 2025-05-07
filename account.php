<?php 
session_start();
include("config.php");

// Check if user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit(); // Stop further code execution if not logged in
}

// Get the user ID from the session
$id = $_SESSION['id'];

// Debugging: Print the session ID and user ID to ensure it's correct
echo "Session ID: " . $id . "<br>";

// Query to fetch user data based on ID
$query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");

// Debugging: Check if query was successful and if results are returned
if (mysqli_num_rows($query) > 0) {
    // Fetch the data if it exists
    $result = mysqli_fetch_assoc($query);

    // Assign the results to variables
    $res_Uname = $result['username'];
    $res_Email = $result['email'];
    $res_Age = $result['Age'];
    $res_ContactNumber = $result['ContactNumber'];
    $res_Address = $result['Address'];
    $res_id = $result['id'];
} else {
    // Debugging: If no results are found
    echo "No user found with the ID: " . $id . "<br>";
    exit(); // Stop further execution if no data is found
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/uma_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="login.css">
    <title>UMA Racing - Home</title>

    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="footer.css"/>
</head>
<body>
    <header>
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
                <li><a href="cart.php">Cart</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a class="active" href="account.php">Account</a></li>
                <li><a href="about.html">About</a></li>
                
              
              </ul>
            </div>
          </div>
        </nav>
    </header>
    <main style="display: flex; justify-content: flex-start; align-items: flex-start; padding-top: 30px; ">
        
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Hello <b><?php echo isset($res_Uname) ? $res_Uname : 'N/A'; ?></b>, Welcome to UMA Racing</p>
                </div>
                <div class="box">
                    <p>Your email is <b><?php echo isset($res_Email) ? $res_Email : 'N/A'; ?></b>.</p>
                </div>
                <div class="box">
                    <p>Your contact number is <b><?php echo isset($res_ContactNumber) ? $res_ContactNumber : 'N/A'; ?></b>.</p>
                </div>
                <div class="box">
                    <p>Your address is <b><?php echo isset($res_Address) ? $res_Address : 'N/A'; ?></b>.</p>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <p>And you are <b><?php echo isset($res_Age) ? $res_Age : 'N/A'; ?> years old</b>.</p>
                </div>
            </div>
        </div>
    </main>
</body>

    <div class="nav">
        <div class="logo">
            <p><a href="index.php"></a></p>
        </div>
        <main style="display: flex; justify-content: flex-start; align-items: flex-start; padding-top: 5px;">
        <div class="right-links">
            <?php echo "<a href='edit.php?Id=$res_id'>Change Profile</a>"; ?>
            <a href="logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    
</html>
