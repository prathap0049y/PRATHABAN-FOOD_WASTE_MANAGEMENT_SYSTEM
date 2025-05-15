<?php
$servername = "localhost"; // Change if using a remote server
$username = "root"; // Default XAMPP/WAMP username
$password = ""; // Default is empty in XAMPP/WAMP
$database = "food_donation"; // Change to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character encoding to avoid issues with special characters
$conn->set_charset("utf8mb4");

// Uncomment for debugging
// echo "Connected successfully";
?>
