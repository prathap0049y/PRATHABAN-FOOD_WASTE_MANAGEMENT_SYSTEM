<?php
session_start();
ob_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}

// Fetch unread notifications
$query = "SELECT * FROM notifications WHERE status='unread' ORDER BY created_at DESC";
$result = mysqli_query($connection, $query);
$unread_count = mysqli_num_rows($result);

// Store the current unread count in the session
if (!isset($_SESSION['last_unread_count'])) {
    $_SESSION['last_unread_count'] = $unread_count; // Initialize if not set
}

// Check if new notifications have arrived
$new_notifications_arrived = ($unread_count > $_SESSION['last_unread_count']);

// Debugging: Output the values for testing
echo "<script>console.log('Unread Count: " . $unread_count . "');</script>";
echo "<script>console.log('Last Unread Count: " . $_SESSION['last_unread_count'] . "');</script>";
echo "<script>console.log('New Notifications Arrived: " . ($new_notifications_arrived ? 'true' : 'false') . "');</script>";

// Update the session with the current unread count
$_SESSION['last_unread_count'] = $unread_count;


?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="admin.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Admin Dashboard Panel</title>

    <?php
    $connection = mysqli_connect("localhost:3306", "root", "");
    $db = mysqli_select_db($connection, 'food_donation');



    ?>
    <style>
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .table-wrapper {
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table td[data-label]::before {
            content: attr(data-label);
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .table td[data-label] {
            display: block;
        }

        @media (min-width: 600px) {
            .table td[data-label]::before {
                display: none;
            }

            .table td[data-label] {
                display: table-cell;
            }
        }

        button {
            background-color: #06C167;
            color: white;
            border: none;
            padding: 5px 10px;
            /* Reduced padding */
            font-size: 12px;
            /* Reduced font size */
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #04a357;
        }

        .notification-container {
            position: relative;
            display: inline-block;
            align-items: center;
            margin-left: 20%;
            margin-top: 20px;
        }

        .notification-btn {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .badge {

            color: black;
            padding: 5px 10px;
            border-radius: 50%;
            font-size: 12px;
            position: relative;

        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            width: 300px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
            padding: 10px;
        }

        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .notification-item.donation {
            background-color: #e0f7fa;
        }

        /* Light blue for donations */
        .notification-item.request {
            background-color: #ffe0b2;
        }

        /* Light orange for requests */
    </style>
</head>

<body>

    <!-- Notification Bell with Counter -->
    <div class="notification-container">
        <button class="notification-btn" onclick="toggleDropdown(); playNotificationSound();">
            🔔 Notifications <span class="badge"><?php echo $unread_count; ?></span>
        </button>

        <div id="notificationDropdown" class="dropdown-content">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="notification-item <?php echo ($row['type'] == 'donation') ? 'donation' : 'request'; ?>">
                    <?php echo $row['message']; ?>
                    <a href="mark_as_read.php?id=<?php echo $row['id']; ?>">✔</a>
                </div>
            <?php } ?>
        </div>
    </div>

    <audio id="notificationSound" preload="auto">

    </audio>

    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>

            <span class="logo_name">ADMIN</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php" class="active">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li> -->
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
                <!-- <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li> -->
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
            <!-- <p>Food Donate</p> -->
            <p class="logo">Food <b style="color: #06C167; ">Donate</b></p>
            <p class="user"></p>
            <!-- <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div> -->

            <!--<img src="images/profile.jpg" alt="">-->
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user"></i>
                        <!-- <i class="fa-solid fa-user"></i> -->
                        <span class="text">Total users</span>
                        <?php
                        $query = "SELECT count(*) as count FROM  login";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">" . $row['count'] . "</span>";
                        ?>
                        <!-- <span class="number">50,120</span> -->
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Feedbacks</span>
                        <?php
                        $query = "SELECT count(*) as count FROM  user_feedback";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">" . $row['count'] . "</span>";
                        ?>
                        <!-- <span class="number">20,120</span> -->
                    </div>
                    <div class="box box3">
                        <i class="uil uil-heart"></i>
                        <span class="text">Total doantes</span>
                        <?php
                        $query = "SELECT count(*) as count FROM food_donations";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">" . $row['count'] . "</span>";
                        ?>
                        <!-- <span class="number">10,120</span> -->
                    </div>
                </div>
            </div>

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Recent Donations</span>
                </div>
                <div class="get">
                    <?php

                    $loc = mysqli_real_escape_string($connection, $_SESSION['location']);

                    // Define the SQL query to fetch unassigned orders
                    $sql = "SELECT * FROM food_donations WHERE assigned_to IS NULL and location='$loc'";

                    // Execute the query
                    $result = mysqli_query($connection, $sql);
                    $id = $_SESSION['Aid'];

                    // Check for errors
                    if (!$result) {
                        die("Error executing query: " . mysqli_error($connection));
                    }

                    // Fetch the data as an associative array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data[] = $row;
                    }

                    // If the delivery person has taken an order, update the assigned_to field in the database
                    if (isset($_POST['food']) && isset($_POST['delivery_person_id'])) {


                        $order_id = $_POST['order_id'];
                        $delivery_person_id = $_POST['delivery_person_id'];
                        $sql = "SELECT * FROM food_donations WHERE Fid = $order_id AND assigned_to IS NOT NULL";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // Order has already been assigned to someone else
                            die("Sorry, this order has already been assigned to someone else.");
                        }



                        $sql = "UPDATE food_donations SET assigned_to = $delivery_person_id WHERE Fid = $order_id";
                        // $result = mysqli_query($conn, $sql);
                        $result = mysqli_query($connection, $sql);


                        if (!$result) {
                            die("Error assigning order: " . mysqli_error($connection));
                        }

                        // Reload the page to prevent duplicate assignments
                        header('Location: ' . $_SERVER['REQUEST_URI']);
                        // exit;
                        ob_end_flush();
                    }

                    if (isset($_POST['reject_food'])) {
                        $order_id = $_POST['order_id'];
                        $sql = "DELETE FROM food_donations WHERE Fid = $order_id";
                        $result = mysqli_query($connection, $sql);

                        if (!$result) {
                            die("Error rejecting order: " . mysqli_error($connection));
                        }

                        // Reload the page to reflect changes
                        header('Location: ' . $_SERVER['REQUEST_URI']);
                        ob_end_flush();
                    }




                    ?>

                    <!-- Display the orders in an HTML table -->
                    <div class="table-container">
                        <!-- <p id="heading">donated</p> -->
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>food</th>
                                        <th>Category</th>
                                        <th>phoneno</th>
                                        <th>date/time</th>
                                        <th>Pick Up address</th>
                                        <th>Quantity</th>
                                        <th>Delivery Address</th> <!-- New column -->
                                        <th>Action</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($data as $row) { ?>
                                        <?php echo "<tr><td data-label=\"name\">" . $row['name'] . "</td><td data-label=\"food\">" . $row['food'] . "</td><td data-label=\"category\">" . $row['category'] . "</td><td data-label=\"phoneno\">" . $row['phoneno'] . "</td><td data-label=\"date\">" . $row['date'] . "</td><td data-label=\"Address\">" . $row['address'] . "</td><td data-label=\"quantity\">" . $row['quantity'] . "</td>"; ?>
                                        <td data-label="Delivery Address">
                                            <form method="post" action="select_delivery_address.php">
                                                <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                                <button type="submit" style="padding: 5px 10px; font-size: 12px;">Select Address</button>
                                            </form>
                                        </td>
                                        <td data-label="Action" style="margin:auto">
                                            <?php if ($row['assigned_to'] == null) { ?>
                                                <form method="post" action=" ">
                                                    <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                                    <input type="hidden" name="delivery_person_id" value="<?= $id ?>">
                                                    <button type="submit" name="food">Get Food</button>
                                                </form>
                                                <form method="post" action=" ">
                                                    <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                                    <button type="submit" name="reject_food" style="background-color: red;">Reject Food</button>
                                                </form>
                                            <?php } else if ($row['assigned_to'] == $id) { ?>
                                                Order assigned to you

                                            <?php } else { ?>
                                                Order assigned to another delivery person
                                            <?php } ?>
                                        </td>
                                        <td data-label="Details">
                                            <form method="get" action="view_details.php">
                                                <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                                <button type="submit">View Details</button>
                                            </form>
                                        </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>




                        <!-- 
                <div class="table-container">
         <p id="heading">donated</p>
         <div class="table-wrapper">
        <table class="table">
        <thead>
        <tr>
            <th >Name</th>
            <th>food</th>
            <th>Category</th>
            <th>phoneno</th>
            <th>date/time</th>
            <th>address</th>
            <th>Quantity</th>
            <th>Status</th>
          
           
        </tr>
        </thead>
       <tbody>
   
         <?php
            $loc = $_SESSION['location'];
            $query = "select * from food_donations where location='$loc' ";
            $result = mysqli_query($connection, $query);
            if ($result == true) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td data-label=\"name\">" . $row['name'] . "</td><td data-label=\"food\">" . $row['food'] . "</td><td data-label=\"category\">" . $row['category'] . "</td><td data-label=\"phoneno\">" . $row['phoneno'] . "</td><td data-label=\"date\">" . $row['date'] . "</td><td data-label=\"Address\">" . $row['address'] . "</td><td data-label=\"quantity\">" . $row['quantity'] . "</td><td  data-label=\"Status\" >" . $row['quantity'] . "</td></tr>";
                }
            } else {
                echo "<p>No results found.</p>";
            }

            ?> 
    
        </tbody>
    </table>
         </div>
                </div>
                
          -->

                    </div>
    </section>
    <script>
        // Function to play the notification sound
        function playNotificationSound() {
            var audio = document.getElementById("notificationSound");
            audio.play().then(function() {
                console.log("Notification sound played successfully.");
            }).catch(function(error) {
                console.error("Error playing notification sound:", error);
            });
        }

        // Function to handle user interaction
        function handleUserInteraction() {
            // Set a flag in localStorage to indicate the user has interacted with the page
            localStorage.setItem("userInteracted", "true");
            // Remove the event listener after the first interaction
            document.removeEventListener("click", handleUserInteraction);
        }

        // Automatically play sound if new notifications have arrived and the user has interacted with the page
        window.onload = function() {
            const newNotificationsArrived = <?php echo $new_notifications_arrived ? 'true' : 'false'; ?>;

            // Check if the user has interacted with the page
            const userInteracted = localStorage.getItem("userInteracted") === "true";

            if (newNotificationsArrived && userInteracted) {
                playNotificationSound();
            }

            // Add a click event listener to detect user interaction
            document.addEventListener("click", handleUserInteraction);
        }

        function toggleDropdown() {
            document.getElementById("notificationDropdown").style.display = "block";
        }



        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.notification-btn')) {
                const dropdowns = document.getElementsByClassName("dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].style.display = "none";
                }
            }
        }
    </script>
    <script src="admin.js"></script>
</body>

</html>