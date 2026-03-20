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

// 2. Fetch counts (Updated to include your new features)
$guides = mysqli_num_rows(mysqli_query($link, "SELECT * FROM guides"));
$users = mysqli_num_rows(mysqli_query($link, "SELECT * FROM users"));
$attractions = mysqli_num_rows(mysqli_query($link, "SELECT * FROM attractions"));
$bookings = mysqli_num_rows(mysqli_query($link, "SELECT * FROM bookings"));
$messages = mysqli_num_rows(mysqli_query($link, "SELECT * FROM contact_messages WHERE status='unread'"));
$reviews = mysqli_num_rows(mysqli_query($link, "SELECT * FROM reviews"));

// 3. Fetch Recent Messages for the table
$recent_msgs = mysqli_query($link, "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
       
        /* Ensure this matches your sidebar width */
        .main-content {
            margin-left: 250px; /* This creates the space for the sidebar */
            padding: 40px;
            background: #f4f7f6;
            min-height: 100vh;
            box-sizing: border-box; /* Ensures padding doesn't add to the width */
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        /* Optional: Add a subtle transition if you ever want to hide the sidebar */
        .main-content {
            transition: margin-left 0.3s ease;
        }

        .dashboard-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-header h1 { color: #2c3e50; font-size: 1.8rem; margin: 0; }

        /* Stats Grid */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-bottom: 4px solid transparent;
            transition: 0.3s;
        }

        .stat-card:hover { transform: translateY(-5px); }

        /* Icon styling */
        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            margin-right: 15px;
        }

        .card-guides { border-color: #3498db; }
        .card-attractions { border-color: #27ae60; }
        .card-users { border-color: #f1c40f; }
        .card-bookings { border-color: #e74c3c; }
        .card-messages { border-color: #9b59b6; }

        .bg-blue { background: rgba(52, 152, 219, 0.1); color: #3498db; }
        .bg-green { background: rgba(39, 174, 96, 0.1); color: #27ae60; }
        .bg-yellow { background: rgba(241, 196, 15, 0.1); color: #f39c12; }
        .bg-red { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
        .bg-purple { background: rgba(155, 89, 182, 0.1); color: #9b59b6; }

        .stat-info h3 { margin: 0; font-size: 0.8rem; color: #7f8c8d; text-transform: uppercase; }
        .stat-info p { margin: 5px 0 0; font-size: 1.5rem; font-weight: bold; color: #2c3e50; }

        /* Dashboard Sections */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .section-box {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .section-box h2 { font-size: 1.2rem; margin-top: 0; color: #2c3e50; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }

        /* Recent Table */
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; color: #7f8c8d; font-size: 0.85rem; padding: 10px; border-bottom: 2px solid #f4f7f6; }
        td { padding: 12px 10px; font-size: 0.9rem; border-bottom: 1px solid #f4f7f6; }
        .status-unread { color: #e74c3c; font-weight: bold; background: rgba(231,76,60,0.1); padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; }

        /* Quick Actions */
        .btn-action {
            display: flex;
            align-items: center;
            padding: 12px;
            background: #f8f9fa;
            color: #333;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
            border: 1px solid #eee;
        }
        .btn-action:hover { background: #27ae60; color: white; }
        .btn-action i { margin-right: 15px; }

        /* Mobile Fix */
        @media (max-width: 992px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="dashboard-header">
        <div>
            <h1>Admin Dashboard</h1>
            <p style="color: #7f8c8d; margin-top: 5px;">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['admin_email']); ?></strong></p>
        </div>
        <a href="admin_logout.php" style="color: #e74c3c; text-decoration: none; font-weight: bold;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="cards-container">
        <div class="stat-card card-guides">
            <div class="icon-box bg-blue"><i class="fas fa-user-tie"></i></div>
            <div class="stat-info"><h3>Guides</h3><p><?php echo $guides; ?></p></div>
        </div>

        <div class="stat-card card-attractions">
            <div class="icon-box bg-green"><i class="fas fa-map-marked-alt"></i></div>
            <div class="stat-info"><h3>Attractions</h3><p><?php echo $attractions; ?></p></div>
        </div>

        <div class="stat-card card-users">
            <div class="icon-box bg-yellow"><i class="fas fa-users"></i></div>
            <div class="stat-info"><h3>Users</h3><p><?php echo $users; ?></p></div>
        </div>

        <div class="stat-card card-bookings">
            <div class="icon-box bg-red"><i class="fas fa-ticket-alt"></i></div>
            <div class="stat-info"><h3>Bookings</h3><p><?php echo $bookings; ?></p></div>
        </div>

        <div class="stat-card card-messages">
            <div class="icon-box bg-purple"><i class="fas fa-envelope"></i></div>
            <div class="stat-info"><h3>New Messages</h3><p><?php echo $messages; ?></p></div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="section-box">
            <h2>Recent Enquiries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($msg = mysqli_fetch_assoc($recent_msgs)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($msg['name']); ?></td>
                        <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                        <td><span class="status-<?php echo $msg['status']; ?>"><?php echo strtoupper($msg['status']); ?></span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="section-box">
            <h2>Quick Actions</h2>
            <a href="manage_attractions.php" class="btn-action"><i class="fas fa-plus-circle"></i> Add Attraction</a>
            <a href="manage_guides.php" class="btn-action"><i class="fas fa-user-plus"></i> Add New Guide</a>
            <a href="view_messages.php" class="btn-action"><i class="fas fa-comments"></i> View Messages</a>
            <a href="manage_reviews.php" class="btn-action"><i class="fas fa-star"></i> Moderate Reviews</a>
        </div>
    </div>
</div>

<script>
    // Embedded JS for small interactive elements
    console.log("Admin Dashboard Loaded for <?php echo $_SESSION['admin_email']; ?>");
</script>

</body>
</html>