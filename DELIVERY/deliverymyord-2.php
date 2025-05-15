<?php
ob_start();

// Database connection
$connection = mysqli_connect("localhost:3306", "root", "", "food_donation");
include 'connection.php';
include("connect.php");

// Check if the user is logged in
if (!isset($_SESSION['name']) || $_SESSION['name'] == '') {
    header("location:deliverylogin.php");
    exit();
}

$name = $_SESSION['name'];
$id = $_SESSION['Did'];

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $update_query = "UPDATE food_donations SET delivery_status = '$new_status' WHERE Fid = $order_id AND delivery_by = '$id'";
    $update_result = mysqli_query($connection, $update_query);

    if (!$update_result) {
        die("Error updating status: " . mysqli_error($connection));
    }

    // Refresh the page to show updated status
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch assigned orders
$sql = "SELECT fd.Fid, fd.name, fd.phoneno, fd.date, fd.address AS From_address, 
               ad.name AS delivery_person_name, ad.address AS To_address, fd.delivery_status 
        FROM food_donations fd
        LEFT JOIN admin ad ON fd.assigned_to = ad.Aid 
        WHERE fd.delivery_by = '$id'";

$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
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
        /* Full Page Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
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

        /* Navbar */
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: black;
        }

        /* Status Colors */
        .status {
            padding: 6px 12px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }
        .status-pending {
            background-color: red;
            color: white;
        }
        .status-transit {
            background-color: yellow;
            color: black;
        }
        .status-delivered {
            background-color: green;
            color: white;
        }

        /* Table Styling */
        .table-container {
            width: 90%;
            margin: 20px auto;
            overflow-x: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            background-color: #06C167;
            color: white;
            text-align: center;
        }

        /* Buttons */
        .btn-update {
            padding: 8px 12px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-transit {
            background-color: #f0ad4e;
        }

        .btn-delivered {
            background-color: #28a745;
        }

        /* Responsive Design */
        @media (max-width: 767px) {
            .table-container {
                width: 100%;
            }

            .table th, .table td {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <nav class="nav-bar">
        <ul>
            <li><a href="delivery.php">Home</a></li>
            <li><a href="openmap.php">Map</a></li>
            <li><a href="deliverymyord.php" class="active">My Orders</a></li>
        </ul>
    </nav>
</header>

<script>
    document.querySelector(".hamburger").onclick = function () {
        document.querySelector(".nav-bar").classList.toggle("active");
    }
</script>

<div class="itm">
    <img src="delivery.gif" alt="Delivery Image" width="400" height="400">
</div>

<div class="log">
    <a href="delivery.php">Take Orders</a>
    <p>Orders Assigned to You</p>
</div>

<!-- Order Table -->
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Date/Time</th>
                <th>Pickup Address</th>
                <th>Delivery Address</th>
                <th>Delivery Person</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) { 
                // Determine status color
                $status_class = "status-pending";
                if ($row['delivery_status'] === "In Transit") {
                    $status_class = "status-transit";
                } elseif ($row['delivery_status'] === "Delivered") {
                    $status_class = "status-delivered";
                }
            ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['phoneno'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['From_address'] ?></td>
                    <td><?= $row['To_address'] ?></td>
                    <td><?= $row['delivery_person_name'] ?></td>
                    <td><span class="status <?= $status_class ?>"><?= ucfirst($row['delivery_status']) ?></span></td>
                    <td>
                        <?php if ($row['delivery_status'] !== "Delivered") { ?>
                            <form method="POST">
                                <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                <select name="status" required>
                                    <option value="Pending" <?= $row['delivery_status'] == "Pending" ? "selected" : "" ?>>Pending</option>
                                    <option value="In Transit" <?= $row['delivery_status'] == "In Transit" ? "selected" : "" ?>>In Transit</option>
                                    <option value="Delivered" <?= $row['delivery_status'] == "Delivered" ? "selected" : "" ?>>Delivered</option>
                                </select>
                                <button type="submit" name="update_status" class="btn-update btn-transit">Update</button>
                            </form>
                        <?php } else { ?>
                            <b style="color: green;">Completed</b>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php
ob_end_flush();
?>
