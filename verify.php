<?php
session_start();

if (!isset($_SESSION['otp'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otpEntered = $_POST['otp'];

    if ($otpEntered == $_SESSION['otp']) {
        $_SESSION['success_message'] = "Registration successful! Welcome, " . $_SESSION['email'] . ".";
        unset($_SESSION['otp']);
        unset($_SESSION['email']);
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Optional Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f3f0fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .otp-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .card {
            border: none;
            border-radius: 12px;
        }
        .btn-purple {
            background-color: #6a0dad;
            color: white;
        }
        .btn-purple:hover {
            background-color: #5a0cab;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="otp-container">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center mb-4">Verify OTP</h4>
                <form method="post" action="verify.php">
                    <div class="mb-3">
                        <label for="otp" class="form-label">Enter OTP sent to your email:</label>
                        <input type="text" name="otp" id="otp" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-purple w-100">Verify OTP</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
