<?php
ob_start();

// Database connection
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
include 'connection.php';
include("connect.php");

// Check if the user is logged in
if ($_SESSION['name'] == '') {
    header("location:deliverylogin.php");
    exit();
}

$name = $_SESSION['name'];
$id = $_SESSION['Did'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="delivery.css">
    <link rel="stylesheet" href="home.css">
    <style>
        .itm {
            background-color: white;
            display: grid;
        }
        .itm img {
            width: 400px;
            height: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        p {
            text-align: center;
            font-size: 28px;
            color: black;
        }
        a {
            text-decoration: underline;
        }
        @media (max-width: 767px) {
            .itm {
                float: left;
            }
            .itm img {
                width: 350px;
                height: 350px;
            }
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f4f4f4;
        }
    </style>
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
            <li><a href="openmap.php">Map</a></li>
            <li><a href="deliverymyord.php" class="active">My Orders</a></li>
        </ul>
    </nav>
</header>
<br>
<script>
    hamburger = document.querySelector(".hamburger");
    hamburger.onclick = function () {
        navBar = document.querySelector(".nav-bar");
        navBar.classList.toggle("active");
    }
</script>

<div class="itm">
    <img src="delivery.gif" alt="" width="400" height="400">
</div>

<div class="get">
    <?php
    // Define the SQL query to fetch orders assigned to the delivery person
    $sql = "SELECT fd.Fid AS Fid, fd.name, fd.phoneno, fd.date, fd.delivery_by, fd.address as From_address, 
                   ad.name AS delivery_person_name, ad.address AS To_address
            FROM food_donations fd
            LEFT JOIN admin ad ON fd.assigned_to = ad.Aid 
            WHERE delivery_by = '$id'";

    // Execute the query
    $result = mysqli_query($connection, $sql);

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

        $sql = "UPDATE food_donations SET delivery_by = $delivery_person_id WHERE Fid = $order_id";
        $result = mysqli_query($connection, $sql);

        if (!$result) {
            die("Error assigning order: " . mysqli_error($connection));
        }

        // Reload the page to prevent duplicate assignments
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
    ?>

    <div class="log">
        <a href="delivery.php">Take Orders</a>
        <p>Orders Assigned to You</p>
        <br>
    </div>

    <!-- Display the orders in an HTML table -->
    <div class="table-container">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Date/Time</th>
                    <th>Pickup Address</th>
                    <th>Delivery Address</th>
                    <th>Delivery Person</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['phoneno'] ?></td>
                        <td><?= $row['date'] ?></td>
                        <td><?= $row['From_address'] ?></td>
                        <td><?= $row['To_address'] ?></td>
                        <td><?= $row['delivery_person_name'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
<?php
ob_end_flush();
?>