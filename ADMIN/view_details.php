<?php
session_start();
$connection = mysqli_connect("localhost:3306", "root", "", "food_donation");

if ($_SESSION['name'] == '') {
    header("location:signin.php");
}

if (isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($connection, $_GET['order_id']);
    $query = "SELECT * FROM food_donations WHERE Fid = $order_id";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Error executing query: " . mysqli_error($connection));
    }

    $order = mysqli_fetch_assoc($result);
} else {
    die("No order ID provided.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            overflow: auto;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        /* Fade-in Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #06C167;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        a:hover {
            background-color: #04a357;
            transform: translateY(-3px);
        }

        .image-container {
            text-align: center;
            margin-top: 20px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .image-container img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .image-container h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .notes {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 5px solid #06C167;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Order Details</h1>
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo $order['name']; ?></td>
            </tr>
            <tr>
                <th>Food</th>
                <td><?php echo $order['food']; ?></td>
            </tr>
            <tr>
                <th>Category</th>
                <td><?php echo $order['category']; ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?php echo $order['phoneno']; ?></td>
            </tr>
            <tr>
                <th>Date/Time</th>
                <td><?php echo $order['date']; ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo $order['address']; ?></td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td><?php echo $order['quantity']; ?></td>
            </tr>
            <tr>
                <th>Location</th>
                <td><?php echo $order['location']; ?></td>
            </tr>
            <tr>
                <th>Pickup Time</th>
                <td><?php echo $order['pickup_time']; ?></td>
            </tr>
            <tr>
                <th>Expiry Time</th>
                <td><?php echo $order['expiry_time']; ?></td>
            </tr>
            <tr>
                <th>Storage Condition</th>
                <td><?php echo $order['storage_condition']; ?></td>
            </tr>
            <tr>
                <th>Notes</th>
                <td class="notes"><?php echo $order['notes']; ?></td>
            </tr>
        </table>
        <div class="image-container">
            <h2>Food Image</h2>
            <?php
            $image_path = "http://localhost/uploads/" . basename($order['food_image1']);
            ?>
            <img src="<?php echo $image_path; ?>" alt="Food Image">
        </div>

        <div class="image-container">
            <h2>Food Image</h2>
            <?php
            $image_path = "http://localhost/uploads/" . basename($order['food_image2']);
            ?>
            <img src="<?php echo $image_path; ?>" alt="Food Image">
        </div>

        <div class="image-container">
            <h2>Food Image</h2>
            <?php
            $image_path = "http://localhost/uploads/" . basename($order['food_image3']);
            ?>
            <img src="<?php echo $image_path; ?>" alt="Food Image">
        </div>
        <a href="admin.php">Back to Dashboard</a>
    </div>
</body>

</html>