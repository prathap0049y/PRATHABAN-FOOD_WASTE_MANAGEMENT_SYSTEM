<?php

ob_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM delivery_persons WHERE Did='$id'";
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
        header("location:delivery_persons_details.php");
    } else {
        echo "Failed to remove delivery person.";
    }
} else {
    header("location:delivery_persons_details.php");
}
?>
