<?php
session_name("user_session");
session_start();

if ($_SESSION['login_type'] != 'organization') {
    header("location: signin.php");
    exit();
}

$connection = new mysqli("localhost", "root", "", "food_donation");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Home</title>
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
        <li><a href="#home" class="active">Home</a></li>
        <li><a href="#">Profile</a></li>
      </ul>
    </nav>
  </header>
  <script>
    hamburger = document.querySelector(".hamburger");
    hamburger.onclick = function () {
      navBar = document.querySelector(".nav-bar");
      navBar.classList.toggle("active");
    }
  </script>
  <section class="banner">
    <div class="hello">
      <a href="organization_donation_form.php">Donate Food</a>
      
    </div>
  </section>
  <div class="content">
    <h2>Love Food</h2>
    <h3>Hate Wasting</h3>
    <p style="font-size: 23px;">
      “Cutting food waste is a delicious way of saving money, helping to feed the world and protect the planet.”
    </p>
  </div>

   <div class="photo">
    <br>
    <p class="heading">Our Works</p>
    <br>
    <p style="font-size: 28px; text-align: center;">"Look what we can do together."</p>
    <br>
    <div class="wrapper">
      <div class="box"><img src="img/p1.jpeg" alt=""></div>
      <div class="box"><img src="img/p4.jpeg" alt=""></div>
      <div class="box"><img src="img/p3.jpeg" alt=""></div>
    </div>
    <br>
    <div class="marquee-wrapper">
      <div class="marquee">
        <span>🌱 Help End Food Waste!</span>
        <span>🍛 Every Meal Counts!</span>
        <span>❤️ Donate Today!</span>
        <span>♻️ Reduce, Reuse, Feed!</span>
        <span>🍽️ Share the Love!</span>
      </div>
    </div>
  </div>

  <div class="deli" style="display: grid;">
    <p class="heading">DOOR PICKUP</p>
    <br>
    <p class="para">"Your donate will be immediately collected and sent to needy people "</p>
    <img src="delivery.gif" alt="" style="margin-left:auto; margin-right: auto;">
  </div>
  <div class="ser"></div>
  <footer class="footer">
    <div class="footer-left col-md-4 col-sm-6">
      <p class="about">
        <span> About us</span>The  concept of this project Food Waste Management is to collect the excess/leftover
        food from donors such as hotels, restaurants, marriage halls , etc and distribute to the needy people .
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
        <a href="#"> Home</a> |
        <a href="about.html"> About</a> |
        <a href="profile.php"> Profile</a> |
        <a href="contact.html"> Contact</a>
      </p>
      <p class="name"> Food Donate &copy 2025</p>
    </div>
  </footer>
</body>


</html>