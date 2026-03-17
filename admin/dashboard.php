<?php
session_start();
// Security Check: Redirect if not an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// 1. Database and Header includes
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

// 2. Fetch counts (Using your $link variable from db.php)
$guides = mysqli_num_rows(mysqli_query($link, "SELECT * FROM guides"));
$users = mysqli_num_rows(mysqli_query($link, "SELECT * FROM users"));
$attractions = mysqli_num_rows(mysqli_query($link, "SELECT * FROM attractions"));
$bookings = mysqli_num_rows(mysqli_query($link, "SELECT * FROM bookings"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* EMBEDDED DASHBOARD STYLES */
        body {
            background-color: #f4f7f6;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-content {
            margin-left: 260px; /* Space for your sidebar */
            padding: 30px;
            transition: all 0.3s;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin: 0;
        }

        /* Stats Grid */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-bottom: 4px solid transparent;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        /* Specific card colors */
        .card-guides { border-color: #3498db; }
        .card-attractions { border-color: #27ae60; }
        .card-users { border-color: #f1c40f; }
        .card-bookings { border-color: #e74c3c; }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            margin-right: 20px;
        }

        /* Light backgrounds for icons */
        .bg-blue { background: rgba(52, 152, 219, 0.1); color: #3498db; }
        .bg-green { background: rgba(39, 174, 96, 0.1); color: #27ae60; }
        .bg-yellow { background: rgba(241, 196, 15, 0.1); color: #f39c12; }
        .bg-red { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }

        .stat-info h3 {
            margin: 0;
            font-size: 0.9rem;
            color: #7f8c8d;
            text-transform: uppercase;
        }

        .stat-info p {
            margin: 5px 0 0;
            font-size: 1.8rem;
            font-weight: bold;
            color: #2c3e50;
        }

        /* Responsive Fix for your Tecno Spark 10 */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .sidebar { display: none; } /* Hide sidebar on mobile if not toggled */
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="dashboard-header">
        <h1>Overview</h1>
        <p class="text-muted">Welcome back, <?php echo $_SESSION['admin_email']; ?></p>
    </div>

    <div class="cards-container">
        <div class="stat-card card-guides">
            <div class="icon-box bg-blue">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-info">
                <h3>Total Guides</h3>
                <p><?php echo $guides; ?></p>
            </div>
        </div>

        <div class="stat-card card-attractions">
            <div class="icon-box bg-green">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <div class="stat-info">
                <h3>Attractions</h3>
                <p><?php echo $attractions; ?></p>
            </div>
        </div>

        <div class="stat-card card-users">
            <div class="icon-box bg-yellow">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Users</h3>
                <p><?php echo $users; ?></p>
            </div>
        </div>

        <div class="stat-card card-bookings">
            <div class="icon-box bg-red">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-info">
                <h3>Bookings</h3>
                <p><?php echo $bookings; ?></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>