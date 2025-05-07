<?php
$host = "localhost";
$user = "root";  // Default in XAMPP
$pass = "";      // No password in XAMPP
$db = "shopee";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
