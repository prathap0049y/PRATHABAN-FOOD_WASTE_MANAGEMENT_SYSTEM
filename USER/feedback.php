<?php
session_name("user_session");
session_start();    
include 'connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Ensure the database connection is established
$connection = mysqli_connect("localhost", "root", "", "food_donation");

if (!$connection) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $msg = $_POST['message'];

    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_name = mysqli_real_escape_string($connection, $name);
    $sanitized_msg = mysqli_real_escape_string($connection, $msg);

    $query = "INSERT INTO user_feedback(name, email, message) VALUES('$sanitized_name', '$sanitized_emailid', '$sanitized_msg')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        // Send an automatic email
        $mail = new PHPMailer(true);
        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Use your email provider's SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'prathabans428@gmail.com'; // Your email
            $mail->Password = 'zaya uxwg uwcf uynu'; // Your email password (Use App Passwords if 2FA is enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender and recipient
            $mail->setFrom('prathabans428@gmail.com', 'Food Donation Platform');
            $mail->addAddress($sanitized_emailid, $sanitized_name); // Send email to the user who submitted feedback

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Thank you for your feedback!';
            $mail->Body = "
                <h3>Hello $sanitized_name,</h3>
                <p>Thank you for your valuable feedback! We appreciate your time and effort in helping us improve our platform.</p>
                <p><strong>Your Message:</strong> $sanitized_msg</p>
                <p>We will get back to you soon if necessary.</p>
                <p>Best Regards,<br>Food Donation Platform Team</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            echo "Email could not be sent. Error: {$mail->ErrorInfo}";
        }

        // Redirect back to the contact page
        header("Location: contact.html");
        exit();
    } else {
        echo '<script type="text/javascript">alert("Data not saved")</script>';
    }
}
?>
