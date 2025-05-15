<?php
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
include "connection.php";
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}
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
                <!-- <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li> -->
                <li><a href="analytics.php">
                        <i class="uil uil-chart"></i>
                        <span class="link-name">Analytics</span>
                    </a></li>
                <li><a href="#">
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
        <br>
        <br>
        <br>



        <div class="activity">

            <div class="location">
                <!-- <p class="logo">Filter by Location</p> -->
                <form method="post">
                    <label for="location" class="logo">Select Location:</label>
                    <!-- <br> -->
                    <select id="location" name="location">
                        <option value="chennai">chennai</option>
                        <option value="chengalpattu">chengalpattu</option>


                    </select>
                    <input type="submit" value="Get Details">
                </form>
                <br>

                <?php
                // Get the selected location from the form
                if (isset($_POST['location'])) {
                    $location = $_POST['location'];

                    // Query the database for people in the selected location
                    $sql = "SELECT * FROM food_donations WHERE location='$location'";
                    $result = mysqli_query($connection, $sql);
                    //   $result = $conn->query($sql);

                    // If there are results, display them in a table
                    if ($result->num_rows > 0) {
                        // echo "<h2>Food Donate in $location:</h2>";

                        echo " <div class=\"table-container\">";
                        echo "    <div class=\"table-wrapper\">";
                        echo "  <table class=\"table\">";
                        echo "<table><thead>";
                        echo " <tr>
        <th >Name</th>
        <th>food</th>
        <th>Category</th>
        <th>phoneno</th>
        <th>date/time</th>
        
        <th>address</th>
        <th>Quantity</th>
        
    </tr>
    </thead><tbody>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td data-label=\"name\">" . $row['name'] . "</td><td data-label=\"food\">" . $row['food'] . "</td><td data-label=\"category\">" . $row['category'] . "</td><td data-label=\"phoneno\">" . $row['phoneno'] . "</td><td data-label=\"date\">" . $row['date'] . "</td><td data-label=\"Address\">" . $row['address'] . "</td><td data-label=\"quantity\">" . $row['quantity'] . "</td></tr>";

                            //   echo "<tr><td>" . $row["name"] . "</td><td>" . $row["phoneno"] . "</td><td>" . $row["location"] . "</td></tr>";
                        }
                        echo "</tbody></table></div>";
                    } else {
                        echo "<p>No results found.</p>";
                    }
                }
                ?>
            </div>




        </div>
    </section>

    <script src="admin.js"></script>
</body>

</html>