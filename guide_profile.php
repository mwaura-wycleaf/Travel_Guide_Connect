<?php 
session_start();
require_once "includes/db.php"; 
include "includes/header.php"; 

// 1. Get the Guide ID from the URL
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("location: guides.php");
    exit;
}
$guide_id = mysqli_real_escape_string($link, $_GET['id']);

// 2. Fetch Guide Details
$sql = "SELECT * FROM guides WHERE id = '$guide_id'";
$result = mysqli_query($link, $sql);
$guide = mysqli_fetch_assoc($result);

if(!$guide){
    echo "<div class='container'><h2>Guide not found.</h2></div>";
    include "includes/footer.php";
    exit;
}

// 3. Handle New Review Submission
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])){
    $u_name = mysqli_real_escape_string($link, $_POST['u_name']);
    $u_rating = mysqli_real_escape_string($link, $_POST['u_rating']);
    $u_comment = mysqli_real_escape_string($link, $_POST['u_comment']);

    $ins_sql = "INSERT INTO reviews (guide_id, user_name, rating, comment) VALUES ('$guide_id', '$u_name', '$u_rating', '$u_comment')";
    mysqli_query($link, $ins_sql);
    // Refresh to show new review
    header("Location: guide_profile.php?id=" . $guide_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $guide['name']; ?> | Profile</title>
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .profile-container { max-width: 900px; margin: 40px auto; padding: 20px; }
        
        /* Profile Header */
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            display: flex;
            gap: 30px;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .profile-card img {
            width: 200px;
            height: 200px;
            border-radius: 20px;
            object-fit: cover;
            border: 5px solid #27ae60;
        }
        .profile-info h1 { margin: 0; color: #2c3e50; }
        .badge-spec { background: #27ae60; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; }

        /* Review Section */
        .review-section { margin-top: 40px; }
        .review-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #27ae60;
        }
        .star-rating { color: #f1c40f; }

        /* Review Form */
        .add-review {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            margin-top: 40px;
        }
        .add-review input, .add-review textarea, .add-review select {
            width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 10px;
        }
        .btn-review { background: #27ae60; color: white; border: none; padding: 10px 30px; border-radius: 20px; cursor: pointer; }

        @media (max-width: 768px) {
            .profile-card { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-card">
        <img src="images/<?php echo $guide['profile_img']; ?>" onerror="this.src='images/default_guide.jpg';">
        <div class="profile-info">
            <span class="badge-spec"><?php echo $guide['specialization']; ?></span>
            <h1><?php echo $guide['name']; ?></h1>
            <p><i class="fas fa-map-marker-alt"></i> <?php echo $guide['location']; ?></p>
            <p><strong>Experience:</strong> <?php echo $guide['experience_years']; ?> Years</p>
            <p><strong>Bio:</strong> <?php echo $guide['bio']; ?></p>
            <a href="mailto:<?php echo $guide['email']; ?>" class="btn-review" style="text-decoration:none;">Contact Guide</a>
        </div>
    </div>

    <div class="review-section">
        <h2>Reviews & Ratings</h2>
        <?php
        $rev_sql = "SELECT * FROM reviews WHERE guide_id = '$guide_id' ORDER BY created_at DESC";
        $rev_res = mysqli_query($link, $rev_sql);
        if(mysqli_num_rows($rev_res) > 0){
            while($rev = mysqli_fetch_assoc($rev_res)){
                echo "<div class='review-box'>";
                echo "<strong>".htmlspecialchars($rev['user_name'])."</strong> ";
                echo "<span class='star-rating'>";
                for($i=1; $i<=$rev['rating']; $i++) echo "★";
                echo "</span>";
                echo "<p>".htmlspecialchars($rev['comment'])."</p>";
                echo "<small style='color:#999;'>".$rev['created_at']."</small>";
                echo "</div>";
            }
        } else {
            echo "<p>No reviews yet. Be the first to rate!</p>";
        }
        ?>
    </div>

    <div class="add-review">
        <h3>Leave a Review</h3>
        <form action="" method="POST">
            <input type="text" name="u_name" placeholder="Your Name" required>
            <select name="u_rating" required>
                <option value="5">5 Stars - Excellent</option>
                <option value="4">4 Stars - Very Good</option>
                <option value="3">3 Stars - Good</option>
                <option value="2">2 Stars - Poor</option>
                <option value="1">1 Star - Terrible</option>
            </select>
            <textarea name="u_comment" rows="4" placeholder="Share your experience with this guide..." required></textarea>
            <button type="submit" name="submit_review" class="btn-review">Post Review</button>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>