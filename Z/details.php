<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="BookAvail.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Book Details</title>
</head>

<body>

    <!-- Include Boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="logo-name"></div>
        <div class="menu-items">

            <ul class="nav-links">
                <li><a href="Dash.html"><i class="bx bx-home"></i><span class="link-name">Dashboard</span></a></li>
                <li><a href="STregist.html"><i class="bx bx-user-plus"></i><span class="link-name">Student Registration</span></a></li>
                <li><a href="Staff.php"><i class="bx bx-user"></i><span class="link-name">Staff Registration</span></a></li>
                <li><a href="Book Reg.php"><i class="bx bx-book-add"></i><span class="link-name">Book Registration</span></a></li>
                <li><a href="BookAvail.php"><i class="bx bx-book"></i><span class="link-name">Book Availability</span></a></li>
                <li><a href="#"><i class="bx bx-book-reader"></i><span class="link-name">Book Issue</span></a></li>
                <li><a href="#"><i class="bx bx-file"></i><span class="link-name">Book Report</span></a></li>
                <li><a href="#"><i class="bx bx-notification"></i><span class="link-name">Student Info</span></a></li>
                <li><a href="profile.php"><i class="bx bx-user-circle"></i><span class="link-name">Staff Info</span></a></li>
                <li><a href="profile.php"><i class="bx bx-user-circle"></i><span class="link-name">Fine Details</span></a></li>
                <li><a href="profile.php"><i class="bx bx-user-circle"></i><span class="link-name">Notification</span></a></li>
                <li><a href="profile.php"><i class="bx bx-user-circle"></i><span class="link-name">My Account</span></a></li>
            </ul>
        </div>
        <i class="bx bx-menu sidebar-toggle"></i>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo"></p>
            <img src="users.png" alt="">
        </div>

        <!-- Staff Registration Form Start -->
        <div class="container">
            <header>Book Availability</header>

            <form action="" method="POST">
                <div class="form first">
                    <div class="details personal">
                        <span class="title"></span>
                        <div class="fields">
                            <div class="input-field">
                                <label>Access No*</label>
                                <input type="text" name="access_no" placeholder="Access No">
                            </div>

                        </div>
                    </div>


                    <div class="buttons">
                        <button type="submit" name="get_details">Get Details</button>
                        <button type="submit" name="show_all">Show All Books</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Staff Registration Form End -->

    <div class="table-container">

        <?php
        include 'db_connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["get_details"])) {
            $access_no = $_POST["access_no"];

            // Debugging: Check if access_no is received


            // Fetch book details
            $sql = "SELECT * FROM book WHERE access_no = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("s", $access_no);
            if (!$stmt->execute()) {
                die("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table class='styled-table'>";
                echo "<tr><th>Access No</th><th>Book Name</th><th>Author</th><th>Price</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>{$row['access_no']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['price']}</td>
                  </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color:red;'>No book found with the given details.</p>";
            }
            $stmt->close();
        }

        // Show all books
        if (isset($_POST["show_all"])) {
            $sql = "SELECT * FROM book ORDER BY create_time DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr><th>Access No</th><th>Book Name</th><th>Author</th><th>Price</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>{$row['access_no']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['price']}</td>
                  </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color:red;'>No books found in the database.</p>";
            }
        }
        ?>

    </div>

    </div>

   <script src="JAVA.js"></script>
</body>

</html>