<?php
include("includes/admin_auth.php"); 
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

$message = "";

// --- 1. HANDLE GUIDE ASSIGNMENT & STATUS UPDATE ---
if (isset($_POST['assign_guide'])) {
    $booking_id = mysqli_real_escape_string($link, $_POST['booking_id']);
    $guide_id = mysqli_real_escape_string($link, $_POST['guide_id']);
    
    // Update the booking: Link the staff and confirm the trip
    $update_sql = "UPDATE bookings SET guide_id = '$guide_id', status = 'Confirmed' WHERE id = '$booking_id'";
    
    if (mysqli_query($link, $update_sql)) {
        $message = "<div class='alert success'>Staff assigned and booking confirmed!</div>";
    } else {
        $message = "<div class='alert error'>Error assigning staff.</div>";
    }
}

// --- 2. HANDLE CANCELLATION ---
if (isset($_GET['cancel_id'])) {
    $c_id = mysqli_real_escape_string($link, $_GET['cancel_id']);
    mysqli_query($link, "UPDATE bookings SET status = 'Cancelled' WHERE id = '$c_id'");
    header("Location: manage_bookings.php?msg=cancelled");
    exit();
}

// --- 3. FETCH ALL GUIDES (For the dropdown) ---
$guide_res = mysqli_query($link, "SELECT id, name FROM guides WHERE is_available = 1");
$all_guides = mysqli_fetch_all($guide_res, MYSQLI_ASSOC);

// --- 4. FETCH ALL BOOKINGS ---
// We use LEFT JOIN for guides because a new booking won't have a guide yet
$sql = "SELECT b.*, u.username, a.name AS attraction_name, g.name AS guide_name 
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN attractions a ON b.attraction_id = a.id
        LEFT JOIN guides g ON b.guide_id = g.id
        ORDER BY b.created_at DESC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings | Admin Panel</title>
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .main-content { margin-left: 260px; padding: 40px; }
        .booking-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; background: #f8f9fa; color: #7f8c8d; border-bottom: 2px solid #eee; font-size: 0.85rem; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 0.9rem; vertical-align: middle; }

        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
        .Pending { background: #fff3cd; color: #856404; }
        .Confirmed { background: #d4edda; color: #155724; }
        .Cancelled { background: #f8d7da; color: #721c24; }

        .assign-form { display: flex; gap: 5px; align-items: center; }
        select { padding: 8px; border-radius: 5px; border: 1px solid #ddd; font-size: 0.8rem; }
        .btn-assign { background: #27ae60; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        
        .btn-cancel { color: #e74c3c; text-decoration: none; font-size: 0.8rem; margin-left: 10px; }

        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="main-content">
    <div class="booking-card">
        <h1>Travel Assignments</h1>
        <?php echo $message; ?>

        <table>
            <thead>
                <tr>
                    <th>Traveler</th>
                    <th>Destination</th>
                    <th>Date & Guests</th>
                    <th>Status</th>
                    <th>Assigned Staff</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['attraction_name']); ?></td>
                    <td>
                        <?php echo date('M d, Y', strtotime($row['booking_date'])); ?><br>
                        <small style="color: #999;"><?php echo $row['num_people']; ?> People</small>
                    </td>
                    <td><span class="status-badge <?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
                    
                    <td>
                        <?php if($row['guide_id'] == NULL && $row['status'] != 'Cancelled'): ?>
                            <form method="POST" class="assign-form">
                                <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                <select name="guide_id" required>
                                    <option value="">Select Staff...</option>
                                    <?php foreach($all_guides as $guide): ?>
                                        <option value="<?php echo $guide['id']; ?>"><?php echo $guide['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" name="assign_guide" class="btn-assign">Assign</button>
                            </form>
                        <?php elseif($row['status'] == 'Cancelled'): ?>
                            <span style="color: #ccc;">N/A</span>
                        <?php else: ?>
                            <span style="color: #27ae60; font-weight: bold;"><i class="fas fa-user-check"></i> <?php echo htmlspecialchars($row['guide_name']); ?></span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if($row['status'] == 'Pending'): ?>
                            <a href="manage_bookings.php?cancel_id=<?php echo $row['id']; ?>" class="btn-cancel" onclick="return confirm('Cancel this booking?')">Cancel</a>
                        <?php else: ?>
                            <small style="color: #999;">Processed</small>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>