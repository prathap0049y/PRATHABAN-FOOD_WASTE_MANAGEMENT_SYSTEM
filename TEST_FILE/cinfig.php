<?php
$servername = "localhost"; // Change this if using a live server
$username = "root"; // Default for XAMPP
$password = ""; // Default for XAMPP (leave blank)
$database = "food_donation"; // Change this to your actual database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
