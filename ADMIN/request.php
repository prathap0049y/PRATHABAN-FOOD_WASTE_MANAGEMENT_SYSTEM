<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_donation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update request status
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['action'] == 'accept' ? 'accepted' : 'rejected';
    $conn->query("UPDATE food_request SET status='$status' WHERE id=$id");
}

// Fetch donation requests
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM food_request WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR food LIKE '%$search%' OR pickup LIKE '%$search%'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="request.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add jQuery library -->
    <title>Admin Panel - Food Requests</title>
    <style>
        .body {
            background-color: rgb(57, 25, 201);
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }

        .status.pending {
            background-color: #f39c12;
        }

        .status.accepted {
            background-color: #2ecc71;
        }

        .status.rejected {
            background-color: #e74c3c;
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
                        <span class="link-name">Donations</span>
                    </a></li>
                <li><a href="request.php">
                        <i class="uil uil-heart"></i>
                        <span class="link-name">Requests</span>
                    </a></li>
                <li><a href="feedback.php">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">Feedback</span>
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
        <main class="table">
            <div class="table__header">
                <h2>Food Donation Requests</h2>
                <div class="input-group">

                    <form id="searchForm" onsubmit="submitFn(this, event);">
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" id="searchInput" class="search-input" placeholder="Type to search" />
                                <button class="search-icon" onclick="searchToggle(this, event);"><span></span></button>
                            </div>
                            <span class="close" onclick="searchToggle(this, event);"></span>
                            <div class="result-container"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th>Donor Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Food</th>
                            <th>Quantity</th>
                            <th>Pickup</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="requestTable">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td data-label="Donor Name"><?php echo $row['name']; ?></td>
                                <td data-label="Email"><?php echo $row['email']; ?></td>
                                <td data-label="Phone"><?php echo $row['phone']; ?></td>
                                <td data-label="Food"><?php echo $row['food']; ?></td>
                                <td data-label="Quantity"><?php echo $row['quantity']; ?></td>
                                <td data-label="Pickup"><?php echo nl2br($row['pickup']); ?></td>
                                <td data-label="Status" class="status <?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></td>
                                <td data-label="Action">
                                    <?php if ($row['status'] == 'pending'): ?>
                                        <a href="?action=accept&id=<?php echo $row['id']; ?>">Accept</a>
                                        <a href="?action=reject&id=<?php echo $row['id']; ?>">Reject</a>
                                    <?php else: ?>
                                        <span><?php echo ucfirst($row['status']); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
    <script>
        function searchToggle(obj, evt) {
            var container = $(obj).closest('.search-wrapper');

            if (!container.hasClass('active')) {
                container.addClass('active');
                evt.preventDefault();
            } else if (container.hasClass('active') && $(obj).closest('.input-holder').length == 0) {
                container.removeClass('active');
                // clear input
                container.find('.search-input').val('');
                // clear and hide result container when we press close
                container.find('.result-container').fadeOut(100, function() {
                    $(this).empty();
                });
            }
        }

        function submitFn(obj, evt) {
            evt.preventDefault();
            var value = $(obj).find('.search-input').val().trim();
            if (value.length) {
                window.location.href = "?search=" + value;
            } else {
                window.location.href = "?";
            }
        }
    </script>
    <script src="admin.js"></script>
</body>

</html>