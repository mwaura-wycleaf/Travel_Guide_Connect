<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

// 1. Security Check: Only logged-in users
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

// 2. Fetch bookings for THIS specific user
// We JOIN with attractions to show the name and location of the place
$sql = "SELECT b.*, a.name AS attraction_name, a.location, a.img_url 
        FROM bookings b
        JOIN attractions a ON b.attraction_id = a.id
        WHERE b.user_id = '$user_id'
        ORDER BY b.created_at DESC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings | Travel Guide Connect</title>
    <style>
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .container { max-width: 900px; margin: 50px auto; padding: 20px; }
        h2 { color: #2c3e50; margin-bottom: 30px; border-left: 5px solid #27ae60; padding-left: 15px; }
        
        .booking-card {
            background: white;
            border-radius: 15px;
            display: flex;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .booking-card:hover { transform: translateY(-5px); }
        
        .booking-img { width: 200px; height: 150px; object-fit: cover; }
        
        .booking-details { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: center; }
        .booking-details h3 { margin: 0 0 5px 0; color: #27ae60; }
        .booking-details p { margin: 2px 0; color: #7f8c8d; font-size: 0.9rem; }
        
        .status-container { padding: 20px; display: flex; align-items: center; justify-content: center; min-width: 150px; }
        
        /* Status Badges */
        .status-badge {
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .Pending { background: #fff3cd; color: #856404; }
        .Confirmed { background: #d4edda; color: #155724; }
        .Cancelled { background: #f8d7da; color: #721c24; }

        .empty-state { text-align: center; padding: 50px; background: white; border-radius: 15px; }
        .btn-explore { background: #27ae60; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 15px; }

        @media (max-width: 600px) {
            .booking-card { flex-direction: column; }
            .booking-img { width: 100%; height: 200px; }
            .status-container { border-top: 1px solid #eee; padding: 15px; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>My Travel History</h2>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="booking-card">
                <img src="images/<?php echo $row['img_url']; ?>" class="booking-img" alt="Destination">
                
                <div class="booking-details">
                    <h3><?php echo htmlspecialchars($row['attraction_name']); ?></h3>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><i class="far fa-calendar-alt"></i> Date: <strong><?php echo date('D, M d, Y', strtotime($row['booking_date'])); ?></strong></p>
                    <p><i class="fas fa-users"></i> Guests: <?php echo $row['num_people']; ?></p>
                </div>

                <div class="status-container">
                  <span class="status-badge <?php echo $row['status']; ?>">
                   <?php echo $row['status']; ?>
                 </span>
    
                    <?php if($row['status'] == 'Confirmed'): ?>
                        <a href="post_review.php?attraction_id=<?php echo $row['attraction_id']; ?>&guide_id=<?php echo $row['guide_id']; ?>" 
                        style="display: block; margin-top: 10px; font-size: 0.8rem; color: #27ae60; text-decoration: none; font-weight: bold;">
                        <i class="fas fa-pen"></i> Leave a Review
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-suitcase-rolling fa-3x" style="color: #ccc; margin-bottom: 15px;"></i>
            <h3>No bookings yet!</h3>
            <p>Your adventures are waiting for you.</p>
            <a href="attractions.php" class="btn-explore">Explore Destinations</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>