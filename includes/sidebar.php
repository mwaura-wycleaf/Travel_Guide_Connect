<?php
$is_admin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar-wrapper">
    <div class="sidebar-brand">
        <h2><?php echo $is_admin ? 'Admin' : 'Guide'; ?> Panel</h2>
    </div>
    
    <hr class="sidebar-divider">
    
    <nav class="sidebar-nav">
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="dashboard.php" class="sidebar-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>

            <?php if ($is_admin): ?>
                <li class="sidebar-item">
                    <a href="manage_attractions.php" class="sidebar-link <?php echo ($current_page == 'manage_attractions.php') ? 'active' : ''; ?>">
                        <i class="fas fa-map-marked-alt"></i> Destinations
                    </a>
                </li>
            <?php else: ?>
                <li class="sidebar-item">
                    <a href="availability.php" class="sidebar-link <?php echo ($current_page == 'availability.php') ? 'active' : ''; ?>">
                        <i class="fas fa-calendar-check"></i> Availability
                    </a>
                </li>
            <?php endif; ?>

            <li class="sidebar-item">
                <a href="manage_reviews.php" class="sidebar-link <?php echo ($current_page == 'reviews.php') ? 'active' : ''; ?>">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </li>

            <li class="sidebar-item logout-box">
                <a href="../auth/logout.php" class="sidebar-link logout-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
</div>

<style>
    .sidebar-wrapper {
        width: 250px;
        background: #2c3e50;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        padding: 25px;
        color: white;
        z-index: 1001; /* Higher than header */
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    .sidebar-brand h2 {
        color: #27ae60;
        text-align: center;
        font-size: 1.4rem;
        margin-bottom: 10px;
    }

    .sidebar-divider {
        border: 0;
        border-top: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 25px;
    }

    /* Force Verticality */
    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex !important;
        flex-direction: column !important; /* Forces the downwards stack */
        gap: 10px;
    }

    .sidebar-item {
        display: block;
        width: 100%;
    }

    .sidebar-link {
        color: #bdc3c7;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-radius: 8px;
        transition: 0.3s;
        gap: 15px;
        width: 100%;
        box-sizing: border-box;
    }

    .sidebar-link:hover {
        background: rgba(255,255,255,0.1);
        color: white;
    }

    .sidebar-link.active {
        background: rgba(39, 174, 96, 0.2);
        color: #2ecc71 !important;
        font-weight: bold;
    }

    .logout-box {
        margin-top: auto; /* Pushes logout to bottom */
        padding-top: 20px;
    }

    .logout-link:hover {
        background: rgba(231, 76, 60, 0.2);
        color: #e74c3c;
    }
</style>