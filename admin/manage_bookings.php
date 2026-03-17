<?php
include("includes/admin_auth.php"); 
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

// Handle Status Change
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = ($_GET['action'] == 'confirm') ? 'Confirmed' : 'Cancelled';
    mysqli_query($link, "UPDATE bookings SET status='$status' WHERE id='$id'");
    header("Location: manage_bookings.php");
}

// Fetch Bookings with User and Attraction details
$sql = "SELECT b.id, b.booking_date, b.num_people, b.status, u.username, a.name as place_name 
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN attractions a ON b.attraction_id = a.id
        ORDER BY b.created_at DESC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin | Manage Bookings</title>
    <style>
        .main-content { margin-left: 260px; padding: 30px; }
        .table-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #eee; color: #666; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; }
        .Pending { background: #fff3cd; color: #856404; }
        .Confirmed { background: #d4edda; color: #155724; }
        .Cancelled { background: #f8d7da; color: #721c24; }
        .btn-action { text-decoration: none; padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; margin-right: 5px; }
        .btn-approve { background: #27ae60; color: white; }
        .btn-reject { background: #e74c3c; color: white; }
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
<div class="main-content">
    <h1>Manage Bookings</h1>
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><strong><?php echo $row['username']; ?></strong></td>
                    <td><?php echo $row['place_name']; ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['booking_date'])); ?></td>
                    <td><?php echo $row['num_people']; ?></td>
                    <td><span class="badge <?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
                    <td>
                        <?php if($row['status'] == 'Pending'): ?>
                            <a href="manage_bookings.php?action=confirm&id=<?php echo $row['id']; ?>" class="btn-action btn-approve">Approve</a>
                            <a href="manage_bookings.php?action=cancel&id=<?php echo $row['id']; ?>" class="btn-action btn-reject" onclick="return confirm('Cancel this booking?')">Cancel</a>
                        <?php else: ?>
                            <small style="color:#999">No actions</small>
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