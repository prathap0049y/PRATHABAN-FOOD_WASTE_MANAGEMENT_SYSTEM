<?php
session_name("user_session");
session_start();
include 'connection.php';
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
$msg = 0;

if (isset($_POST['sign'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $login_type = 'user'; // Default login type to 'user'

    $table = 'login'; // Default table to 'user_login'

    $sql = "select * from $table where email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['gender'] = $row['gender'];
                $_SESSION['type'] = $row['type'];
                $_SESSION['login_type'] = $login_type; // Store login type in session
                header("location:home.php"); // Redirect to user home page
            } else {
                $msg = 1;
            }
        }
    } else {
        echo "<h1><center>Account does not exist</center></h1>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="loginstyle-1.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        .login-type {
            margin-top: 20px;
            display: none;
            /* Hide the login type selection */
        }

        .login-type label {
            margin-right: 10px;
            font-weight: bold;
        }

        .login-type select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>


    <div class="main-container">

        <!-- Left Side Quotes (2 Animated Cards) -->
        <div class="quotes-container left">
            <div class="quote-card animate-left">
                <p>“Don't waste food when someone is sleeping hungry.”</p>
            </div>
            <div class="quote-card animate-left">
                <p>“Your leftovers could be someone’s lifeline.”</p>
            </div>
        </div>

        <div class="container">
            <div class="regform">

                <form action="" method="post">

                    <p class="logo">Food <b style="color:#06C167; ">Donate</b></p>
                    <p id="heading" style="padding-left: 1px;"> Welcome back ! <img src="" alt=""> </p>

                    <div class="input">
                        <input type="email" placeholder="Email address" name="email" value="" required />
                    </div>
                    <div class="password">
                        <input type="password" placeholder="Password" name="password" id="password" required />

                        <?php
                        if ($msg == 1) {
                            echo ' <i class="bx bx-error-circle error-icon"></i>';
                            echo '<p class="error">Password not match.</p>';
                        }
                        ?>

                    </div>
                    <!-- Removed login-type selection -->
                    <div class="btn">
                        <button type="submit" name="sign">Sign in</button>
                    </div>
                    <div class="signin-up">
                        <div class="signin-up">
                            <p id="signin-up">Don't have an account? <a href="signup.php">Register</a></p>
                            <p id="forgot_password.php"> <a href="forgot_password.php">Forgot Password</a></p>
                        </div>
                </form>
            </div>

            <!-- Right Side Quotes (2 Animated Cards) -->
            <div class="quotes-container right">
                <div class="quote-card animate-right">
                    <p>“Small acts, like saving food, make a big impact.”</p>
                </div>
                <div class="quote-card animate-right">
                    <p>“Save food, save lives, save the planet.”</p>
                </div>
            </div>

        </div>
        <script src="login.js"></script>
        <script src="admin/login.js"></script>
</body>

</html>