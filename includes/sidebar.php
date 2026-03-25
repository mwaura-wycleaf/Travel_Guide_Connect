<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar" style="width: 250px; background: #2c3e50; height: 100vh; position: fixed; left: 0; top: 0; padding: 25px; color: white; z-index: 1000;">
    <h2 style="color: #27ae60; text-align: center; margin-bottom: 10px; font-weight: bold;">Guide Panel</h2>
    <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin-bottom: 30px;">
    
    <nav>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;">
                <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>
            
            <li style="margin-bottom: 10px;">
                <a href="availability.php" class="nav-link <?php echo ($current_page == 'availability.php') ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-check"></i> Availability
                </a>
            </li>
            
            <li style="margin-bottom: 10px;">
                <a href="reviews.php" class="nav-link <?php echo ($current_page == 'reviews.php') ? 'active' : ''; ?>">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </li>

            <li style="margin-top: 20px;">
                <a href="includes/guide_logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
</div>

<style>
    .nav-link {
        color: #bdc3c7;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 8px;
        transition: 0.3s;
        gap: 15px;
    }
    .nav-link:hover {
        background: rgba(255,255,255,0.1);
        color: white;
    }
    /* The Green Highlight from your screenshot */
    .nav-link.active {
        background: rgba(39, 174, 96, 0.1);
        color: #27ae60 !important;
        font-weight: bold;
    }
</style>