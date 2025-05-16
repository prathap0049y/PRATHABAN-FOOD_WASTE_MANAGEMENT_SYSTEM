<?php
session_name("user_session");
session_start();
include 'connection.php';
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');

if (isset($_POST['sign'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $login_type = $_POST['login_type']; // Get login type from form

  $sanitized_emailid = mysqli_real_escape_string($connection, $email);
  $sanitized_password = mysqli_real_escape_string($connection, $password);

  $table = $login_type == 'organization' ? 'organization_login' : 'user_login'; // Choose table based on login type

  $sql = "select * from $table where email='$sanitized_emailid'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($sanitized_password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['gender'] = $row['gender'];
        $_SESSION['type'] = $row['type'];
        $_SESSION['login_type'] = $login_type; // Store login type in session
        header("location:home.html");
      } else {
        // echo "<h1><center> Login Failed incorrect password</center></h1>";
      }
    }
  } else {
    echo "<h1><center>Account does not exist</center></h1>";
  }
}
