<?php
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');

// Fetch donations, optionally filter by organization
$organization_id = isset($_GET['organization_id']) ? $_GET['organization_id'] : null;
$donations_query = $organization_id
    ? "SELECT * FROM donations WHERE organization_id = $organization_id"
    : "SELECT * FROM donations";
$donations_result = mysqli_query($connection, $donations_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Donations</h1>
    <?php if ($organization_id): ?>
        <p>Showing donations for organization ID: <?php echo $organization_id; ?></p>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Donor Name</th>
                <th>Organization</th>
                <th>Donation Type</th>
                <th>Quantity</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($donations_result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['donor_name']; ?></td>
                    <td><?php echo $row['organization_name']; ?></td>
                    <td><?php echo $row['donation_type']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>