<?php
include("connect.php");
include 'connection.php';

if ($_SESSION['name'] == '') {
    header("location:deliverylogin.php");
}

$name = $_SESSION['name'];
$city = $_SESSION['city'];
$id = $_SESSION['Did'];

// Fetch delivery person details from the database
$sql = "SELECT * FROM delivery_persons WHERE Did = '$id'";
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Error fetching profile details: " . mysqli_error($connection));
}

$profile = mysqli_fetch_assoc($result);

// Fetch total delivery count
$sql = "SELECT COUNT(*) AS total_deliveries FROM food_donations WHERE delivery_by = '$id'";
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Error fetching delivery count: " . mysqli_error($connection));
}

$delivery_count = mysqli_fetch_assoc($result)['total_deliveries'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div the="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="delivery.php">Home</a></li>
            <li><a href="openmap.php">map</a></li>
            <li><a href="deliverymyord-2.php">myorders</a></li>
            <li><a href="profile.php" class="active">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<br>
<div class="profile-container">
    <h2>Profile Information</h2>
    <div class="profile-info">
        <img src="img/icons8-user.gif" alt="User Image"> <!-- Updated to use user's PNG image -->
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo $profile['name']; ?></p>
            <p><strong>City:</strong> <?php echo $profile['city']; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $profile['phone']; ?></p>
            <p><strong>Email:</strong> <?php echo $profile['email']; ?></p>
            <p><strong>Total Deliveries:</strong> <?php echo $delivery_count; ?></p> <!-- Added total delivery count -->
        </div>
        <a href="edit_profile.php" class="edit-btn">Edit Profile</a> <!-- Added Edit Profile button -->
    </div>
</div>
</body>
</html>
