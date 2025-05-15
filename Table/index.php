<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_donation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = "SELECT * FROM food_request ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donation Requests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        
    </header>
    
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>Food Donation Requests</h1>
            <div class="input-group">
                <input type="text" placeholder="Search...">
                <img src="search.png" alt="Search">
            </div>
            <div class="export__file">
                <button class="export__file-btn" id="toPDF"></button>
            </div>
        </section>
        
        <section class="table__body">
            <table class="table" id="customers_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Food</th>
                        <th>Quantity</th>
                        <th>Pickup</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['food']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['pickup']; ?></td>
                            <td class="status <?php echo strtolower($row['status']); ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </td>
                            <td>
                                <button class="accept-btn">Accept</button>
                                <button class="reject-btn">Reject</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
    
    <script>
     const search = document.querySelector('.input-group input');

if (search) {
    console.log("Search bar found!");

    search.addEventListener('input', function () {
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