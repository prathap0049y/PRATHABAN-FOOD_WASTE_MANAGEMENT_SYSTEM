<?php
session_start();
include 'connection.php';
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
$msg=0;
if (isset($_POST['Login'])) {
  $email =mysqli_real_escape_string($connection, $_POST['email']);
  $password =mysqli_real_escape_string($connection, $_POST['password']);
 
  // $sanitized_emailid =  mysqli_real_escape_string($connection, $email);
  // $sanitized_password =  mysqli_real_escape_string($connection, $password);

  $sql = "select * from login where email='$email'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);
 
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['gender'] = $row['gender'];
        header("location:home.html");
      } else {
        $msg = 1;
   
      }
    }
  } else {
    echo "<h1><center>Account does not exists </center></h1>";
  }

}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Donor Login</title>
    <link rel="stylesheet" href="don-login.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    
  </head>
  <body>
    <div class="info">
      <h1>Donation Organization</h1>
      <p>
        We are a country that prides itself on power and wealth, yet there are
        millions of children who go hungry every day. It is our responsibility,
        not only as a nation, but also as individuals, to get involved. So, next
        time you pass someone on the street who is in need, remember how lucky
        you are, and don't turn away.
      </p>
    </div>
  
    <div class="bg_img">
      <div class="container">
        <div class="qot">
          <p style="color: rgb(255, 234, 0)">Don't</p>
          <p style="color: rgb(255, 234, 0)">Waste</p>
          <p style="color: rgb(48, 255, 48)">Food</p>
        </div>
        <div class="con_bdy">
          <h3>Donor</h3>
          <h4>Login</h4>
          <form action="don_login_submit" method="post">
            <div class="input_box">
              <p>Email</p>
              <input type="email" name="email" placeholder="Enter Email" required/>
            </div>
            <div class="input_box">
              <p>Password</p>
              <input type="password" name="password" placeholder="Enter Password" required />

              <i class="uil uil-eye-slash showHidepw"></i>

              <?php
              if($msg==1){
                echo '<i class="bx bx-error-circle error-icon"></i>';
                echo '<p class="eror">Password not match.</p>';

              }
              ?>
            </div>
            <div class="button">
              <button type="submit" value="Login" name="Login" >login</button>
            </div>
          </form>
          <p id="reg_link">
            Register New as Donor?
            <a href="donRegister" style="color: skyblue">Register</a>
          </p>
        </div>
        <button id="back">
          <img
            src="https://cdn-icons-png.flaticon.com/128/1946/1946436.png"
            height="30px"
            width="30px"
          />
        </button>
      </div>
    </div>
    <div class="org_button">
      <form action="/orglogin">
        <button>Organization Login</button>
      </form>
    </div>
    <script>
      document.getElementById("back").addEventListener("click", () => {
        window.location.href = "/";
      });
    </script>
  </body>
</html>