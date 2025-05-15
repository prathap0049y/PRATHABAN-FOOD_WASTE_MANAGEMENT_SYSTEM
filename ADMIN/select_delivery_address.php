<?php
session_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Fetch delivery addresses along with organization names from the database
    $query = "SELECT id, name, address FROM delivery_addresses";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Error fetching delivery addresses: " . mysqli_error($connection));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Delivery Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #06C167;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #04a357;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Select Delivery Address</h2>
        <form method="post" action="assign_delivery_address.php">
            <input type="hidden" name="order_id" value="<?= $order_id ?>">
            <select name="delivery_address_id" required>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <option value="<?= $row['id'] ?>">
                        <?= $row['name'] ?> - <?= $row['address'] ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">Assign Address</button>
        </form>
    </div>
</body>

</html>