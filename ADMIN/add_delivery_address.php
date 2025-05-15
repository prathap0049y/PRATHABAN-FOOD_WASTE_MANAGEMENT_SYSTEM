<?php
session_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $state = mysqli_real_escape_string($connection, $_POST['state']);
    $postal_code = mysqli_real_escape_string($connection, $_POST['postal_code']);

    $query = "INSERT INTO delivery_addresses (address, city, state, postal_code) VALUES ('$address', '$city', '$state', '$postal_code')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        header("Location: organization_details.php");
        exit;
    } else {
        die("Error adding delivery address: " . mysqli_error($connection));
    }
}
