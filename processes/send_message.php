<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_guide_connect"; // Make sure this matches your DB name in phpMyAdmin
$port = 3307; // Using your fixed port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and clean the data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // The SQL command
    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Go back to the contact page and show success
        header("Location: ../contact.php?status=success");
    } else {
        // Go back and show error
        header("Location: ../contact.php?status=error");
    }
}
$conn->close();
?>