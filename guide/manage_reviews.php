<?php
// 1. Always start the session first
session_start();

// 2. Database Connection
include("../includes/db.php"); 

// 3. Security Check: Ensure only guides can access this page
if(!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'guide'){
    header("Location: ../auth/login.php");
    exit();
}

// Use the session ID from your unified login
$guide_id = $_SESSION['id'];

// 4. FETCH REVIEWS - Using 'user_name' from your actual table structure
// No JOIN needed because the name is already stored in the reviews table
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

// 6. UI INCLUDES
include("../includes/header.php");
include("../includes/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Reviews | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8fafb; font-family: 'Poppins', sans-serif; margin: 0; }

        /* --- HEADER & LOGO ALIGNMENT (FAR LEFT) --- */
        header {
            position: fixed;
            top: 0;
            left: 260px !important; 
            width: calc(100% - 260px) !important;
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Keeps logo at far left */
            padding: 0 25px; 
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            box-sizing: border-box;
        }

        .main-content { 
            margin-left: 260px; 
            padding: 40px; 
            padding-top: 110px; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .content-container { width: 100%; max-width: 900px; }
        
        h1 { color: #000; font-weight: 700; margin-bottom: 30px; }

        /* --- OVERALL RATING CARD --- */
        .rating-header {
            background: white;
            padding: 35px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 40px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        }

        .rating-number { font-size: 4.5rem; font-weight: 800; color: #2c3e50; line-height: 1; }
        .stars { color: #f1c40f; font-size: 1.1rem; }

        /* --- REVIEW ITEM CARDS --- */
        .review-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            border-left: 5px solid #2ecc71; /* Green accent for quality */
        }

        .review-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #888;
            font-size: 0.9rem;
        }

        .traveler-info { display: flex; align-items: center; gap: 10px; color: #333; font-weight: 600; }
        .user-avatar {
            width: 32px; height: 32px; background: #e8f5e9; color: #27ae60;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; font-size: 0.85rem; font-weight: bold;
        }

        .review-text { color: #555; line-height: 1.6; font-style: italic; font-size: 1.05rem; }

        .no-reviews {
            text-align: center; padding: 60px; background: white;
            border-radius: 15px; color: #95a5a6;
        }

        @media (max-width: 992px) {
            header { left: 0 !important; width: 100% !important; }
            .main-content { margin-left: 0; padding: 20px; padding-top: 90px; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="content-container">
        <h1>Guide Performance</h1>

        <div class="rating-header">
            <div class="rating-number"><?php echo $rating; ?></div>
            <div>
                <div class="stars">
                    <?php 
                    $rounded = round((float)$rating);
                    for($i=1; $i<=5; $i++) {
                        echo ($i <= $rounded) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    }
                    ?>
                </div>
                <p style="color: #7f8c8d; margin: 10px 0 0 0; font-weight: 500;">Overall Rating from Travelers</p>
            </div>
        </div>

        <div class="reviews-list">
            <?php if($reviews_result->num_rows > 0): ?>
                <?php while($row = $reviews_result->fetch_assoc()): ?>
                    <div class="review-card">
                        <div class="review-meta">
                            <div class="traveler-info">
                                <div class="user-avatar">
                                    <?php echo strtoupper(substr($row['user_name'], 0, 1)); ?>
                                </div>
                                <?php echo htmlspecialchars($row['user_name']); ?>
                            </div>
                            <span><i class="far fa-calendar-alt"></i> <?php echo date('M d, Y', strtotime($row['created_at'])); ?></span>
                        </div>
                        
                        <div class="stars" style="margin-bottom: 12px;">
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
                    <i class="fas fa-comments fa-3x" style="margin-bottom: 15px; color: #ddd;"></i>
                    <h3>No Feedback Yet</h3>
                    <p>Reviews will appear here after travelers complete their tours with you.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>