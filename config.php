<?php
$host = 'localhost';       // or '127.0.0.1'
$user = 'root';            // default XAMPP MySQL user
$password = '';            // default XAMPP password is empty
$dbname = 'shopee'; // make sure this is your actual DB name

$con = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>

