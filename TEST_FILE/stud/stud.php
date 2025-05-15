<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>
    <link rel="stylesheet" href="stud.css">
    <style>
        .sidebar .menu-items i {
            font-size: 20px;
            /* Bigger icon size */
            margin-right: 10px;
            /* Space between icon and text */
        }

        .sidebar .menu-items a {
            display: flex;
            align-items: center;
            font-size: 19px;
            /* Bigger text */
        }

        
    </style>
</head>

<body>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!-- Sidebar (Same as before) -->
    <nav class="sidebar">
        <div class="logo-name"></div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="Dash.php"><i class="bx bx-home"></i><span class="link-name">Dashboard</span></a></li>
                <li><a href="STregist.html"><i class="bx bx-user-plus"></i><span class="link-name">Student Registration</span></a></li>
                <li><a href="Staff.php"><i class="bx bx-user"></i><span class="link-name">Staff Registration</span></a></li>
                <li><a href="Book Reg.php"><i class="bx bx-book-add"></i><span class="link-name">Book Registration</span></a></li>
                <li><a href="BookAvail.php"><i class="bx bx-book"></i><span class="link-name">Book Availability</span></a></li>
                <li><a href="#"><i class="bx bx-book-reader"></i><span class="link-name">Book Issue</span></a></li>
                <li><a href="book-report.php"><i class="bx bx-file"></i><span class="link-name">Book Report</span></a></li>
                <li><a href="student-info.php"><i class="bx bx-group"></i><span class="link-name">Student Info</span></a></li>
                <li><a href="staff-info.php"><i class="bx bx-id-card"></i><span class="link-name">Staff Info</span></a></li>
                <li><a href="fine-details.php"><i class="bx bx-money"></i><span class="link-name">Fine Details</span></a></li>
                <li><a href="profile.php"><i class="bx bx-notification"></i><span class="link-name">Notification</span></a></li>
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
    </section>

    <script src="JAVA.js"></script>

    <main class="table" id="customers_table">

        <h1>Students Info</h1>
        <form>
            <div class="input-field">
                <label class="form-label" style="text-align: left;">Name</label>
                <input type="text" name="name" placeholder="Enter full name" required>
            </div>
            <div class="input-field">
                <label class="form-label">Class</label>
                <select id="class" required onchange="updateYearOptions()">
                    <option value="" disabled selected>Select class</option>
                    <option value="UG">UG</option>
                    <option value="PG">PG</option>
                </select>
            </div>
            <div class="input-field">
                <label class="form-label">Year</label>
                <select id="year" required>
                    <option value="" disabled selected>Select year</option>
                    <option value="BSc 1st">BSc 1st</option>
                    <option value="BSc 2nd">BSc 2nd</option>
                    <option value="BSc 3rd">BSc 3rd</option>
                    <option value="MSc 1st">MSc 1st</option>
                    <option value="MSc 2nd">MSc 2nd</option>
                </select>
            </div>
            <button class="Search" onclick="SearchStudent(<?php echo $row['name']; ?>)">Search</button>
        </form>

        <section class="table__body">
            <table class="table" id="customers_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Class</th> <!-- Fixed class name problem -->
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </section>
    </main>

    <script>
        function updateYearOptions() {
            const classSelect = document.getElementById('class');
            const yearSelect = document.getElementById('year');
            const selectedClass = classSelect.value;

            // Clear existing options
            yearSelect.innerHTML = '<option value="" disabled selected>Select year</option>';

            if (selectedClass === 'UG') {
                yearSelect.innerHTML += '<option value="BSc 1st">BSc 1st</option>';
                yearSelect.innerHTML += '<option value="BSc 2nd">BSc 2nd</option>';
                yearSelect.innerHTML += '<option value="BSc 3rd">BSc 3rd</option>';
            } else if (selectedClass === 'PG') {
                yearSelect.innerHTML += '<option value="MSc 1st">MSc 1st</option>';
                yearSelect.innerHTML += '<option value="MSc 2nd">MSc 2nd</option>';
            }
        }

        function editStudent(id) {
            // Redirect to the edit page with the student ID
            window.location.href = 'edit_student.php?id=' + id;
        }

        const search = document.querySelector('.input-group input');

        if (search) {
            console.log("Search bar found!");

            search.addEventListener('input', function() {
                let search_data = search.value.trim().toLowerCase();
                let table_rows = document.querySelectorAll('tbody tr');

                console.log("Search query:", search_data);

                table_rows.forEach((row, i) => {
                    let table_data = row.textContent.toLowerCase();
                    console.log("Row " + i + " content:", table_data);

                    let match = table_data.includes(search_data);
                    row.classList.toggle('hide', !match);
                    row.style.setProperty('--delay', i / 25 + 's');

                    console.log("Row " + i + " visibility:", match ? "Visible" : "Hidden");
                });

                document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
                    visible_row.style.backgroundColor = (i % 2 === 0) ? 'transparent' : '#0000000b';
                });
            });
        } else {
            console.log("Search bar NOT found! Check your HTML.");
        }
    </script>
</body>

</html>