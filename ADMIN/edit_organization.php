<?php
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM organizations WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $organization = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $organization_name = $_POST['organization_name'];
    $owner_name = $_POST['owner_name'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $pincode = $_POST['pincode'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];

    $update_query = "UPDATE organizations SET 
        organization_name = '$organization_name',
        owner_name = '$owner_name',
        state = '$state',
        district = '$district',
        city = '$city',
        street = '$street',
        pincode = '$pincode',
        phone_no = '$phone_no',
        email = '$email'
        WHERE id = $id";

    if (mysqli_query($connection, $update_query)) {
        echo "<script>alert('Organization details updated successfully');</script>";
        echo "<script>window.location.href='registered_organizations.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Organization</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            max-width: 600px;
            margin: auto;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>Edit Organization</h1>
    <form action="edit_organization.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $organization['id']; ?>">
        <label for="organization_name">Organization Name:</label>
        <input type="text" id="organization_name" name="organization_name" value="<?php echo $organization['organization_name']; ?>" required>

        <label for="owner_name">Owner Name:</label>
        <input type="text" id="owner_name" name="owner_name" value="<?php echo $organization['owner_name']; ?>" required>

        <label for="state">State:</label>
        <input type="text" id="state" name="state" value="<?php echo $organization['state']; ?>" required>

        <label for="district">District:</label>
        <input type="text" id="district" name="district" value="<?php echo $organization['district']; ?>" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo $organization['city']; ?>" required>

        <label for="street">Street:</label>
        <input type="text" id="street" name="street" value="<?php echo $organization['street']; ?>" required>

        <label for="pincode">Pincode:</label>
        <input type="text" id="pincode" name="pincode" value="<?php echo $organization['pincode']; ?>" required>

        <label for="phone_no">Phone Number:</label>
        <input type="text" id="phone_no" name="phone_no" value="<?php echo $organization['phone_no']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $organization['email']; ?>" required>

        <button type="submit">Update</button>
    </form>
</body>

</html>