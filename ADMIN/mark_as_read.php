<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "UPDATE notifications SET status='read' WHERE id=$id";
    mysqli_query($connection, $query);
}

header("Location: admin.php"); // Redirect to admin panel
?>
