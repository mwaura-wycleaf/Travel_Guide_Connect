<?php
include("includes/guide_auth.php"); 
include("../includes/db.php"); 

$guide_id = $_SESSION['guide_id'];

// 1. Calculate Average Rating for this specific guide
$avg_sql = "SELECT AVG(rating) as average FROM reviews WHERE guide_id = '$guide_id'";
$avg_res = mysqli_query($link, $avg_sql);
$avg_data = mysqli_fetch_assoc($avg_res);
$rating_avg = round($avg_data['average'], 1);

// 2. Fetch reviews using your specific columns
// Note: We still join with 'attractions' so the guide knows which trip the review is for
$sql = "SELECT r.user_name, r.rating, r.comment, r.created_at, a.name AS attraction_name 
        FROM reviews r
        JOIN attractions a ON r.attraction_id = a.id
        WHERE r.guide_id = '$guide_id'
        ORDER BY r.created_at DESC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback | Guide Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; margin: 0; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #2c3e50; color: white; padding: 20px; position: fixed; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; }
        
        .main-content { margin-left: 250px; padding: 40px; width: 100%; }
        
        .rating-header { 
            background: white; padding: 30px; border-radius: 15px; margin-bottom: 30px;
            display: flex; align-items: center; gap: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .avg-number { font-size: 3rem; font-weight: bold; color: #27ae60; }
        .star-box { color: #f1c40f; font-size: 1.1rem; }

        .review-card { 
            background: white; padding: 20px; border-radius: 12px; 
            margin-bottom: 15px; box-shadow: 0 3px 10px rgba(0,0,0,0.03); 
        }
        .review-meta { font-size: 0.85rem; color: #7f8c8d; margin-bottom: 10px; }
        .reviewer { font-weight: bold; color: #2c3e50; font-size: 1rem; }
        .comment-text { color: #555; line-height: 1.5; font-style: italic; border-left: 3px solid #eee; padding-left: 15px; }
        .dest-tag { background: #e3f2fd; color: #1976d2; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Guide Panel</h2>
    <hr style="opacity: 0.1;">
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_bookings.php">My Trips</a>
    <a href="availability.php">Availability</a>
    <a href="reviews.php" style="background: #34495e; color: #27ae60;">Reviews</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main-content">
    <h1>Your Reviews</h1>

    <div class="rating-header">
        <div class="avg-number"><?php echo $rating_avg ?: '0.0'; ?></div>
        <div>
            <div class="star-box">
                <?php 
                for($i=1; $i<=5; $i++){
                    echo ($i <= round($rating_avg)) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                }
                ?>
            </div>
            <p style="margin: 0; color: #7f8c8d;">Lifetime Performance Rating</p>
        </div>
    </div>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="review-card">
                <div class="review-meta">
                    <span class="reviewer"><?php echo htmlspecialchars($row['user_name']); ?></span> 
                    visited <span class="dest-tag"><?php echo htmlspecialchars($row['attraction_name']); ?></span>
                    on <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                </div>
                
                <div class="star-box" style="margin-bottom: 10px;">
                    <?php 
                    for($i=1; $i<=5; $i++){
                        echo ($i <= $row['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    }
                    ?>
                </div>

                <div class="comment-text">
                    "<?php echo htmlspecialchars($row['comment']); ?>"
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div style="background: white; padding: 40px; border-radius: 15px; text-align: center; color: #999;">
            <i class="far fa-comment-dots fa-3x" style="margin-bottom: 10px;"></i>
            <p>You don't have any reviews yet. Complete more trips to get feedback!</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>