<?php
// 1. Always start the session first
session_start();

// 2. Database Connection
include("../includes/db.php"); 

// 3. Updated Security Check: Match the new Unified Login variables
if(!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'guide'){
    // Redirect to the central login if they aren't a logged-in guide
    header("Location: ../auth/login.php");
    exit();
}

// Use the session ID from the unified login
$guide_id = $_SESSION['id'];

// 4. Fetch Reviews for this specific guide
// Assumes 'reviews' table exists with columns: guide_id, user_id, rating, comment, created_at
$review_query = "SELECT * FROM reviews WHERE guide_id = ? ORDER BY created_at DESC";
$stmt = $link->prepare($review_query);
$stmt->bind_param("i", $guide_id);
$stmt->execute();
$reviews_result = $stmt->get_result();

// 5. Calculate Average Rating
$avg_stmt = $link->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE guide_id = ?");
$avg_stmt->bind_param("i", $guide_id);
$avg_stmt->execute();
$avg_result = $avg_stmt->get_result();
$avg_data = $avg_result->fetch_assoc();

$rating = ($avg_data['avg_rating']) ? number_format($avg_data['avg_rating'], 1) : "0.0";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reviews | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; margin: 0; display: flex; }
        
        /* Main Content Styling */
        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            width: calc(100% - 250px); 
            display: flex;
            flex-direction: column;
            align-items: center; 
            min-height: 100vh;
        }

        .content-container { width: 100%; max-width: 800px; }
        
        h1 { color: #2c3e50; text-align: center; margin-bottom: 30px; font-size: 2.2rem; }

        /* Rating Header Card */
        .rating-header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
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

        @media (max-width: 992px) {
            .main-content { margin-left: 0; width: 100%; padding: 20px; }
            .rating-header { flex-direction: column; gap: 15px; text-align: center; }
        }
    </style>
</head>
<body>

<?php include("../includes/sidebar.php"); ?>

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
            <?php if($reviews_result->num_rows > 0): ?>
                <?php while($row = $reviews_result->fetch_assoc()): ?>
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