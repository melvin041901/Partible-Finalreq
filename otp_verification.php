<?php
include 'config.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $email = $_SESSION['email'];

    $stmt = $conn->prepare("SELECT otp, is_verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_otp, $is_verified);
    $stmt->fetch();
    $stmt->close();

    if ($is_verified) {
        header("Location: index.php");
        exit();
    }

    if ($entered_otp == $db_otp) {
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .otp-container {
            max-width: 400px;
            margin: 100px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="otp-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="text-center mb-4">OTP Verification</h4>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Enter OTP</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                            <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Verify</button>
                </form>
                <p class="text-center mt-3"><a href="resend-otp.php">Resend OTP</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

include 'db.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $email = $_SESSION['email'];

    $stmt = $conn->prepare("SELECT otp, is_verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_otp, $is_verified);
    $stmt->fetch();
    $stmt->close();

    if ($is_verified) {
        header("Location: index.php");
        exit();
    }

    if ($entered_otp == $db_otp) {
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .otp-container {
            max-width: 400px;
            margin: 100px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="otp-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="text-center mb-4">OTP Verification</h4>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Enter OTP</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                            <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Verify</button>
                </form>
                <p class="text-center mt-3"><a href="resend-otp.php">Resend OTP</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
