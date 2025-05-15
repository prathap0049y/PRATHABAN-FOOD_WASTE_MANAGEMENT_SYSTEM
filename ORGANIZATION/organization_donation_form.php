<?php
session_name("user_session");
session_start();

if ($_SESSION['login_type'] != 'organization') {
    header("location: USER/signin.php");
    exit();
}

$connection = new mysqli("localhost", "root", "", "food_donation");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle form submission for food donation
if (isset($_POST['donate_food'])) {
    $food = mysqli_real_escape_string($connection, $_POST['food']);
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $pickup_address = mysqli_real_escape_string($connection, $_POST['pickup_address']);
    $email = $_SESSION['email'];

    $insert_query = "INSERT INTO food_donations (food, type, category, quantity, pickup_address, email) VALUES ('$food', '$type', '$category', '$quantity', '$pickup_address', '$email')";

    if (mysqli_query($connection, $insert_query)) {
        echo '<script>alert("Food donation submitted successfully!");</script>';
    } else {
        echo '<script>alert("Failed to submit food donation.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Food Donation</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .donation-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        .donation-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .donation-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .donation-form input,
        .donation-form select,
        .donation-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .donation-form button {
            width: 100%;
            padding: 10px;
            background-color: #06C167;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .donation-form button:hover {
            background-color: #04a357;
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
                <li><a href="organization_home.php">Home</a></li>
                <li><a href="organization_donation_form.php" class="active">Donate Food</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>
    <script>
        hamburger = document.querySelector(".hamburger");
        hamburger.onclick = function() {
            navBar = document.querySelector(".nav-bar");
            navBar.classList.toggle("active");
        }
    </script>

    <div class="main-container">
        <div class="donation-form">
            <h2>Food Donation Form</h2>
            <form action="" method="post">
                <label for="food">Food Item</label>
                <input type="text" id="food" name="food" required>

                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="perishable">Perishable</option>
                    <option value="non-perishable">Non-Perishable</option>
                </select>

                <label for="category">Category</label>
                <input type="text" id="category" name="category" required>

                <label for="quantity">Quantity</label>
                <input type="text" id="quantity" name="quantity" required>

                <label for="pickup_address">Pickup Address</label>
                <textarea id="pickup_address" name="pickup_address" rows="4" required></textarea>

                <button type="submit" name="donate_food">Submit Donation</button>
            </form>
        </div>
    </div>
</body>

</html>