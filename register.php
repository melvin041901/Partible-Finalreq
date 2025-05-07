<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contact = $_POST['contact'];
$age = $_POST['age'];
$address = $_POST['address'];

    $otp = rand(100000, 999999);  // Generate OTP

    // Check if email exists in the database
    $stmt = $con->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email already registered!";
        exit();
    }
    $stmt->close();

    // Insert the new user into the database
    $stmt = $con->prepare("INSERT INTO users (Username, Email, Password, ContactNumber, Age, Address, otp) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $username, $email, $password, $contact, $age, $address, $otp);

    
    

    if ($stmt->execute()) {
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = $otp;

        // Send OTP email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'melvinpartible15@gmail.com';  // Your Gmail address
            $mail->Password = 'srfoiqiaigtvenap';  // Your app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
        
            $mail->setFrom('melvinpartible15@gmail.com', 'Your Website');
            $mail->addAddress($email);  // Recipient's email
        
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "<h3>Your OTP Code: <b>$otp</b></h3><p>Enter this code to verify your account.</p>";
        
            $mail->send();
            header("Location: verify.php");  // Redirect to OTP verification page
            exit();
        } catch (Exception $e) {
            echo "Email sending failed: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error: " . $stmt->error; // Handle database insertion errors
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Register</title>
    <link rel="icon" href="images/favcon.png" type="image/x-icon">
    

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color:rgb(240, 234, 243);
        }
        .register-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .btn-register {
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            background-color:rgb(62, 10, 78);
            color: #fff;
        }
    </style>
</head>
<body>


<div class="container">
    <div class="register-container">
        <div class="card shadow-sm">
            <div class="card-body">
            <img src="images/uma-logo.png" alt="UMA Racing Logo" style="height: 70px; margin-left: 135px;">
                <h4 class="text-center mb-4">Register</h4>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                        </div>
                    </div>
                    <div class="mb-3">
    <label class="form-label">Contact Number</label>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-phone"></i></span>
        <input type="text" name="contact" class="form-control" placeholder="Enter contact number" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Age</label>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
        <input type="number" name="age" class="form-control" placeholder="Enter age" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Address</label>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
        <input type="text" name="address" class="form-control" placeholder="Enter address" required>
    </div>
</div>


                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-register" style="background-color: #6a0dad; color: white;">
                        <i class="fa fa-user-plus"></i> Register
                    </button>
                </form>

                <p class="text-center mt-3">Already have an account? <a href="index.php">Login</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
