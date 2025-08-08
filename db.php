<?php
$host = "localhost"; // tetap localhost di Hostinger
$user = "root"; // sesuaikan dengan nama user DB kamu
$pass = ""; // isi password database
$db   = "u988603669_restoran"; // sesuaikan dengan nama DB kamu

$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
