<?php
session_start();
require_once "../includes/db.php"; 

// 1. SECURITY: Check if guide is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "guide"){
    header("Location: guide_login.php");
    exit;
}

$guide_id = $_SESSION['guide_id']; 

// 2. FILTER LOGIC: Handle "All", "Pending", or "Confirmed" status
$filter = isset($_GET['status']) ? $_GET['status'] : 'all';

if ($filter === 'all') {
    $sql = "SELECT * FROM bookings WHERE guide_id = ? ORDER BY booking_date DESC";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $guide_id);
} else {
    $sql = "SELECT * FROM bookings WHERE guide_id = ? AND status = ? ORDER BY booking_date DESC";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("is", $guide_id, $filter);
}

$stmt->execute();
$result = $stmt->get_result();
$total_bookings = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings | Guide Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #22303e; /* Dark blue from your image */
            --main-bg: #f0f2f5;    /* Light grey background */
            --accent-green: #2ecc71;
            --text-muted: #888da8;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--main-bg);
            display: flex;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            color: white;
            position: fixed;
        }

        .sidebar-header {
            padding: 30px 20px;
            font-size: 22px;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-links {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .nav-links li a {
            display: block;
            padding: 15px 25px;
            color: #bdc3c7;
            text-decoration: none;
            transition: 0.3s;
        }

        .nav-links li.active a {
            background-color: #2c3e50;
            color: var(--accent-green);
            border-left: 4px solid var(--accent-green);
        }

        .nav-links li a:hover {
            background: #2c3e50;
            color: white;
        }

        /* Main Content Layout */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 40px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #1a202c;
        }

        /* Filter Buttons */
        .filter-container {
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            text-decoration: none;
            padding: 8px 20px;
            background: #fff;
            border-radius: 25px;
            color: #4a5568;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            transition: 0.2s;
        }

        .filter-btn.active-filter {
            background: var(--accent-green);
            color: white;
            border-color: var(--accent-green);
        }

        /* Card Elements */
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            padding: 30px;
            margin-bottom: 25px;
        }

        .stat-number {
            font-size: 48px;
            font-weight: bold;
            color: var(--accent-green);
            margin-right: 15px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Table Design */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            text-align: left;
            color: var(--text-muted);
            padding: 15px;
            border-bottom: 2px solid #edf2f7;
            font-weight: 600;
        }

        td {
            padding: 20px 15px;
            border-bottom: 1px solid #edf2f7;
            color: #2d3748;
        }

        .status-pill {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .pending { background: #fff3cd; color: #856404; }
        .confirmed { background: #d4edda; color: #155724; }
        .cancelled { background: #f8d7da; color: #721c24; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 100px 0;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 60px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .action-icon {
            text-decoration: none;
            font-size: 18px;
            margin-right: 10px;
            transition: transform 0.2s;
            display: inline-block;
        }

        .action-icon:hover { transform: scale(1.2); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">Guide Panel</div>
    <ul class="nav-links">
        <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i> &nbsp; Dashboard</a></li>
        <li><a href="availability.php"><i class="fa-solid fa-calendar-days"></i> &nbsp; Availability</a></li>
        <li class="active"><a href="manage_bookings.php"><i class="fa-solid fa-book-bookmark"></i> &nbsp; Manage Bookings</a></li>
        <li><a href="reviews.php"><i class="fa-solid fa-star"></i> &nbsp; Reviews</a></li>
        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> &nbsp; Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Manage Bookings</h1>
    
    <div class="filter-container">
        <a href="manage_bookings.php?status=all" class="filter-btn <?php echo $filter == 'all' ? 'active-filter' : ''; ?>">All Bookings</a>
        <a href="manage_bookings.php?status=pending" class="filter-btn <?php echo $filter == 'pending' ? 'active-filter' : ''; ?>">Pending</a>
        <a href="manage_bookings.php?status=confirmed" class="filter-btn <?php echo $filter == 'confirmed' ? 'active-filter' : ''; ?>">Confirmed</a>
    </div>

    <div class="card" style="display: flex; align-items: center;">
        <span class="stat-number"><?php echo (int)$total_bookings; ?></span>
        <span class="stat-label">Total <?php echo ucfirst($filter); ?> Bookings</span>
    </div>

    <div class="card">
        <?php if($total_bookings > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>BOOKING ID</th>
                        <th>CLIENT NAME</th>
                        <th>CLIENT EMAIL</th>
                        <th>TRIP DATE</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#BK-<?php echo $row['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['booking_date'])); ?></td>
                        <td>
                            <span class="status-pill <?php echo strtolower($row['status']); ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if($row['status'] == 'pending'): ?>
                                <a href="process_booking.php?id=<?php echo $row['id']; ?>&action=confirm" class="action-icon" style="color: #2ecc71;" title="Confirm Booking"><i class="fa-solid fa-circle-check"></i></a>
                                <a href="process_booking.php?id=<?php echo $row['id']; ?>&action=cancel" class="action-icon" style="color: #e74c3c;" title="Cancel Booking"><i class="fa-solid fa-circle-xmark"></i></a>
                            <?php else: ?>
                                <span style="font-size: 12px; color: #bdc3c7;">Locked</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-regular fa-comment-dots"></i>
                <p>No <?php echo $filter; ?> bookings found. Try changing your filters!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
