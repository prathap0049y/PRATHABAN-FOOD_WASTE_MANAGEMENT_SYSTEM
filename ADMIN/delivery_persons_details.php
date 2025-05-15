<?php

ob_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}

// Fetch delivery persons details from the database
$query = "SELECT * FROM delivery_persons";
$query_run = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="delivery_persons_details.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Delivery Persons Details</title>
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
                <li><a href="admin.php">
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
                    <span class="text">Delivery Persons Details</span>
                </div>
                <main class="table">
                    <section class="table__header">
                        <h1>Delivery Persons</h1>
                    </section>
                    <section class="table__body">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>City</th>
                                    <th>Action</th> <!-- Added Action column -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['city'] . "</td>";
                                        echo "<td>
                                                <a href='view_delivery_person.php?id=" . $row['Did'] . "' class='btn'>View Details</a>
                                                <button class='btn remove' onclick='openFlipBox(" . $row['Did'] . ")'>Remove</button>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No delivery persons found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                </main>
            </div>
        </div>
    </section>
    <!-- Flip Box Dialog -->
    <div id="flipBoxDialog" class="flip-box" style="display:none;">
        <div class="flip-box-inner">
            <div class="flip-box-front">
                <h2>Confirm Removal</h2>
                <p>Are you sure you want to remove this delivery person?</p>
                <button class="btn" onclick="confirmRemoval()">Yes</button>
                <button class="btn remove" onclick="closeFlipBox()">No</button>
            </div>
            <div class="flip-box-back">
                <h2>Processing...</h2>
            </div>
        </div>
    </div>
    <script>
        let removeId = null;

        function openFlipBox(id) {
            removeId = id;
            document.getElementById('flipBoxDialog').style.display = 'block';
        }

        function closeFlipBox() {
            document.getElementById('flipBoxDialog').style.display = 'none';
        }

        function confirmRemoval() {
            window.location.href = 'remove_delivery_person.php?id=' + removeId;
        }
    </script>
    <script src="admin.js"></script>
</body>

</html>