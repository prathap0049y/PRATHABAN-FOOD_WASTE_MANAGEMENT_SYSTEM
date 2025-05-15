<?php
session_start();
ob_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}

$email = $_GET['email'];

// Fetch user details
$user_query = "SELECT name, email, phone FROM login WHERE email='$email'";
$user_result = mysqli_query($connection, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch user donations
$donations_query = "SELECT * FROM food_donations WHERE email='$email'";
$donations_result = mysqli_query($connection, $donations_query);
$total_donations = mysqli_num_rows($donations_result);

// Calculate pending and delivered donations
$pending_donations_query = "SELECT COUNT(*) as pending_count FROM food_donations WHERE email='$email' AND delivery_status='Pending'";
$pending_donations_result = mysqli_query($connection, $pending_donations_query);
$pending_donations = mysqli_fetch_assoc($pending_donations_result)['pending_count'];

$delivered_donations_query = "SELECT COUNT(*) as delivered_count FROM food_donations WHERE email='$email' AND delivery_status='Delivered'";
$delivered_donations_result = mysqli_query($connection, $delivered_donations_query);
$delivered_donations = mysqli_fetch_assoc($delivered_donations_result)['delivered_count'];

// Fetch user requests
$requests_query = "SELECT * FROM food_request WHERE email='$email'";
$requests_result = mysqli_query($connection, $requests_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="registered_users.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>User Details</title>
    <style>
        .user-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .user-info p {
            margin: 10px 0;
            font-size: 16px;
        }
    </style>
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
                    <i class="uil uil-user"></i>
                    <span class="text">User Details</span>
                </div>
                <div class="user-info">
                    <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
                    <p><strong>Total Donations:</strong> <?php echo $total_donations; ?></p>
                    <p><strong>Pending Donations:</strong> <?php echo $pending_donations; ?></p>
                    <p><strong>Delivered Donations:</strong> <?php echo $delivered_donations; ?></p>
                </div>
                <div class="table-container">
                    <div class="table-wrapper">
                        <h3>Donations</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Date/Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($donations_result) {
                                    while ($row = mysqli_fetch_assoc($donations_result)) {
                                        $statusClass = strtolower($row['delivery_status']);
                                        echo "<tr>
                                                <td>{$row['food']}</td>
                                                <td>{$row['type']}</td>
                                                <td>{$row['category']}</td>
                                                <td>{$row['date']}</td>
                                                <td class='status $statusClass'>{$row['delivery_status']}</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No donations found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <h3>Requests</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Quantity</th>
                                    <th>Pickup</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($requests_result) {
                                    while ($row = mysqli_fetch_assoc($requests_result)) {
                                        $statusClass = strtolower($row['status']);
                                        echo "<tr>
                                                <td>{$row['food']}</td>
                                                <td>{$row['quantity']}</td>
                                                <td>{$row['pickup']}</td>
                                                <td class='status $statusClass'>{$row['status']}</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No requests found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="admin.js"></script>
</body>

</html>