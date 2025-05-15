<?php
include 'db_connect.php'; // Include your database connection file

$message = ""; // To display messages after book return

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $access_no = $_POST['access_no'];
    $book_id = $_POST['book_id'];
    $return_date = $_POST['return_date'];

    // Check if the book was issued and is still not returned
    $check_query = "SELECT id FROM book_issue WHERE access_no = ? AND book_id = ? AND status = 'issued'";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("si", $access_no, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $issue = $result->fetch_assoc();

    if ($issue) {
        // Update book issue table
        $update_issue_query = "UPDATE book_issue SET return_date = ?, status = 'returned' WHERE access_no = ? AND book_id = ?";
        $stmt = $conn->prepare($update_issue_query);
        $stmt->bind_param("ssi", $return_date, $access_no, $book_id);
        $stmt->execute();

        // Increase available quantity
        $update_book_query = "UPDATE book SET avail_quantity = avail_quantity + 1 WHERE access_no = ? AND id = ?";
        $stmt = $conn->prepare($update_book_query);
        $stmt->bind_param("si", $access_no, $book_id);
        $stmt->execute();

        $message = "<div class='success-message animate-message'>✅ Book Returned Successfully!</div>";
    } else {
        $message = "<div class='error-message animate-message'>❌ Invalid Return Request!</div>";
    }
}

// Fetch issued books to display in the table
$issued_books_query = "SELECT * FROM book_issue WHERE status = 'issued'";
$issued_books = $conn->query($issued_books_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Book</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS file (optional) -->
    <style>
        /* General Page Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background: linear-gradient(to right, #4facfe, #00f2fe);
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 500px;
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Form Styling */
        .input-container {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #00f2fe;
            box-shadow: 0px 0px 10px rgba(0, 242, 254, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 6px;
            transition: 0.3s;
        }

        button:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Table Styling */
        .table-container {
            margin-top: 30px;
            width: 90%;
            max-width: 1000px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #4facfe;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #d1ecf1;
            transition: 0.3s;
        }

        /* Success & Error Messages */
        .success-message, .error-message {
            font-size: 16px;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            display: inline-block;
            font-weight: bold;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Animation for Messages */
        .animate-message {
            animation: slideIn 0.6s ease-in-out;
        }

        /* Fade-in Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Slide-in Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Return Book</h2>
        <?= $message; ?> <!-- Display success/error message -->

        <form action="" method="POST">
            <div class="input-container">
                <label>Access No</label>
                <input type="text" name="access_no" required>
            </div>

            

            <div class="input-container">
                <label>Return Date</label>
                <input type="date" name="return_date" required>
            </div>

            <button type="submit">Return Book</button>
        </form>
    </div>

    <!-- Issued Books Table -->
    <div class="table-container">
        <h2>Issued Books</h2>
        <table>
            <tr>
                <th>Access No</th>
                <th>Book Name</th>
                <th>Issued To</th>
                <th>Issued Date</th>
                <th>Due Date</th>
            </tr>
            <?php while ($row = $issued_books->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['access_no'] ?></td>
                    <td><?= $row['book_name'] ?></td>
                    <td><?= $row['receiver'] == 'student' ? $row['student_name'] : $row['staff_name'] ?></td>
                    <td><?= $row['issued_date'] ?></td>
                    <td><?= $row['due_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>
