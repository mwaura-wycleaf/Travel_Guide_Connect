<?php
// 1. Always start the session first
session_start();

// 2. Protect page - Redirect to login if session is not set
if(!isset($_SESSION['guide_id'])){
    header("Location: guide_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Dashboard | Travel Guide Connect</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f4f7f6;
            display: flex;
            min-height: 100vh;
        }

        /* Main Content Layout - Pushed 250px to the right to make room for sidebar */
        .main-content {
            flex: 1;
            margin-left: 250px; 
            padding: 40px;
            max-width: 1400px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        .dashboard-header h1 { 
            color: #2c3e50; 
            font-size: 1.8rem; 
        }

        .welcome-text {
            color: #7f8c8d;
            margin-top: 5px;
        }

        .logout-btn {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
            border: 1px solid #f5c6cb;
        }

        .logout-btn:hover {
            background: #f8d7da;
            transform: scale(1.05);
        }

        /* Stats/Cards Grid */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-bottom: 4px solid transparent;
            transition: 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .stat-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 12px 20px rgba(0,0,0,0.1);
        }

        /* Icon styling */
        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.6rem;
            margin-right: 20px;
        }

        /* Theme Colors */
        .card-availability { border-color: #3498db; }
        .card-bookings { border-color: #27ae60; }
        .card-reviews { border-color: #f1c40f; }
        .card-profile { border-color: #9b59b6; }

        .bg-blue { background: rgba(52, 152, 219, 0.1); color: #3498db; }
        .bg-green { background: rgba(39, 174, 96, 0.1); color: #27ae60; }
        .bg-yellow { background: rgba(241, 196, 15, 0.1); color: #f39c12; }
        .bg-purple { background: rgba(155, 89, 182, 0.1); color: #9b59b6; }

        .stat-info h3 { 
            margin: 0; 
            font-size: 0.9rem; 
            color: #7f8c8d; 
            text-transform: uppercase; 
            letter-spacing: 1px;
        }

        .stat-info p { 
            margin: 5px 0 0; 
            font-size: 1.2rem; 
            font-weight: 700; 
            color: #2c3e50; 
        }

        /* Section Styling */
        .info-section {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 5px solid #27ae60;
        }

        .info-section h2 {
            font-size: 1.3rem;
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .main-content { margin-left: 0; padding: 20px; }
            .sidebar { display: none; } /* You'd typically add a toggle here */
        }
    </style>
</head>

<body>

    <?php include("../includes/sidebar.php"); ?>

    <div class="main-content">
        
        <div class="dashboard-header">
            <div>
                <h1>Guide Dashboard</h1>
                <p class="welcome-text">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['guide_name']); ?> 👋</strong></p>
            </div>
            <a href="includes/guide_logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <div class="cards-container">
            
            <a href="availability.php" class="stat-card card-availability">
                <div class="icon-box bg-blue"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info">
                    <h3>Schedules</h3>
                    <p>My Availability</p>
                </div>
            </a>

            <a href="manage_bookings.php" class="stat-card card-bookings">
                <div class="icon-box bg-green"><i class="fas fa-clipboard-list"></i></div>
                <div class="stat-info">
                    <h3>Clients</h3>
                    <p>Manage Trips</p>
                </div>
            </a>

            <a href="reviews.php" class="stat-card card-reviews">
                <div class="icon-box bg-yellow"><i class="fas fa-star"></i></div>
                <div class="stat-info">
                    <h3>Feedback</h3>
                    <p>User Reviews</p>
                </div>
            </a>

            <a href="edit_profile.php" class="stat-card card-profile">
                <div class="icon-box bg-purple"><i class="fas fa-user-edit"></i></div>
                <div class="stat-info">
                    <h3>Account</h3>
                    <p>Profile Settings</p>
                </div>
            </a>

        </div>

        <div class="info-section">
            <h2><i class="fas fa-lightbulb" style="color: #f1c40f;"></i> Quick Tip</h2>
            <p style="color: #7f8c8d; line-height: 1.8; font-size: 1.05rem;">
                Keep your status set to <strong>"Available"</strong> in the Availability section to appear in the search results for tourists. 
                Providing excellent service leads to higher ratings and more bookings!
                <br><br>
                <small>System status: Active | Region: Kenya | Season: 2026</small>
            </p>
        </div>

    </div>

</body>
</html>
