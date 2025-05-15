<?php
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $organization_name = $_POST['organization_name'];
    $owner_name = $_POST['owner_name'];
    $org_id = $_POST['org_id'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $pincode = $_POST['pincode'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
        echo "<script>window.location.href='organization_details.php';</script>";
        exit();
    }

    // Check for duplicate org_id or email
    $check_query = "SELECT * FROM organizations WHERE org_id = '$org_id' OR email = '$email'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Organization ID or Email already exists');</script>";
        echo "<script>window.location.href='organization_details.php';</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO organizations (organization_name, owner_name, org_id, state, district, city, street, pincode, phone_no, email, password) 
              VALUES ('$organization_name', '$owner_name', '$org_id', '$state', '$district', '$city', '$street', '$pincode', '$phone_no', '$email', '$hashed_password')";

    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Organization registered successfully');</script>";
        echo "<script>window.location.href='organization_details.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
    }
}
