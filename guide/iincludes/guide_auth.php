<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in AND if they are a guide
if (!isset($_SESSION['guide_id']) || $_SESSION['role'] !== 'guide') {
    header("Location: guide_login.php");
    exit();
}
?>