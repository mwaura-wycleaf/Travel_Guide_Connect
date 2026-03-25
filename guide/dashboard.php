<?php
session_start();

// Protect page
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
    <title>Guide Dashboard | T-Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f4f7f6; /* Matching admin background */
            min-height: 100vh;
        }

        /* Reusing the Main Content layout from Admin */
        .main-content {
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-header h1 { 
            color: #2c3e50; 
            font-size: 1.8rem; 
            margin: 0; 
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
            transition: 0.3s;
        }

        .logout-btn:hover {
            opacity: 0.8;
        }

        /* Stats/Cards Grid */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-bottom: 4px solid transparent;
            transition: 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .stat-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        /* Icon styling to match Admin palette */
        .icon-box {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.4rem;
            margin-right: 15px;
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
            font-size: 0.85rem; 
            color: #7f8c8d; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }

        .stat-info p { 
            margin: 5px 0 0; 
            font-size: 1.1rem; 
            font-weight: 600; 
            color: #2c3e50; 
        }

        /* Section Styling */
        .info-section {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }

        .info-section h2 {
            font-size: 1.2rem;
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Mobile Fix */
        @media (max-width: 768px) {
            .main-content { padding: 20px; }
            .dashboard-header { flex-direction: column; align-items: flex-start; gap: 15px; }
        }
    </style>
</head>

<body>

<div class="main-content">
    <div class="dashboard-header">
        <div>
            <h1>Guide Dashboard</h1>
            <p class="welcome-text">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['guide_name']); ?> 👋</strong></p>
        </div>
        <a href="../includes/guide_logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <div class="cards-container">
        
        <a href="availability.php" class="stat-card card-availability">
            <div class="icon-box bg-blue"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info">
                <h3>Schedules</h3>
                <p>Manage Availability</p>
            </div>
        </a>

        <a href="manage_bookings.php" class="stat-card card-bookings">
            <div class="icon-box bg-green"><i class="fas fa-clipboard-list"></i></div>
            <div class="stat-info">
                <h3>Clients</h3>
                <p>View My Bookings</p>
            </div>
        </a>

        <a href="reviews.php" class="stat-card card-reviews">
            <div class="icon-box bg-yellow"><i class="fas fa-star"></i></div>
            <div class="stat-info">
                <h3>Feedback</h3>
                <p>Client Reviews</p>
            </div>
        </a>

        <a href="edit_profile.php" class="stat-card card-profile">
            <div class="icon-box bg-purple"><i class="fas fa-user-edit"></i></div>
            <div class="stat-info">
                <h3>Account</h3>
                <p>Edit My Profile</p>
            </div>
        </a>

    </div>

    <div class="info-section">
        <h2><i class="fas fa-lightbulb" style="color: #f1c40f;"></i> Guide Tip</h2>
        <p style="color: #7f8c8d; line-height: 1.6;">
            Keep your availability updated to stay visible to tourists in your region. 
            Currently viewing your dashboard for the <strong>2026 Tourism Season</strong>.
        </p>
    </div>

</div>

</body>
</html>
