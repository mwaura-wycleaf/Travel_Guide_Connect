<?php
session_start();

// 1. Security Check
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// 2. Database and Header includes
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

// 3. Fetch counts
$guides = mysqli_num_rows(mysqli_query($link, "SELECT * FROM guides"));
$users = mysqli_num_rows(mysqli_query($link, "SELECT * FROM users"));
$attractions = mysqli_num_rows(mysqli_query($link, "SELECT * FROM attractions"));
$bookings = mysqli_num_rows(mysqli_query($link, "SELECT * FROM bookings"));
$messages = mysqli_num_rows(mysqli_query($link, "SELECT * FROM contact_messages WHERE status='unread'"));

// 4. Fetch Recent Messages
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
        body, html { margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }

        /* --- FIX: Adjusting the Header to respect the Sidebar --- */
        header {
            left: 250px !important; 
            width: calc(100% - 250px) !important; 
            box-sizing: border-box;
        }

        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            padding-top: 120px; 
            background: #f4f7f6; 
            min-height: 100vh; 
            box-sizing: border-box; 
            transition: margin-left 0.3s ease; 
        }

        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .dashboard-header h1 { color: #2c3e50; font-size: 1.8rem; margin: 0; }
        
        .cards-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        
        /* Added anchor styling for cards to make them clickable */
        .stat-card-link { text-decoration: none; color: inherit; display: block; }
        .stat-card { background: #fff; padding: 20px; border-radius: 15px; display: flex; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-bottom: 4px solid transparent; transition: 0.3s; height: 100%; box-sizing: border-box; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 6px 12px rgba(0,0,0,0.1); }
        
        .icon-box { width: 50px; height: 50px; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 1.2rem; margin-right: 15px; }
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
        
        .dashboard-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
        .section-box { background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .section-box h2 { font-size: 1.2rem; margin-top: 0; color: #2c3e50; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; color: #7f8c8d; font-size: 0.85rem; padding: 10px; border-bottom: 2px solid #f4f7f6; }
        td { padding: 12px 10px; font-size: 0.9rem; border-bottom: 1px solid #f4f7f6; }
        
        .btn-action { display: flex; align-items: center; padding: 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 10px; margin-bottom: 10px; transition: 0.3s; border: 1px solid #eee; }
        .btn-action:hover { background: #27ae60; color: white; }
        .btn-action i { margin-right: 15px; width: 20px; text-align: center; }

        .status-READ { color: #27ae60; font-weight: bold; }
        .status-UNREAD { color: #e74c3c; font-weight: bold; }
    </style>
</head>
<body>

<div class="main-content">
    <div class="dashboard-header">
        <div>
            <h1>Admin Dashboard</h1>
            <p style="color: #7f8c8d; margin-top: 5px;">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></p>
        </div>
        <a href="../auth/logout.php" style="color: #e74c3c; text-decoration: none; font-weight: bold;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="cards-container">
        <a href="manage_guides.php" class="stat-card-link">
            <div class="stat-card card-guides">
                <div class="icon-box bg-blue"><i class="fas fa-user-tie"></i></div>
                <div class="stat-info"><h3>Guides</h3><p><?php echo $guides; ?></p></div>
            </div>
        </a>
        <a href="manage_attractions.php" class="stat-card-link">
            <div class="stat-card card-attractions">
                <div class="icon-box bg-green"><i class="fas fa-map-marked-alt"></i></div>
                <div class="stat-info"><h3>Attractions</h3><p><?php echo $attractions; ?></p></div>
            </div>
        </a>
        <a href="manage_users.php" class="stat-card-link">
            <div class="stat-card card-users">
                <div class="icon-box bg-yellow"><i class="fas fa-users"></i></div>
                <div class="stat-info"><h3>Users</h3><p><?php echo $users; ?></p></div>
            </div>
        </a>
        <div class="stat-card card-bookings">
            <div class="icon-box bg-red"><i class="fas fa-ticket-alt"></i></div>
            <div class="stat-info"><h3>Bookings</h3><p><?php echo $bookings; ?></p></div>
        </div>
        <a href="view_messages.php" class="stat-card-link">
            <div class="stat-card card-messages">
                <div class="icon-box bg-purple"><i class="fas fa-envelope"></i></div>
                <div class="stat-info"><h3>New Messages</h3><p><?php echo $messages; ?></p></div>
            </div>
        </a>
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
                        <td><span class="status-<?php echo strtoupper($msg['status']); ?>"><?php echo strtoupper($msg['status']); ?></span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="section-box">
            <h2>Quick Actions</h2>
            <a href="manage_users.php" class="btn-action"><i class="fas fa-users-cog"></i> Manage Users</a>
            <a href="manage_attractions.php" class="btn-action"><i class="fas fa-plus-circle"></i> Add Attraction</a>
            <a href="manage_guides.php" class="btn-action"><i class="fas fa-user-plus"></i> Add New Guide</a>
            <a href="view_messages.php" class="btn-action"><i class="fas fa-comments"></i> View Messages</a>
            <a href="manage_reviews.php" class="btn-action"><i class="fas fa-star"></i> Moderate Reviews</a>
        </div>
    </div>
</div>

</body>
</html>