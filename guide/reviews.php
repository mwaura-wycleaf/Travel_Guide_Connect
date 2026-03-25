<?php
// 1. Always start the session first
session_start();

// 2. Correct the paths to your includes (Go up one level with ../)
include("../includes/db.php"); 

// 3. Protection logic
if(!isset($_SESSION['guide_id'])){
    header("Location: login_guide.php");
    exit();
}

$guide_id = $_SESSION['guide_id'];

// 4. Fetch Reviews for this specific guide
// Note: This assumes you have a 'reviews' table with 'guide_id' and 'rating' columns
$review_query = "SELECT * FROM reviews WHERE guide_id = '$guide_id' ORDER BY created_at DESC";
$reviews_result = mysqli_query($link, $review_query);

// 5. Calculate Average Rating
$avg_query = mysqli_query($link, "SELECT AVG(rating) as avg_rating FROM reviews WHERE guide_id = '$guide_id'");
$avg_data = mysqli_fetch_assoc($avg_query);
$rating = ($avg_data['avg_rating']) ? number_format($avg_data['avg_rating'], 1) : "0.0";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Reviews | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; display: flex; }
        
        /* Sidebar Styles */
        .sidebar { 
            width: 250px; 
            height: 100vh; 
            background: #2c3e50; 
            color: white; 
            padding: 25px; 
            position: fixed; 
            left: 0;
            top: 0;
        }
        .sidebar h2 { font-size: 1.4rem; margin-bottom: 20px; color: #27ae60; text-align: center; }
        .sidebar a { display: block; color: #bdc3c7; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; transition: 0.3s; }
        .sidebar a:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar a.active { background: #34495e; color: #27ae60; font-weight: bold; }
        
        /* Main Content Centering */
        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            width: calc(100% - 250px); 
            display: flex;
            flex-direction: column;
            align-items: center; /* Horizontal centering */
            min-height: 100vh;
        }

        .content-container {
            width: 100%;
            max-width: 800px; /* Limits width for better readability */
        }
        
        h1 { color: #2c3e50; text-align: center; margin-bottom: 30px; font-size: 2rem; }

        /* Rating Header Card */
        .rating-header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center; /* Center items inside the card */
            gap: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .rating-number {
            font-size: 4rem;
            font-weight: bold;
            color: #2c3e50;
            line-height: 1;
        }

        .stars { color: #f1c40f; font-size: 1.3rem; }

        /* Review List Items */
        .review-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            border-left: 6px solid #27ae60;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            transition: 0.3s;
        }
        .review-card:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.08); }

        .review-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .review-text { 
            color: #34495e; 
            line-height: 1.6; 
            font-style: italic;
            font-size: 1.05rem;
        }

        .no-reviews {
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: 20px;
            color: #95a5a6;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            .rating-header { flex-direction: column; gap: 15px; text-align: center; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Guide Panel</h2>
    <hr style="opacity: 0.1; margin-bottom: 20px;">
    <a href="dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
    <a href="manage_bookings.php"><i class="fas fa-suitcase"></i> My Trips</a>
    <a href="availability.php"><i class="fas fa-calendar-check"></i> Availability</a>
    <a href="reviews.php" class="active"><i class="fas fa-star"></i> Reviews</a>
    <a href="edit_profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a>
    <a href="includes/guide_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="content-container">
        <h1>Guide Performance & Reviews</h1>

        <div class="rating-header">
            <div class="rating-number"><?php echo $rating; ?></div>
            <div>
                <div class="stars">
                    <?php 
                    $rounded_rating = round((float)$rating);
                    for($i=1; $i<=5; $i++) {
                        echo ($i <= $rounded_rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    }
                    ?>
                </div>
                <p style="color: #7f8c8d; margin: 8px 0 0 0; font-weight: 500;">Overall Traveler Satisfaction</p>
            </div>
        </div>

        <div class="reviews-list">
            <?php if(mysqli_num_rows($reviews_result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($reviews_result)): ?>
                    <div class="review-card">
                        <div class="review-meta">
                            <span><i class="fas fa-user-circle"></i> Traveler #<?php echo $row['user_id']; ?></span>
                            <span><i class="far fa-calendar-alt"></i> <?php echo date('M d, Y', strtotime($row['created_at'])); ?></span>
                        </div>
                        <div class="stars" style="margin-bottom: 15px;">
                            <?php 
                            for($i=1; $i<=5; $i++) {
                                echo ($i <= $row['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                            }
                            ?>
                        </div>
                        <p class="review-text">"<?php echo htmlspecialchars($row['comment']); ?>"</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-reviews">
                    <i class="fas fa-comments fa-4x" style="margin-bottom: 20px; color: #bdc3c7;"></i>
                    <h3>No Reviews Yet</h3>
                    <p>When travelers complete a trip with you, their feedback will appear here.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>