<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in AND has the 'admin' role
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'admin') {
    // Redirect them to the admin login page
    header("location: admin_login.php?error=unauthorized");
    exit;
}
?>