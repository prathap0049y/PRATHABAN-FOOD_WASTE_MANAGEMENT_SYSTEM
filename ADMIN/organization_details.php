<?php

ob_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
include("connect.php");
if ($_SESSION['name'] == '') {
    header("location:signin.php");
}

// Fetch registered organizations
$organizations_query = "SELECT * FROM organizations";
$organizations_result = mysqli_query($connection, $organizations_query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="registered_users.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Organization Details</title>
    <style>
        body {
            background-image: url('background.jpg');
            background-size: cover;
            background-attachment: fixed;
        }

        .note {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            /* Responsive layout */
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            /* Center the grid on the page */
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            padding: 20px;
            box-sizing: border-box;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .card h2 {
            background-color: #6a0dad;
            color: white;
            margin: 0;
            padding: 15px;
            font-size: 1.5em;
        }

        .card p {
            color: #555;
            font-size: 1em;
            margin: 10px 15px;
            line-height: 1.5;
        }

        .card .address {
            font-style: italic;
            color: #777;
        }

        .card-footer {
            background-color: #f9f9f9;
            padding: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            margin-top: auto;
            /* Push the footer to the bottom */
        }

        .card-footer a {
            text-decoration: none;
            color: white;
            background-color: #6a0dad;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        .card-footer a:hover {
            background-color: #4e0c83;
            transform: scale(1.05);
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
        }

        .form-container h2 {
            background-color: #6a0dad;
            color: white;
            margin: 0;
            padding: 15px;
            font-size: 1.5em;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .form-container input,
        .form-container textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .form-container button {
            background-color: #6a0dad;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .form-container button:hover {
            background-color: #4e0c83;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>
            <span class="logo_name">ADMIN</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                <li><a href="analytics.php">
                        <i class="uil uil-chart"></i>
                        <span class="link-name">Analytics</span>
                    </a></li>
                <li><a href="donate.php">
                        <i class="uil uil-heart"></i>
                        <span class="link-name">Donates</span>
                    </a></li>
                <li><a href="request.php">
                        <i class="uil uil-clipboard-notes"></i>
                        <span class="link-name">Request</span>
                    </a></li>
                <li><a href="feedback.php">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">Feedbacks</span>
                    </a></li>
                <li><a href="adminprofile.php">
                        <i class="uil uil-user"></i>
                        <span class="link-name">Profile</span>
                    </a></li>
                <li><a href="registered_users.php">
                        <i class="uil uil-users-alt"></i>
                        <span class="link-name">Registered Users</span>
                    </a></li>
                <li><a href="organization_details.php">
                        <i class="uil uil-building"></i>
                        <span class="link-name">Organizations</span>
                    </a></li>
                <li><a href="delivery_persons_details.php">
                        <i class="uil uil-truck"></i>
                        <span class="link-name">Delivery Persons</span>
                    </a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>
                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
            <p class="user"></p>
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-building"></i>
                    <span class="text">Organization Details</span>
                </div>
                <div class="form-container">
                    <h2>Register New Organization</h2>
                    <form action="register_organization.php" method="POST">
                        <label for="org_name">Organization Name:</label>
                        <input type="text" id="org_name" name="organization_name" required>

                        <label for="owner_name">Owner Name:</label>
                        <input type="text" id="owner_name" name="owner_name" required>

                        <label for="org_id">Organization ID:</label>
                        <input type="text" id="org_id" name="org_id" required>

                        <label for="state">State:</label>
                        <input type="text" id="state" name="state" required>

                        <label for="district">District:</label>
                        <input type="text" id="district" name="district" required>

                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" required>

                        <label for="street">Street:</label>
                        <input type="text" id="street" name="street" required>

                        <label for="pincode">Pincode:</label>
                        <input type="text" id="pincode" name="pincode" required>

                        <label for="phone_no">Phone Number:</label>
                        <input type="text" id="phone_no" name="phone_no" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>

                        <button type="submit">Register</button>
                    </form>
                </div>

                <div class="form-container">
                    <h2>Add Delivery Address</h2>
                    <form action="add_delivery_address.php" method="POST">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required>

                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" required>

                        <label for="state">State:</label>
                        <input type="text" id="state" name="state" required>

                        <label for="postal_code">Postal Code:</label>
                        <input type="text" id="postal_code" name="postal_code" required>

                        <button type="submit">Add Address</button>
                    </form>
                </div>

                <!-- Removed the "Show Donations" button -->
                <div style="text-align: center; margin-top: 20px;">
                    <a href="registered_organizations.php" target="_blank" style="text-decoration: none;">
                        <button style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">Show Registered Organizations</button>
                    </a>
                </div>

                <div id="organizationList" style="display: none; margin-top: 20px;">
                    <h2 style="text-align: center;">Registered Organizations</h2>
                    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Organization Name</th>
                                <th>Owner Name</th>
                                <th>State</th>
                                <th>District</th>
                                <th>City</th>
                                <th>Street</th>
                                <th>Pincode</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($organizations_result)) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['organization_name']; ?></td>
                                    <td><?php echo $row['owner_name']; ?></td>
                                    <td><?php echo $row['state']; ?></td>
                                    <td><?php echo $row['district']; ?></td>
                                    <td><?php echo $row['city']; ?></td>
                                    <td><?php echo $row['street']; ?></td>
                                    <td><?php echo $row['pincode']; ?></td>
                                    <td><?php echo $row['phone_no']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="note">

                    <!-- Card 1 -->
                    <div class="card">
                        <img src="img/child-1.jpg" alt="Sarada Sakthi Peetam">
                        <h2>Sarada Sakthi Peetam</h2>
                        <p class="address">Urapakkam,Chengalpattu</p>
                        <p>Phone: 09980921341</p>
                        <div class="card-footer">
                            <a href="https://www.sspeetam.in/" target="_blank">View Details</a>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="card">
                        <img src="img/child-2.jpg" alt="Bodhimaram Old Age Home">
                        <h2>Bodhimaram Old Age Home</h2>
                        <p class="address">Gorimedu,Salem</p>
                        <p>Phone: 07383162072</p>
                        <div class="card-footer">
                            <a href="http://www.bodhimaramoldagehome.com/" target="_blank">View Details</a>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="card">
                        <img src="img/child-3.jpg" alt="Bharathamadha Family Welfare Foundation">
                        <h2>Bharathamadha Family Welfare Foundation</h2>
                        <p class="address">THIRUTHURAIPOONDI TOWN,Thiruthuraipoondi</p>
                        <p>Phone: 07383162072</p>
                        <div class="card-footer">
                            <a href="https://ourbharathamatha.org/" target="_blank">View Details</a>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="card">
                        <img src="img/child-4.jpg" alt="Sivananda Gurukulam">
                        <h2>Sivananda Gurukulam</h2>
                        <p class="address">Kattankolathur,Chengalpattu</p>
                        <p>Phone: 07383162072</p>
                        <div class="card-footer">
                            <a href="https://buildhope.org/" target="_blank">View Details</a>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="card">
                        <img src="img/child-5.png" alt="Udhavum Ullangal">
                        <h2>Udhavum Ullangal</h2>
                        <p class="address">Melrosapuram,Chengalpattu</p>
                        <p>Phone: +91-44-24344743</p>
                        <div class="card-footer">
                            <a href="https://udhavumullangal.org.in/" target="_blank">View Details</a>
                        </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="card">
                        <img src="img/child-6.jfif" alt="Universal Welfare Foundation">
                        <h2>Universal Welfare Foundation</h2>
                        <p class="address">Oragadam,Chengalpattu</p>
                        <p>Phone: 9415313790</p>
                        <div class="card-footer">
                            <a href="https://universalwelfarefoundation.org.in/" target="_blank">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="admin.js"></script>
    <script>
        document.getElementById('showOrganizationsBtn').addEventListener('click', function() {
            const organizationList = document.getElementById('organizationList');
            organizationList.style.display = organizationList.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>

</html>