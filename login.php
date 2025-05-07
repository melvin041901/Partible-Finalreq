<?php 
session_start();
include('config.php');

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Query to check if the email exists in the database
    $result = mysqli_query($con, "SELECT * FROM users WHERE email='$email'") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if (is_array($row) && !empty($row)) {
        // Check if the entered password matches the hashed password in the database
        if (password_hash($password, $row['Password'])) {
            $_SESSION['valid'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            // Redirect to the dashboard page after successful login
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='message'>
                    <p>Wrong Username or Password</p>
                  </div><br>";
            echo "<a href='login.php'><button class='btn'>Go Back</button>";
        }
    } else {
        echo "<div class='message'>
                <p>Wrong Username or Password</p>
              </div><br>";
        echo "<a href='login.php'><button class='btn'>Go Back</button>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
    <link rel="icon" href="images/favcon.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <div style="display: flex; align-items: center;">
                <img src="images/uma-logo.png" alt="UMA Racing Logo" style="height: 70px; margin-left: 150px;">
                <h2 style="font-size: 24px; color: #fff;">UMA RACING</h2>
            </div>

            <header>Login</header>
            
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Enter Email" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
