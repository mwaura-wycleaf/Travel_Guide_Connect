<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

// 1. Security Check
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

// 2. Fetch bookings with BOTH Attraction and Guide details
$sql = "SELECT b.*, 
               a.name AS attraction_name, a.location, a.image AS attraction_img,
               g.name AS guide_name 
        FROM bookings b
        JOIN attractions a ON b.attraction_id = a.id
        LEFT JOIN guides g ON b.guide_id = g.id
        WHERE b.user_id = '$user_id'
        ORDER BY b.booking_date DESC";

$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .container { max-width: 900px; margin: 50px auto; padding: 0 20px; }
        h2 { color: #2c3e50; margin-bottom: 30px; border-left: 6px solid #27ae60; padding-left: 15px; }
        
        .booking-card {
            background: white; border-radius: 15px; display: flex;
            overflow: hidden; margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .booking-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        
        .booking-img { width: 220px; height: 160px; object-fit: cover; }
        
        .booking-details { padding: 20px; flex-grow: 1; }
        .booking-details h3 { margin: 0 0 8px 0; color: #2c3e50; font-size: 1.3rem; }
        .booking-details p { margin: 4px 0; color: #7f8c8d; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; }
        .guide-tag { color: #27ae60 !important; font-weight: 600; }

        .status-container { 
            padding: 20px; display: flex; flex-direction: column; 
            align-items: center; justify-content: center; 
            background: #fafafa; border-left: 1px solid #eee; min-width: 160px; 
        }
        
        .status-badge {
            padding: 8px 18px; border-radius: 30px; font-size: 0.75rem;
            font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
        }
        /* Match database cases exactly */
        .Pending { background: #fff3cd; color: #856404; }
        .Confirmed { background: #d4edda; color: #155724; }
        .Cancelled { background: #f8d7da; color: #721c24; }

        .btn-review {
            margin-top: 12px; font-size: 0.85rem; color: #27ae60;
            text-decoration: none; font-weight: bold; border: 1px solid #27ae60;
            padding: 5px 12px; border-radius: 5px; transition: 0.3s;
        }
        .btn-review:hover { background: #27ae60; color: white; }

        .empty-state { text-align: center; padding: 60px; background: white; border-radius: 15px; }
        .btn-explore { 
            background: #27ae60; color: white; padding: 12px 25px; 
            text-decoration: none; border-radius: 30px; display: inline-block; 
            margin-top: 20px; font-weight: bold; 
        }
    </style>
</head>
<body>

<div class="container">
    <h2>My Bookings & Trips</h2>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="booking-card">
                <img src="images/attractions/<?php echo $row['attraction_img']; ?>" class="booking-img">
                
                <div class="booking-details">
                    <h3><?php echo htmlspecialchars($row['attraction_name']); ?></h3>
                    <p><i class="fas fa-map-marker-alt" style="color: #e74c3c;"></i> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p class="guide-tag"><i class="fas fa-user-tie"></i> Guide: <?php echo htmlspecialchars($row['guide_name'] ?? 'Unassigned'); ?></p>
                    <p><i class="far fa-calendar-alt"></i> <?php echo date('D, M d, Y', strtotime($row['booking_date'])); ?></p>
                    <p><i class="fas fa-users"></i> <?php echo $row['num_people']; ?> Guests</p>
                </div>

                <div class="status-container">
                    <span class="status-badge <?php echo ucfirst($row['status']); ?>">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
    
                    <?php if(ucfirst($row['status']) == 'Confirmed'): ?>
                        <a href="post_review.php?attraction_id=<?php echo $row['attraction_id']; ?>&guide_id=<?php echo $row['guide_id']; ?>" class="btn-review">
                            <i class="fas fa-star"></i> Review
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-map-signs fa-4x" style="color: #dfe6e9; margin-bottom: 20px;"></i>
            <h3>No trips planned yet</h3>
            <p>Ready to see the beauty of Kenya? Start by picking a destination!</p>
            <a href="attractions.php" class="btn-explore">Find a Destination</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>