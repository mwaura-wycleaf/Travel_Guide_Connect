<?php
include("includes/guide_auth.php"); 
include("../includes/db.php"); 

$guide_id = $_SESSION['guide_id'];
$message = "";

// --- 1. HANDLE COMPLETION ---
if (isset($_GET['complete'])) {
    $booking_id = mysqli_real_escape_string($link, $_GET['complete']);
    // Update status to Confirmed/Completed (depending on your logic)
    $update_sql = "UPDATE bookings SET status='Confirmed' WHERE id='$booking_id' AND guide_id='$guide_id'";
    if (mysqli_query($link, $update_sql)) {
        $message = "<div class='alert success'>Trip marked as completed!</div>";
    }
}

// --- 2. FETCH ASSIGNED BOOKINGS ---
$sql = "SELECT b.*, u.username, u.email as user_email, a.name AS attraction_name, a.location 
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN attractions a ON b.attraction_id = a.id
        WHERE b.guide_id = '$guide_id'
        ORDER BY b.booking_date ASC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage My Trips | Guide Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; margin: 0; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #2c3e50; color: white; padding: 20px; position: fixed; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; }
        
        .main-content { margin-left: 250px; padding: 40px; width: 100%; }
        
        .trip-container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; color: #7f8c8d; border-bottom: 2px solid #eee; }
        td { padding: 15px; border-bottom: 1px solid #eee; }

        .user-info { display: flex; flex-direction: column; }
        .user-info small { color: #27ae60; font-size: 0.8rem; }

        .status-badge {
            padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold;
        }
        .Pending { background: #fff3cd; color: #856404; }
        .Confirmed { background: #d4edda; color: #155724; }

        .btn-complete {
            background: #27ae60; color: white; text-decoration: none; padding: 8px 15px;
            border-radius: 8px; font-size: 0.8rem; font-weight: bold; transition: 0.3s;
        }
        .btn-complete:hover { background: #219150; }

        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Guide Panel</h2>
    <hr style="opacity: 0.2;">
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_bookings.php" style="background: #34495e; color: #27ae60;">My Trips</a>
    <a href="availability.php">Availability</a>
    <a href="edit_profile.php">Edit Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main-content">
    <h1>Your Assigned Trips</h1>
    <?php echo $message; ?>

    <div class="trip-container">
        <table>
            <thead>
                <tr>
                    <th>Traveler Details</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <div class="user-info">
                            <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                            <small><?php echo htmlspecialchars($row['user_email']); ?></small>
                        </div>
                    </td>
                    <td>
                        <strong><?php echo htmlspecialchars($row['attraction_name']); ?></strong><br>
                        <span style="font-size: 0.8rem; color: #999;"><?php echo $row['location']; ?></span>
                    </td>
                    <td><?php echo date('D, M d, Y', strtotime($row['booking_date'])); ?></td>
                    <td>
                        <span class="status-badge <?php echo $row['status']; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if($row['status'] == 'Pending'): ?>
                            <a href="manage_bookings.php?complete=<?php echo $row['id']; ?>" class="btn-complete">
                                <i class="fas fa-check"></i> Mark Complete
                            </a>
                        <?php else: ?>
                            <span style="color: #27ae60;"><i class="fas fa-check-circle"></i> Done</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr><td colspan="5" style="text-align:center; padding: 40px; color:#999;">No assigned trips found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
