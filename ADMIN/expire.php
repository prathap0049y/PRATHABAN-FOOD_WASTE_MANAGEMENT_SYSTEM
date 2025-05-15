<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "food_donation");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current date and time using DateTime
$current_time = new DateTime();
$current_time_formatted = $current_time->format("Y-m-d H:i:s");

// Check for expired food donations
$sql = "SELECT Fid, food, name, expiry_time FROM food_donations WHERE status != 'Expired'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $food_id = $row['Fid'];
        $expiry_time = new DateTime($row['expiry_time']);

        // Compare expiry time with current time
        if ($expiry_time <= $current_time) {
            // Update status to "Expired"
            $update_sql = "UPDATE food_donations SET status='Expired' WHERE Fid=$food_id";
            if ($conn->query($update_sql) === TRUE) {
                echo "Status updated for food ID: $food_id<br>";
            } else {
                echo "Error updating status for food ID: $food_id - " . $conn->error . "<br>";
            }
        }
    }
}

// Backup database
$host = "localhost";
$username = "root";
$password = "";
$database = "food_donation";

// Backup file name with timestamp
$backupFile = "C:/xampp/htdocs/food_donation/db_backups/backup_" . $current_time->format("Y-m-d_H-i-s") . ".sql";

// Ensure the backup directory exists
if (!is_dir("C:/xampp/htdocs/food_donation/db_backups")) {
    mkdir("C:/xampp/htdocs/food_donation/db_backups", 0777, true);
}

// MySQL dump command
$command = "C:/xampp/mysql/bin/mysqldump --host=$host --user=$username --password=$password $database > $backupFile";

// Execute the command
exec($command, $output, $return_var);

// Check if the backup was successful
if ($return_var === 0) {
    echo "Database backup created successfully: " . $backupFile;
} else {
    echo "Error in database backup.";
}

$conn->close();
