<?php
session_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['delivery_address_id'])) {
    $order_id = $_POST['order_id'];
    $delivery_address_id = $_POST['delivery_address_id'];

    // Fetch the name and address from the delivery_addresses table
    $query = "SELECT name, address FROM delivery_addresses WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $delivery_address_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $address);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($name && $address) {
        // Concatenate name and address
        $delivery_address = $name . ', ' . $address;

        // Insert the concatenated name and address into the food_donations table
        $update_query = "UPDATE food_donations SET delivery_address = ? WHERE Fid = ?";
        $update_stmt = mysqli_prepare($connection, $update_query);
        mysqli_stmt_bind_param($update_stmt, "si", $delivery_address, $order_id);

        if (mysqli_stmt_execute($update_stmt)) {
            // Redirect to a success page or back to the admin dashboard
            header("Location: admin.php?message=Delivery address assigned successfully");
            exit;
        } else {
            die("Error assigning delivery address: " . mysqli_error($connection));
        }
    } else {
        die("Name or address not found.");
    }
} else {
    die("Invalid request.");
}
