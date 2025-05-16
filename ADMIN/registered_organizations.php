<?php
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');

// Fetch registered organizations
$organizations_query = "SELECT * FROM organizations";
$organizations_result = mysqli_query($connection, $organizations_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Organizations</title>
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

        /* Add styles for button alignment */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons a {
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .donations-btn {
            background-color: #2196F3;
        }

        .password-btn {
            background-color: #FF9800;
        }
    </style>
</head>

<body>
    <h1>Registered Organizations</h1>
    <table>
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
                <th>Actions</th>
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
                    <td>
                        <div class="action-buttons">
                            <a href="edit_organization.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="donations.php?organization_id=<?php echo $row['id']; ?>" class="donations-btn">View Donations</a>
                            <a href="change_password.php?id=<?php echo $row['id']; ?>" class="password-btn">Change Password</a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>