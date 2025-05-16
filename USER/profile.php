<?php
include("login.php");

if ($_SESSION['name'] == '') {
    header("location: signin.php");
}

$connection = new mysqli("localhost", "root", "", "food_donation");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle form submission for updating profile
if (isset($_POST['update_profile'])) {
    $new_email = mysqli_real_escape_string($connection, $_POST['email']);
    $new_phone = mysqli_real_escape_string($connection, $_POST['phone']);

    $current_email = $_SESSION['email'];
    $login_type = $_SESSION['login_type']; // Get login type from session

    $table = $login_type == 'organization' ? 'organization_login' : 'user_login'; // Choose table based on login type

    // Check if phone number is provided
    if (!empty($new_phone)) {
        $update_query = "UPDATE $table SET email='$new_email', phone='$new_phone' WHERE email='$current_email'";
    } else {
        $update_query = "UPDATE $table SET email='$new_email' WHERE email='$current_email'";
    }

    if (mysqli_query($connection, $update_query)) {
        $_SESSION['email'] = $new_email;
        echo '<script>alert("Profile updated successfully!");</script>';
    } else {
        echo '<script>alert("Failed to update profile.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <li><a href="home.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
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

    <div class="profile">
        <div class="profilebox">
            <p class="headingline" style="text-align: left;font-size:30px;">
                <img src="user-1.png" alt="" style="width:40px; height: 25px;; padding-right: 10px; position: relative;">Profile
            </p>
            </p>
            <img src="users.png" alt="" style="width: 90px; height: 90px; border-radius:50%; display: block; margin-left: auto; margin-right: auto; padding-top: 10px; border: 1px solid #ffff;">
            <br>
            <p style="font-size: 28px;">Welcome</p>
            <br>
            <div class="info" style="padding-left:10px;">
                <p>Name : <?php echo $_SESSION['name']; ?> </p><br>
                <p>Email : <?php echo $_SESSION['email']; ?> </p><br>
                <p>Gender : <?php echo $_SESSION['gender']; ?> </p><br>
                <p>Type : <?php echo $_SESSION['type']; ?> </p><br>
                <div class="button-container">
                    <button onclick="document.getElementById('editProfileModal').style.display='block'" class="edit-btn">Edit Profile</button>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <p class="heading">Your Donations</p>
            <p style="font-family: 'Times New Roman', Times, serif; font-size: 20px;">Your donations</p><br>
            <img src="cover-1.jpg" alt="" width='100%' height='auto'>
            <div class="table-container">
                <p id="heading">Donated</p>
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Date/Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $email = $_SESSION['email'];
                            $query = "SELECT * FROM food_donations WHERE email='$email'";
                            $result = mysqli_query($connection, $query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $statusClass = strtolower($row['delivery_status']);
                                    echo "<tr><td>" . $row['food'] . "</td><td>" . $row['type'] . "</td><td>" . $row['category'] . "</td><td>" . $row['date'] . "</td><td class='status $statusClass'>" . $row['delivery_status'] . "</td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <p class="heading">Your Requests</p>
            <div class="table-container requests">
                <p id="heading">Donation Requests</p>
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Quantity</th>
                                <th>Pickup</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM food_request WHERE email='$email'";
                            $result = mysqli_query($connection, $query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $statusClass = strtolower($row['status']);
                                    echo "<tr><td>" . $row['food'] . "</td><td>" . $row['quantity'] . "</td><td>" . $row['pickup'] . "</td><td class='status $statusClass'>" . $row['status'] . "</td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <form class="modal-content animate" action="" method="post">
            <div class="container">
                <span onclick="document.getElementById('editProfileModal').style.display='none'" class="close" title="Close Modal">&times;</span>
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter New Email" name="email">

                <label for="phone"><b>Phone Number</b></label>
                <input type="text" placeholder="Enter New Phone Number" name="phone">

                <button type="submit" name="update_profile">Update</button>
            </div>
            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('editProfileModal').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById('editProfileModal');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>