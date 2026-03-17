<?php
include("includes/guide_auth.php"); 
include("../includes/db.php"); 

$guide_id = $_SESSION['guide_id'];

// 1. Get Count of Pending Assignments
$pending_res = mysqli_query($link, "SELECT COUNT(*) as total FROM bookings WHERE guide_id = '$guide_id' AND status = 'Confirmed'");
$pending_count = mysqli_fetch_assoc($pending_res)['total'];

// 2. Fetch the 5 most recent trips assigned to this guide
$sql = "SELECT b.*, u.username, a.name AS attraction_name 
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN attractions a ON b.attraction_id = a.id
        WHERE b.guide_id = '$guide_id'
        ORDER BY b.booking_date ASC LIMIT 5";
$recent_trips = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guide Dashboard | T-Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; margin: 0; display: flex; }
        
        /* Side Navigation */
        .sidebar { width: 250px; height: 100vh; background: #2c3e50; color: white; padding: 20px; position: fixed; }
        .sidebar h2 { color: #27ae60; font-size: 1.5rem; margin-bottom: 30px; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; transition: 0.3s; }
        .sidebar a:hover { background: #34495e; color: #27ae60; }
        
        .main-content { margin-left: 250px; padding: 40px; width: 100%; }
        
        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #27ae60; }
        .stat-card h3 { margin: 0; color: #7f8c8d; font-size: 0.9rem; text-transform: uppercase; }
        .stat-card p { margin: 10px 0 0 0; font-size: 2rem; font-weight: bold; color: #2c3e50; }

        /* Table */
        .trip-table { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #7f8c8d; border-bottom: 2px solid #eee; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        .status-pill { background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Guide Panel</h2>
    <p>Welcome, <?php echo $_SESSION['guide_name']; ?></p>
    <hr style="opacity: 0.2; margin: 20px 0;">
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="manage_bookings.php"><i class="fas fa-calendar-check"></i> My Trips</a>
    <a href="availability.php"><i class="fas fa-clock"></i> Availability</a>
    <a href="reviews.php"><i class="fas fa-star"></i> My Reviews</a>
    <a href="edit_profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a>
    <a href="logout.php" style="margin-top: 50px; color: #e74c3c;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <h1>Welcome back, Guide!</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Upcoming Trips</h3>
            <p><?php echo $pending_count; ?></p>
        </div>
        <div class="stat-card" style="border-left-color: #3498db;">
            <h3>Total Earnings</h3>
            <p><small>KES</small> 0</p>
        </div>
    </div>

    <div class="trip-table">
        <h3>Upcoming Schedule</h3>
        <table>
            <thead>
                <tr>
                    <th>Traveler</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($recent_trips)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['attraction_name']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['booking_date'])); ?></td>
                    <td><span class="status-pill"><?php echo $row['status']; ?></span></td>
                </tr>
                <?php endwhile; ?>
                <?php if(mysqli_num_rows($recent_trips) == 0): ?>
                    <tr><td colspan="4" style="text-align: center; color: #999; padding: 20px;">No trips assigned yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>