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

$update_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $sql = "UPDATE delivery_persons SET name='$name', city='$city', phoneno='$phone', email='$email' WHERE Did='$id'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $update_message = "Profile updated successfully.";
    } else {
        die("Error updating profile: " . mysqli_error($connection));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="delivery.php">Home</a></li>
            <li><a href="openmap.php">map</a></li>
            <li><a href="deliverymyord-2.php">myorders</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<br>
<div class="profile-container">
    <h2>Edit Profile</h2>
    <?php if ($update_message): ?>
        <p class="update-message"><?php echo $update_message; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <div class="profile-details">
            <label for="name"><strong>Name:</strong></label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" required>
            <label for="city"><strong>City:</strong></label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($profile['city']); ?>" required>
            <label for="phone"><strong>Phone Number:</strong></label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($profile['phoneno']); ?>" required>
            <label for="email"><strong>Email:</strong></label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profile['email']); ?>" required>
            <button type="submit" class="edit-btn">Save Changes</button>
        </div>
    </form>
</div>
</body>
</html>
