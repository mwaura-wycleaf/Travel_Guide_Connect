<?php
// Ensure session is started for login logic
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure base_url is defined - Adjust port if necessary
$base_url = "http://localhost:8080/Travel_Guide_Connect/";
?>

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

    /* Target the logo class directly */
    .logo { 
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

    .main-nav-list li a:hover { color: var(--primary-color); }

    .nav-btn {
        background: var(--primary-color);
        color: white !important;
        padding: 8px 20px;
        border-radius: 20px;
    }
</style>

<header>
    <div class="header-container">
        <a href="<?php echo $base_url; ?>index.php">
            <img src="<?php echo $base_url; ?>images/Tlogo.png" alt="Logo" class="logo">
        </a>

        <nav>
            <ul class="main-nav-list"> 
                <li><a href="<?php echo $base_url; ?>index.php">Home</a></li>
                
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <li><a href="<?php echo $base_url; ?>auth/logout.php" class="nav-btn">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo $base_url; ?>auth/login.php">Login</a></li>
                    <li><a href="<?php echo $base_url; ?>auth/signup.php" class="nav-btn">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>