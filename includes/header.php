<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set the base path dynamically for Port 8080
$base_url = "http://localhost:8080/Travel_Guide_Connect/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- EMBEDDED HEADER CSS --- */
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
            z-index: 1000;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            height: 50px;
            width: auto;
            border-radius: 5px;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            gap: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 600;
            font-size: 1rem;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: var(--primary-color);
        }

        .nav-btn {
            background: var(--primary-color);
            color: white !important;
            padding: 8px 20px;
            border-radius: 20px;
        }

        .nav-btn:hover {
            background: #2ecc71;
        }

        /* Mobile Menu Toggle (Simplified) */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 10px;
            }
            nav ul {
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <a href="<?php echo $base_url; ?>index.php">
            <img src="<?php echo $base_url; ?>images/Tlogo.jpeg" alt="Logo" class="logo">
        </a>

        <nav>
            <ul>
                <li><a href="<?php echo $base_url; ?>index.php">Home</a></li>
                
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <?php if($_SESSION["role"] == "admin"): ?>
                        <li><a href="<?php echo $base_url; ?>admin/dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo $base_url; ?>auth/logout.php" class="nav-btn">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo $base_url; ?>auth/login.php">Login</a></li>
                    <li><a href="<?php echo $base_url; ?>auth/signup.php" class="nav-btn">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>