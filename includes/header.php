<?php
// Ensure session is started for login/logout logic
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define the base URL - Adjust the port if yours is 80 or 8080
$base_url = "http://localhost:8080/Travel_Guide_Connect/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #27ae60;
            --dark-color: #2c3e50;
            --light-color: #ffffff;
        }

        header {
            background-color: var(--light-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo-container img {
            height: 50px;
            width: auto;
            border-radius: 5px;
            display: block;
        }

        .main-nav-list {
            list-style: none;
            display: flex; 
            margin: 0;
            padding: 0;
            gap: 20px;
            align-items: center;
        }

        .main-nav-list li a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 600;
            font-size: 1rem;
            transition: 0.3s;
        }

        .main-nav-list li a:hover { 
            color: var(--primary-color); 
        }

        .nav-btn {
            background: var(--primary-color);
            color: white !important;
            padding: 8px 20px;
            border-radius: 20px;
        }

        /* Responsive menu for smaller screens */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <a href="<?php echo $base_url; ?>index.php" class="logo-container">
            <img src="<?php echo $base_url; ?>images/Tlogo.png" alt="Travel Guide Connect Logo">
        </a>
        
        <nav>
            <ul class="main-nav-list">
                <li><a href="<?php echo $base_url; ?>index.php">Home</a></li>
                <li><a href="<?php echo $base_url; ?>destinations.php">Destinations</a></li>
                
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <li><a href="<?php echo $base_url; ?>dashboard.php">My Account</a></li>
                    <li><a href="<?php echo $base_url; ?>auth/logout.php" class="nav-btn">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo $base_url; ?>auth/login.php">Login</a></li>
                    <li><a href="<?php echo $base_url; ?>auth/signup.php" class="nav-btn">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>