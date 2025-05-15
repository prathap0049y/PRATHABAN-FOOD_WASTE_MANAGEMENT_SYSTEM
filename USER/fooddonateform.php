<?php
include("login.php");
if ($_SESSION['name'] == '') {
  header("location: signin.php");
}
//include("login.php"); 
$emailid = $_SESSION['email'];
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
if (isset($_POST['submit'])) {
  $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
  $meal = mysqli_real_escape_string($connection, $_POST['meal']);
  $category = mysqli_real_escape_string($connection, $_POST['image-choice']);
  $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
  
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $phoneno = mysqli_real_escape_string($connection, $_POST['phoneno']);
  $district = mysqli_real_escape_string($connection, $_POST['district']);
  $address = mysqli_real_escape_string($connection, $_POST['address']);
  $name = mysqli_real_escape_string($connection, $_POST['name']);

  $query = "INSERT INTO food_donations(email, food, type, category, phoneno, location, address, name, quantity) VALUES('$emailid', '$foodname', '$meal', '$category', '$phoneno', '$district', '$address', '$name', '$quantity')";
  $query_run = mysqli_query($connection, $query);
  if ($query_run) {
    echo '<script type="text/javascript">alert("Data saved successfully.")</script>';
    header("location:delivery.html");
  } else {
    echo '<script type="text/javascript">alert("Data not saved.")</script>';
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Food Donate</title>
  <link rel="stylesheet" href="loginstyle.css">
</head>

<body style="    background-color: #06C167;">
  <div class="container">
    <div class="regformf">
      <form action="" method="post">
        <p class="logo">Food <b style="color: #06C167; ">Donate</b></p>

        <div class="input">
          <label for="foodname"> Food Name:</label>
          <input type="text" id="foodname" name="foodname" required />
        </div>


        <div class="radio">
          <label for="meal">Meal type :</label>
          <br><br>

          <input type="radio" name="meal" id="veg" value="veg" required />
          <label for="veg" style="padding-right: 40px;">Veg</label>
          <input type="radio" name="meal" id="Non-veg" value="Non-veg">
          <label for="Non-veg">Non-veg</label>

        </div>
        <br>
        <div class="input">
          <label for="food">Select the Category:</label>
          <br><br>
          <div class="image-radio-group">
            <input type="radio" id="raw-food" name="image-choice" value="raw-food">
            <label for="raw-food" style="position: relative; display: inline-block;">
              <img src="rawfood.png" alt="raw-food" style="display: flex; align-items: center;">
              <span style="margin-left: 15px; font-size: 24px; font-weight: bold; color: black; text-align: center;">Raw Food</span>
            </label>

            <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
            <label for="cooked-food" style="position: relative; display: inline-block;">
              <img src="cooked-food.png" alt="cooked-food" style="display: flex; align-items: center;">
              <span style="margin-left: 15px; font-size: 24px; font-weight: bold; color: black; text-align: center;">Cooked Food</span>
            </label>

            <input type="radio" id="packed-food" name="image-choice" value="packed-food">
            <label for="packed-food" style="position: relative; display: inline-block;">
              <img src="packedfood.png" alt="packed-food" style="display: flex; align-items: center;">
              <span style="margin-left: 15px; font-size: 24px; font-weight: bold; color: black; text-align: center;">Packed Food</span>
            </label>
          </div>
          <br>
          <!-- <input type="text" id="food" name="food"> -->
        </div>
        <div class="input">
          <label for="quantity">Quantity:(number of person /kg)</label>
          <input type="text" id="quantity" name="quantity" required />
        </div>
        
          <p style="text-align: center;">Contact Details</p>
        </b>
        <div class="input">

          <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" required />
          </div>
          <div>
            <label for="phoneno">PhoneNo:</label>
            <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required />

          </div>
          <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required />
          </div>
        </div>
        <div class="input">
          <label for="location"></label>
          <label for="district">District:</label>
          <select id="district" name="district" style="padding:10px;">
            <option value="chennai">Chennai</option>
            <option value="chengalpattu">chengalpattu</option>

          </select>

          <label for="address" style="padding-left: 10px;">Address:</label>
          <input type="text" id="address" name="address" required /><br>




        </div>
        <div class="btn">
          <button type="submit" name="submit"> submit</button>

        </div>
      </form>
    </div>
  </div>


</body>

</html>