<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is missing the ID OR is not a guide
if (!isset($_SESSION['guide_id']) || $_SESSION['role'] !== 'guide') {
    // If this file is in guide/includes/, we go UP one level to find the login
    header("Location: guide_login.php"); 
    exit();
}
?>