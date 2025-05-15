<?php
session_start();
ob_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
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
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Document</title>
    <style>
        .search-filter {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-filter form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-filter input[type="date"],
        .search-filter input[type="text"],
        .search-filter button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .search-filter input[type="date"]:focus,
        .search-filter input[type="text"]:focus,
        .search-filter button:hover {
            border-color: #06C167;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .search-filter button {
            cursor: pointer;
            background-color: #06C167;
            color: white;
        }

        .search-filter button:hover {
            background-color: #04a456;
        }
    </style>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="users.png" alt="">
            </div>

            <span class="logo_name">ADMIN</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dahsboard</span>
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
                <li><a href="requests.php">
                        <i class="uil uil-clipboard-notes"></i>

                        <span class="link-name">Request</span>
                    </a></li>
                <li><a href="feedback.php">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">Feedbacks</span>
                    </a></li>
                <li><a href="#">
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

            <p class="logo">Your <b style="color: #06C167; ">History</b></p>
            <p class="user"></p>

            <img src="users.png" alt="">
        </div>
        <br>
        <br>
        <br>

        <div class="search-filter">
            <form method="POST" action="">
                <label for="search-date">Search by Date:</label>
                <input type="date" name="search_date" id="search-date" style="background-color: lavender; color:black;">
                <button type="submit" name="search" style="background-color: lavender; color:black;">Search</button>
                <button type="submit" name="show_all" style="background-color: lavender; color:black;">Show All</button>
                <label for="search-name">Search by Name:</label>
                <input type="text" name="search_name" id="search-name" style="background-color: lavender; color:black;">
                <button type="submit" name="search_name_btn" style="background-color: lavender; color:black;">Search</button>
            </form>
        </div>

        <div class="activity">
            <div class="table-container">

                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>food</th>
                                <th>Category</th>
                                <th>phoneno</th>
                                <th>date/time</th>
                                <th>address</th>
                                <th>delivery address</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <!-- <th>Action</th> -->



                            </tr>
                        </thead>
                        <?php



                        // Define the SQL query to fetch unassigned orders
                        $id = $_SESSION['Aid'];
                        $sql = "SELECT * FROM food_donations WHERE assigned_to =$id";

                        if (isset($_POST['search'])) {
                            $search_date = $_POST['search_date'];
                            $sql .= " AND DATE(date) = '$search_date'";
                        }

                        if (isset($_POST['search_name_btn'])) {
                            $search_name = $_POST['search_name'];
                            $sql .= " AND name LIKE '%$search_name%'";
                        }

                        // Execute the query
                        $result = mysqli_query($connection, $sql);


                        // Check for errors
                        if (!$result) {
                            die("Error executing query: " . mysqli_error($conn));
                        }

                        // Fetch the data as an associative array
                        $data = array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $data[] = $row;
                        }


                        ?>

                        </tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td data-label="name"><?= $row['name'] ?></td>
                                <td data-label="food"><?= $row['food'] ?></td>
                                <td data-label="category"><?= $row['category'] ?></td>
                                <td data-label="phoneno"><?= $row['phoneno'] ?></td>
                                <td data-label="date"><?= $row['date'] ?></td>
                                <td data-label="Address"><?= $row['address'] ?></td>
                                <td data-label="Delivery_Address"><?= $row['delivery_address'] ?></td>
                                <td data-label="quantity"><?= $row['quantity'] ?></td>
                                <td data-label="status"><?= ucfirst($row['delivery_status']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>



        </div>
        <!-- <P>Your history</P> -->



    </section>
    <script src="admin.js"></script>
</body>

</html>