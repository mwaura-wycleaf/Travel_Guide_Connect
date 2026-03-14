<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Guide Connect</title>

    <!-- Link to my CSS -->
    <link rel="stylesheet" href="/Travel_Guide_Connect/assets/css/style.css">
</head>
<body>

<header>
    <div class="header-container">
        <!-- Logo -->
        <a href="../index.php">
            <img src="/Travel_Guide_Connect/images/Tlogo.jpeg" alt="Travel Guide Connect Logo" class="logo">
        </a>

        <!-- Navigation -->
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </div>
</header>