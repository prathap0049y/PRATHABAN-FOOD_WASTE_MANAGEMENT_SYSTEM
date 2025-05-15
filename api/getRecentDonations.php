<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_donation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, quantity, date FROM food_donations ORDER BY date DESC LIMIT 10";
$result = $conn->query($sql);

$donations = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $donations[] = $row;
  }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($donations);
?>
