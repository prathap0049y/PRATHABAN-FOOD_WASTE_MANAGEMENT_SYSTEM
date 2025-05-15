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
    $query = "SELECT * FROM delivery_persons WHERE Did='$id'";
    $query_run = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($query_run);

    // Fetch total number of delivered food
    $total_delivered_food_query = "SELECT COUNT(*) as total_delivered FROM food_donations WHERE delivery_by='$id' AND delivery_status='Delivered'";
    $total_delivered_food_result = mysqli_query($connection, $total_delivered_food_query);
    $total_delivered_food = mysqli_fetch_assoc($total_delivered_food_result)['total_delivered'];

    // Fetch current delivery food details
    $current_delivery_food_query = "SELECT * FROM food_donations WHERE delivery_by='$id' AND delivery_status='pending' LIMIT 1";
    $current_delivery_food_result = mysqli_query($connection, $current_delivery_food_query);
    $current_delivery_food = mysqli_fetch_assoc($current_delivery_food_result);

    // Fetch food donation details
    $food_donation_query = "SELECT * FROM food_donations WHERE delivery_by='$id'";
    $food_donation_result = mysqli_query($connection, $food_donation_query);
} else {
    header("location:delivery_persons_details.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="view_delivery_person.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>View Delivery Person</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>
            <span class="logo_name">ADMIN</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="dashboard.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                <li><a href="analytics.php">
                        <i class="uil uil-chart"></i>
                        <span class="link-name">Analytics</span>
                    </a></li>
                <li><a href="donate.php">
                        <i class="uil uil-heart"></i>
                        <span class="link-name">Donates</span>
                    </a></li>
                <li><a href="request.php">
                        <i class="uil uil-clipboard-notes"></i>
                        <span class="link-name">Request</span>
                    </a></li>
                <li><a href="feedback.php">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">Feedbacks</span>
                    </a></li>
                <li><a href="adminprofile.php">
                        <i class="uil uil-user"></i>
                        <span class="link-name">Profile</span>
                    </a></li>
                <li><a href="registered_users.php">
                        <i class="uil uil-users-alt"></i>
                        <span class="link-name">Registered Users</span>
                    </a></li>
                <li><a href="organization_details.php">
                        <i class="uil uil-building"></i>
                        <span class="link-name">Organizations</span>
                    </a></li>
                <li><a href="delivery_persons_details.php">
                        <i class="uil uil-truck"></i>
                        <span class="link-name">Delivery Persons</span>
                    </a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>
                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
            <p class="user"></p>
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-truck"></i>
                    <span class="text">Delivery Person Details</span>
                </div>
                <div class="details delivery-person-details">
                    <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    <p><strong>City:</strong> <?php echo $row['city']; ?></p>
                    <p><strong>Total Delivered Food:</strong> <?php echo $total_delivered_food; ?></p>
                    <?php if ($current_delivery_food): ?>
                        <p><strong>Current Delivery Food:</strong></p>
                        <p><strong>Food ID:</strong> <?php echo $current_delivery_food['Fid']; ?></p>
                        <p><strong>Food Type:</strong> <?php echo $current_delivery_food['food']; ?></p>
                        <p><strong>Quantity:</strong> <?php echo $current_delivery_food['quantity']; ?></p>
                        <p><strong>Recipient Address:</strong> <?php echo $current_delivery_food['address']; ?></p>
                        <p><strong>Status:</strong> <?php echo $current_delivery_food['delivery_status']; ?></p>
                    <?php else: ?>
                        <p><strong>Current Delivery Food:</strong> No current delivery</p>
                    <?php endif; ?>
                    <div class="food-donations">
                        <h3>Food Donations</h3>
                        <div class="donation-grid">
                            <?php while ($food_donation = mysqli_fetch_assoc($food_donation_result)): ?>
                                <div class="donation-card">
                                    <p><strong>Donation ID:</strong> <?php echo $food_donation['Fid']; ?></p>
                                    <p><strong>Food Type:</strong> <?php echo $food_donation['food']; ?></p>
                                    <p><strong>Quantity:</strong> <?php echo $food_donation['quantity']; ?></p>
                                    <p><strong>Donor:</strong> <?php echo $food_donation['name']; ?></p>
                                    <p><strong>Status:</strong> <?php echo $food_donation['delivery_status']; ?></p>
                                    <hr>
                                <?php endwhile; ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <script src="admin.js"></script>
</body>

</html>