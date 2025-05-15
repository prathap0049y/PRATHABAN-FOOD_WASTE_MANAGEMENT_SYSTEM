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

    $sql = "select * from login where email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['gender'] = $row['gender'];
                $_SESSION['type'] = $row['type'];
                header("location:home.html");
            } else {
                $msg = 1;
            }
        }
    } else {
        echo "<h1><center>Account does not exist </center></h1>";
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
                <!-- Toggle Button -->
                <button id="toggleFormButton">Switch to Organization Login</button>

                <!-- Donor Login Form -->
                <form id="donorLoginForm" action="" method="post">
                    <p class="logo">Food <b style="color:#06C167;">Donate</b></p>
                    <p id="heading" style="padding-left: 1px;"> Welcome back! <img src="" alt=""> </p>

                    <div class="input">
                        <input type="email" placeholder="Email address" name="email" value="" required />
                    </div>
                    <div class="password">
                        <input type="password" placeholder="Password" name="password" id="password" required />
                        <i class="uil uil-eye-slash showHidePw"></i>
                        <?php
                        if ($msg == 1) {
                            echo ' <i class="bx bx-error-circle error-icon"></i>';
                            echo '<p class="error">Password not match.</p>';
                        }
                        ?>
                    </div>
                    <div class="btn">
                        <button type="submit" name="sign">Sign in</button>
                    </div>
                    <div class="signin-up">
                        <p id="signin-up">Don't have an account? <a href="signup.php">Register</a></p>
                        <p id="forgot_password.php"> <a href="forgot_password.php">Forgot Password</a></p>
                    </div>
                </form>

                <!-- Organization Login Form -->
                <form id="organizationLoginForm" action="organization_login.php" method="post" style="display: none;">
                    <p class="logo">Food <b style="color:#06C167;">Donate</b></p>
                    <p id="heading" style="padding-left: 1px;"> Organization Login <img src="" alt=""> </p>

                    <div class="input">
                        <input type="email" placeholder="Organization Email" name="org_email" required />
                    </div>
                    <div class="password">
                        <input type="password" placeholder="Organization Password" name="org_password" required />
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="btn">
                        <button type="submit" name="org_sign">Sign in</button>
                    </div>
                    <div class="signin-up">
                        <p id="signin-up">Don't have an account? <a href="org_signup.php">Register</a></p>
                        <p id="forgot_password.php"> <a href="org_forgot_password.php">Forgot Password</a></p>
                    </div>
                </form>
            </div>
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

    <script>
        // JavaScript to toggle between donor and organization login forms
        document.getElementById('toggleFormButton').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent form submission

            var donorForm = document.getElementById('donorLoginForm');
            var orgForm = document.getElementById('organizationLoginForm');
            var toggleButton = document.getElementById('toggleFormButton');

            if (donorForm.style.display === 'none') {
                donorForm.style.display = 'block';
                orgForm.style.display = 'none';
                toggleButton.textContent = 'Switch to Organization Login';
            } else {
                donorForm.style.display = 'none';
                orgForm.style.display = 'block';
                toggleButton.textContent = 'Switch to Donor Login';
            }
        });
    </script>
</body>

</html>