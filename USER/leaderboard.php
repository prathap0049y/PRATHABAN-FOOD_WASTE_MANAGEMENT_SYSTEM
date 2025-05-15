<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="flip.css">
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
                <li><a href="profile.php">Profile</a></li>
                <li><a href="leaderboard.php" class="active">Leaderboard</a></li>
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
    <section class="banner">
        <div class="hello">
            <h1>Top Donors</h1>
        </div>
    </section>
    <div class="content">
        <h2>Leaderboard</h2>
        <ul id="leaderboard-list">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "food_donation";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT name, SUM(quantity) as total_quantity FROM food_donations GROUP BY name ORDER BY total_quantity DESC LIMIT 10";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $position = 1;
                while ($row = $result->fetch_assoc()) {
                    $medal = "";
                    if ($position == 1) {
                        $medal = "<img src='img/gold.png' alt='Gold Medal' style='width:20px;height:20px;'>";
                    } elseif ($position == 2) {
                        $medal = "<img src='img/silver.png' alt='Silver Medal' style='width:20px;height:20px;'>";
                    } elseif ($position == 3) {
                        $medal = "<img src='img/bronze.png' alt='Bronze Medal' style='width:20px;height:20px;'>";
                    }
                    echo "<li>" . $medal . " " . $row["name"] . " - " . $row["total_quantity"] . " items donated</li>";
                    $position++;
                }
            } else {
                echo "<li>No donors found.</li>";
            }

            $conn->close();
            ?>
        </ul>
    </div>
    <footer class="footer">
        <div class="footer-left col-md-4 col-sm-6">
            <p class="about">
                <span> About us</span>The concept of this project Food Waste Management is to collect the excess/leftover
                food from donors such as hotels, restaurants, marriage halls, etc and distribute to the needy people.
            </p>
        </div>
        <div class="footer-center col-md-4 col-sm-6">
            <div>
                <p><span> Contact</span> </p>
            </div>
            <div>
                <p> (+91) 9344557834</p>
            </div>
            <div>
                <p><a href="#"> Fooddonate@gmail.com</a></p>
            </div>
            <div class="sociallist">
                <ul class="social">
                    <li><a href="https://www.facebook.com/TheAkshayaPatraFoundation/"><i class="fa fa-facebook" style="font-size:50px;color: black;"></i></a></li>
                    <li><a href="https://twitter.com/globalgiving"><i class="fa fa-twitter" style="font-size:50px;color: black;"></i></a></li>
                    <li><a href="https://www.instagram.com/charitism/"><i class="fa fa-instagram" style="font-size:50px;color: black;"></i></a></li>
                    <li><a href="https://web.whatsapp.com/"><i class="fa fa-whatsapp" style="font-size:50px;color: black;"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-right col-md-4 col-sm-6">
            <h2> Food<span> Donate</span></h2>
            <p class="menu">
                <a href="home.php"> Home</a> |
                <a href="about.html"> About</a> |
                <a href="profile.php"> Profile</a> |
                <a href="contact.html"> Contact</a>
            </p>
            <p class="name"> Food Donate &copy 2025</p>
        </div>
    </footer>
</body>

</html>