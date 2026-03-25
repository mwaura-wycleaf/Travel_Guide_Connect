<?php
session_start();
require_once "../includes/db.php"; 

// 1. SECURITY: Check if guide is logged in
if(!isset($_SESSION['guide_id'])){
    header("Location: guide_login.php");
    exit();
}

$guide_id = $_SESSION['guide_id']; 

// 2. FILTER LOGIC
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
    <title>Manage Bookings | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --accent-green: #27ae60;
            --bg-color: #f4f7f6;
            --text-dark: #2c3e50;
            --text-muted: #7f8c8d;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            display: flex;
        }

        /* Container that handles the sidebar offset */
        .page-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            justify-content: center; /* Centers the content horizontally */
            padding: 40px 20px;
        }

        /* The actual centered content box */
        .main-content {
            width: 100%;
            max-width: 1100px; /* Prevents the table from becoming awkwardly wide */
        }

        h1 { 
            font-size: 2.2rem; 
            color: var(--text-dark); 
            margin-bottom: 5px;
        }

        .subtitle {
            color: var(--text-muted);
            margin-bottom: 30px;
        }

        /* Filter Tabs */
        .filter-container {
            margin-bottom: 25px;
            display: flex;
            gap: 12px;
        }

        .filter-btn {
            text-decoration: none;
            padding: 10px 24px;
            background: white;
            border-radius: 30px;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #e0e0e0;
            transition: 0.3s;
        }

        .filter-btn:hover {
            border-color: var(--accent-green);
            color: var(--accent-green);
        }

        .filter-btn.active-filter {
            background: var(--accent-green);
            color: white;
            border-color: var(--accent-green);
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.3);
        }

        /* Summary Card */
        .stats-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .stat-count {
            font-size: 3rem;
            font-weight: 800;
            color: var(--accent-green);
            margin-right: 20px;
            line-height: 1;
        }

        .stat-text {
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.9rem;
            font-weight: 700;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            overflow: hidden; /* Keeps corners rounded */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fcfcfc;
            text-align: left;
            color: var(--text-muted);
            padding: 18px 25px;
            border-bottom: 2px solid #f0f0f0;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        td {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            color: var(--text-dark);
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }

        /* Status Badges */
        .status-pill {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
        }

        .pending { background: #fff9db; color: #f08c00; }
        .confirmed { background: #ebfbee; color: #2b8a3e; }
        .cancelled { background: #fff5f5; color: #c92a2a; }

        /* Action Buttons */
        .action-link {
            text-decoration: none;
            font-size: 1.3rem;
            margin-right: 15px;
            transition: 0.2s;
        }

        .action-link:hover { transform: scale(1.2); }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.2;
        }
    </style>
</head>
<body>

<?php include("../includes/sidebar.php"); ?>

<div class="page-wrapper">
    <div class="main-content">
        
        <header>
            <h1>Trip Bookings</h1>
            <p class="subtitle">Review and manage your incoming tour requests.</p>
        </header>
        
        <div class="filter-container">
            <a href="manage_bookings.php?status=all" class="filter-btn <?php echo $filter == 'all' ? 'active-filter' : ''; ?>">All Requests</a>
            <a href="manage_bookings.php?status=pending" class="filter-btn <?php echo $filter == 'pending' ? 'active-filter' : ''; ?>">Pending</a>
            <a href="manage_bookings.php?status=confirmed" class="filter-btn <?php echo $filter == 'confirmed' ? 'active-filter' : ''; ?>">Confirmed</a>
        </div>

        <div class="stats-card">
            <span class="stat-count"><?php echo (int)$total_bookings; ?></span>
            <span class="stat-text"><?php echo ucfirst($filter); ?> Bookings Found</span>
        </div>

        <div class="table-card">
            <?php if($total_bookings > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tourist Details</th>
                            <th>Trip Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><small>#BK-<?php echo $row['id']; ?></small></td>
                            <td>
                                <div style="font-weight: 700;"><?php echo htmlspecialchars($row['user_name']); ?></div>
                                <div style="font-size: 13px; color: var(--text-muted);"><?php echo htmlspecialchars($row['user_email']); ?></div>
                            </td>
                            <td>
                                <i class="fa-regular fa-calendar" style="margin-right: 5px; color: var(--accent-green);"></i>
                                <?php echo date('M d, Y', strtotime($row['booking_date'])); ?>
                            </td>
                            <td>
                                <span class="status-pill <?php echo strtolower($row['status']); ?>">
                                    <?php echo ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if($row['status'] == 'pending'): ?>
                                    <a href="process_booking.php?id=<?php echo $row['id']; ?>&action=confirm" class="action-link" style="color: #27ae60;" title="Confirm Trip">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </a>
                                    <a href="process_booking.php?id=<?php echo $row['id']; ?>&action=cancel" class="action-link" style="color: #e74c3c;" title="Decline Request">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </a>
                                <?php else: ?>
                                    <span style="font-size: 12px; color: var(--text-muted); font-style: italic;">Processed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fa-solid fa-wind"></i>
                    <p>It looks a bit quiet here. No <?php echo $filter; ?> bookings found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>