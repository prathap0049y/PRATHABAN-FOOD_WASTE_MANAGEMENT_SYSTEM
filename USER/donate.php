<?php
include("login.php");
if ($_SESSION['name'] == '') {
}

$emailid = $_SESSION['email'];
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
if (isset($_POST['submit'])) {
    $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal = mysqli_real_escape_string($connection, $_POST['meal']);
    $category = isset($_POST['category']) ? mysqli_real_escape_string($connection, $_POST['category']) : '';
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);

    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phoneno = mysqli_real_escape_string($connection, $_POST['phone']);
    $district = mysqli_real_escape_string($connection, $_POST['district']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $agreement = isset($_POST['agreement']) ? 1 : 0;

    // Ensure the uploads directory exists
    $target_dir = "C:/xampp/htdocs/uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Handle image uploads
    $food_image1 = $target_dir . basename($_FILES["food_image1"]["name"]);
    $food_image2 = $target_dir . basename($_FILES["food_image2"]["name"]);
    $food_image3 = $target_dir . basename($_FILES["food_image3"]["name"]);

    move_uploaded_file($_FILES["food_image1"]["tmp_name"], $food_image1);
    move_uploaded_file($_FILES["food_image2"]["tmp_name"], $food_image2);
    move_uploaded_file($_FILES["food_image3"]["tmp_name"], $food_image3);

    // Add missing variables
    $expiry_time = mysqli_real_escape_string($connection, $_POST['expiry_time']);
    $storage_condition = mysqli_real_escape_string($connection, $_POST['storage_condition']);
    $pickup_time = mysqli_real_escape_string($connection, $_POST['pickup_time']);
    $notes = mysqli_real_escape_string($connection, $_POST['notes']);

    $sql = "INSERT INTO food_donations (name, phoneno, email, location,food,address, type,category, quantity, expiry_time, storage_condition, pickup_time, notes, agreement, food_image1, food_image2, food_image3)
                VALUES ('$name', '$phoneno', '$email', '$district','$foodname','$address', '$meal','$category', '$quantity', '$expiry_time', '$storage_condition', '$pickup_time', '$notes', '$agreement', '$food_image1', '$food_image2', '$food_image3')";

    if (mysqli_query($connection, $sql)) {
        // Add a notification for admin (Type: Donation)
        $message = "🍲 New food donation: $foodname ($quantity)";
        $notify_query = "INSERT INTO notifications (message, type) VALUES ('$message', 'donation')";
        mysqli_query($connection, $notify_query);

        echo "<script>alert('Donation submitted successfully!');</script>";
        // Redirect to thank you page
        header("Location: thankyou.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }

    mysqli_close($connection);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donation Form</title>
    <link rel="stylesheet" href="donate.css"> <!-- Linking CSS file -->
    <style>
        /* Remove snowflake styles */
        /* .snowflake {
            position: absolute;
            top: -10px;
            z-index: 9999;
            color: #fff;
            font-size: 1em;
            user-select: none;
            pointer-events: none;
            animation: fall linear infinite;
        }

        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        } */
    </style>
</head>

<body>
    <!-- Background and Overlay 
    <div class="background">
        <div class="overlay"></div>
    </div>  -->

    <div class="scroll-bg"></div>

    <!-- Remove Snowflakes -->
    <!-- <div id="snowflakes"></div> -->

    <!-- Form Container -->
    <div class="container">
        <center <p class="logo">Food <b style="color: #06C167; ">Donate</b></p>
        </center>

        <form action="donate.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="required">Donor Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" required>
            </div>

            <div class="form-group">
                <label class="required">Phone Number:</label>
                <input type="tel" name="phone" id="phone" maxlength="10" pattern="[0-9]{10}" required>
            </div>

            <div class="form-group">
                <label class="required">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
            </div>

            <div class="form-group">
                <label class="required">Location:</label>
                <select name="district" id="district" required>
                    <option value="chennai">chennai</option>
                    <option value="chengalpattu">chengalpattu</option>
                </select>
            </div>

            <div class="form-group">
                <label class="required">address:</label>
                <input type="text" name="address" id="address" placeholder="Enter the Address" required>
            </div>

            <div class="form-group">
                <label class="required">Food Name:</label>
                <input type="text" name="foodname" id="foodname" placeholder="Enter food name" required>
            </div>

            <div class="form-group">
                <label class="required">Type of Meal:</label>
                <select name="meal" id="meal" required>
                    <option value="">Select meal type</option>
                    <option value="Veg">Veg</option>
                    <option value="Non-Veg">Non-Veg</option>

                </select>

                <div class="form-group">
                    <label class="required">Select the Category:</label>
                    <select name="category" id="category" required>
                        <option value="">Select food type</option>
                        <option value="Cooked Meal">Cooked Meal</option>
                        <option value="Packed Food">Packed Food</option>
                        <option value="Fruits & Vegetables">Fruits & Vegetables</option>
                        <option value="Bakery Items">Bakery Items</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="required">Quantity (Number of Meals):</label>
                    <input type="number" name="quantity" id="quantity" placeholder="Enter number of meals" required>
                </div>

                <div class="form-group">
                    <label class="required">Food Expiry Time:</label>
                    <input type="datetime-local" name="expiry_time" id="expirt_time" required>
                </div>

                <div class="form-group">
                    <label class="required">Food Storage Condition (Optional):</label>
                    <select name="storage_condition" id="storage_condition" required>
                        <option value="">Select storage condition</option>
                        <option value="None">None</option>
                        <option value="Refrigeration Needed">Refrigeration Needed</option>
                        <option value="Dry Storage">Dry Storage</option>
                        <option value="Frozen">Frozen</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="required">Estimated Pickup Time (Optional):</label>
                    <input type="datetime-local" name="pickup_time" id="pickup_time" required>
                </div>

                <!-- Upload Image Button -->
                <button type="button" id="openmodal">Upload Food Images</button>

                <!-- Image Upload Modal -->
                <div id="imageModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h3>Upload Food Images (for Quality Check):</h3>

                        <label>Close-up of the food (to check freshness):</label>
                        <input type="file" name="food_image1" accept="image/*" />

                        <label>Full plate/container view (to ensure quantity matches):</label>
                        <input type="file" name="food_image2" accept="image/*" />

                        <label>Packaging image (to verify hygiene):</label>
                        <input type="file" name="food_image3" accept="image/*" />
                    </div>
                </div>

                <div class="form-group">
                    <label>Additional Notes (Optional):</label>
                    <textarea name="notes" placeholder="Mention special handling instructions"></textarea>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" name="agreement" required> I confirm that the food is fresh, safe, and suitable for donation.
                </div>

                <!-- Buttons -->
                <div class="button-container">
                    <!-- Replaced "Donate Food" button with the animated donation button -->
                    <div class="donate">
                        <form action="#">
                            <button type="submit" name="submit">Donate</button>
                        </form>
                    </div>

                    <!-- Animated Cancel Button -->
                    <div class="btn">
                        <div class="btn-back">
                            <p>Are you sure you want to cancel?</p>
                            <button class="yes">Yes</button>
                            <button class="no">No</button>
                        </div>
                        <div class="btn-front">Cancel</div>
                    </div>
                </div>
        </form>

        <p class="warning">
            ⚠️ <strong>WARNING:</strong> Providing false information or donating unsafe food may result in legal action under **Section 269 & 273 of the Indian Penal Code (IPC)**.
        </p>
    </div>


    <!-- JavaScript for Snowfall Effect -->
    <!-- <script>
        function createSnowflake() {
            const snowflake = document.createElement('div');
            snowflake.classList.add('snowflake');
            snowflake.textContent = '❄';
            snowflake.style.left = Math.random() * 100 + 'vw';
            snowflake.style.animationDuration = Math.random() * 3 + 2 + 's';
            document.getElementById('snowflakes').appendChild(snowflake);

            setTimeout(() => {
                snowflake.remove();
            }, 5000);
        }

        setInterval(createSnowflake, 100);
    </script> -->

    <!-- JavaScript for Animated Button -->
    <script>
        // Open and close modal for image upload
        document.getElementById("openmodal").addEventListener("click", function() {
            console.log("Upload button clicked"); // Debugging
            document.getElementById("imageModal").style.display = "block"; // Show the modal
        });

        document.querySelector(".close").addEventListener("click", function() {
            console.log("Close button clicked"); // Debugging
            document.getElementById("imageModal").style.display = "none"; // Hide the modal
        });

        window.addEventListener("click", function(event) {
            if (event.target == document.getElementById("imageModal")) {
                console.log("Clicked outside modal"); // Debugging
                document.getElementById("imageModal").style.display = "none"; // Hide the modal if clicked outside
            }
        });

        var btn = document.querySelector('.btn');
        var btnFront = btn.querySelector('.btn-front');
        var btnYes = btn.querySelector('.btn-back .yes');
        var btnNo = btn.querySelector('.btn-back .no');
        var donateButton = document.querySelector('.donate');

        btnFront.addEventListener('click', function(event) {
            var mx = event.clientX - btn.offsetLeft,
                my = event.clientY - btn.offsetTop;

            var w = btn.offsetWidth,
                h = btn.offsetHeight;

            var directions = [{
                    id: 'left',
                    x: 0,
                    y: h / 2
                },
                {
                    id: 'top',
                    x: w / 2,
                    y: 0
                },
                {
                    id: 'right',
                    x: w,
                    y: h / 2
                },
                {
                    id: 'bottom',
                    x: w / 2,
                    y: h
                }
            ];

            directions.sort(function(a, b) {
                return distance(mx, my, a.x, a.y) - distance(mx, my, b.x, b.y);
            });

            var direction = directions.shift().id;
            btn.setAttribute('data-direction', direction);
            btn.classList.add('is-open');

            // Hide the donate button during the flip animation
            donateButton.classList.add('hidden');

            // Rotate the button in the direction of the flip
            setTimeout(function() {
                btn.classList.add('rotate-' + direction);
            }, 300); // Adjust the delay as needed
        });

        btnYes.addEventListener('click', function(event) {
            btn.classList.remove('is-open');
            btn.classList.remove('rotate-left', 'rotate-right', 'rotate-top', 'rotate-bottom');
            setTimeout(function() {
                donateButton.classList.remove('hidden'); // Show the donate button again
                document.querySelector('form').reset(); // Clear the form
                // Display clear message
                var clearMessage = document.createElement('p');
                clearMessage.className = 'clear-message';
                clearMessage.textContent = 'The form has been cleared.';
                document.querySelector('.container').appendChild(clearMessage);
                // Remove the message after the animation ends
                clearMessage.addEventListener('animationend', function(event) {
                    if (event.animationName === 'fadeOut') {
                        clearMessage.remove();
                    }
                });
            }, 300);
        });

        btnNo.addEventListener('click', function(event) {
            btn.classList.remove('is-open');
            btn.classList.remove('rotate-left', 'rotate-right', 'rotate-top', 'rotate-bottom');
            setTimeout(function() {
                donateButton.classList.remove('hidden'); // Show the donate button again
            }, 300);
        });

        function distance(x1, y1, x2, y2) {
            var dx = x1 - x2;
            var dy = y1 - y2;
            return Math.sqrt(dx * dx + dy * dy);
        }

        //submit button
        document.querySelectorAll('.donate').forEach(function(elem) {
            const inputElement = elem.querySelector('input');
            const form = elem.querySelector('form');

            form.addEventListener('submit', e => {
                e.preventDefault();
                elem.classList.add('submit');
                alert("Donation submitted successfully!");
            });

            document.addEventListener('click', e => {
                if (e.target === form || form.contains(e.target)) {
                    return;
                }
                if (e.target === elem || elem.contains(e.target)) {
                    if (!elem.classList.contains('submit')) {
                        if (elem.classList.contains('open')) {
                            elem.classList.add('submit');
                        } else {
                            elem.classList.add('open');
                            setTimeout(() => {
                                inputElement.selectionStart = inputElement.selectionEnd = 10000;
                                inputElement.focus();
                            }, 0);
                        }
                    }
                } else {
                    elem.classList.remove('open');
                }
            });
        });
    </script>

</body>

</html>