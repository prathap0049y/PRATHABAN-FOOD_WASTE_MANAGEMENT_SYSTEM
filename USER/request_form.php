<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_donation"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $food = $_POST["food"];
    $quantity = $_POST["quantity"];
    $pickup = $_POST["pickup"];

    // SQL query to insert data
    $sql = "INSERT INTO food_request (name, email, phone, food, quantity, pickup)
            VALUES ('$name', '$email', '$phone', '$food', '$quantity', '$pickup')";

    if ($conn->query($sql) === TRUE) {
        $message = "Donation request submitted successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donation Request</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f9;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 26px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            font-weight: 600;
            color: #444;
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background: #fafafa;
            transition: all 0.3s;
        }
        input:focus, textarea:focus {
            background: #fff;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s ease;
        }
        button:hover {
            background: #0056b3;
        }
        .message {
            margin-top: 15px;
            font-weight: bold;
            color: green;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Food Donation Request</h2>
        <?php if (!empty($message)): ?>
            <p class="message"> <?php echo $message; ?> </p>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Organization Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="food">Food Details</label>
                <textarea id="food" name="food" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="pickup">Address</label>
                <textarea id="pickup" name="pickup" rows="2" required></textarea>
            </div>
            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>
