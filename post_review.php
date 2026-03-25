<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

// 1. Security Check
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$message = "";

// 2. Get the Attraction and Guide IDs from URL
if (isset($_GET['attraction_id']) && isset($_GET['guide_id'])) {
    $attraction_id = mysqli_real_escape_string($link, $_GET['attraction_id']);
    $guide_id = mysqli_real_escape_string($link, $_GET['guide_id']);
    
    // Fetch names for the UI
    $info_query = "SELECT a.name as attr_name, g.name as guide_name 
                   FROM attractions a, guides g 
                   WHERE a.id = '$attraction_id' AND g.id = '$guide_id'";
    $info_res = mysqli_query($link, $info_query);
    $info = mysqli_fetch_assoc($info_res);
} else {
    header("location: my_bookings.php");
    exit;
}

// 3. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure we have a username from session
    $user_name = $_SESSION['username'] ?? $_SESSION['name'] ?? 'Anonymous Tourist';
    $rating = mysqli_real_escape_string($link, $_POST['rating']);
    $comment = mysqli_real_escape_string($link, $_POST['comment']);

    // Check if the reviews table has these columns!
    $sql = "INSERT INTO reviews (guide_id, attraction_id, user_name, rating, comment) 
            VALUES ('$guide_id', '$attraction_id', '$user_name', '$rating', '$comment')";

    if (mysqli_query($link, $sql)) {
        $message = "<div class='alert success'><i class='fas fa-check-circle'></i> Review posted! Redirecting...</div>";
        echo "<script>setTimeout(() => { window.location.href='my_bookings.php'; }, 2500);</script>";
    } else {
        $message = "<div class='alert error'>Error: Could not save review.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Review | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .review-box { 
            max-width: 550px; margin: 60px auto; background: white; 
            padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.08); 
        }
        .review-header { text-align: center; margin-bottom: 30px; }
        .review-header h2 { color: #2c3e50; margin-bottom: 5px; }
        .review-header span { color: #27ae60; font-weight: bold; }

        /* Star Rating Logic */
        .star-rating { 
            display: flex; flex-direction: row-reverse; 
            justify-content: center; gap: 15px; margin: 20px 0; 
        }
        .star-rating input { display: none; }
        .star-rating label { font-size: 2.5rem; color: #dfe6e9; cursor: pointer; transition: 0.2s; }
        
        /* Fill stars on hover and check */
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #f1c40f; }

        textarea { 
            width: 100%; padding: 15px; border: 1px solid #ddd; 
            border-radius: 12px; height: 130px; font-family: inherit; 
            font-size: 1rem; box-sizing: border-box; resize: none;
        }
        textarea:focus { outline: none; border-color: #27ae60; box-shadow: 0 0 8px rgba(39, 174, 96, 0.1); }

        .btn-submit { 
            width: 100%; background: #27ae60; color: white; border: none; 
            padding: 15px; border-radius: 30px; font-weight: bold; 
            font-size: 1.1rem; cursor: pointer; margin-top: 20px; transition: 0.3s; 
        }
        .btn-submit:hover { background: #219150; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(39, 174, 96, 0.2); }

        .alert { padding: 15px; border-radius: 10px; margin-bottom: 25px; text-align: center; font-weight: 600; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="review-box">
    <div class="review-header">
        <h2>Rate Your Experience</h2>
        <p>Reviewing <span><?php echo htmlspecialchars($info['guide_name']); ?></span> <br> 
        for the trip to <strong><?php echo htmlspecialchars($info['attr_name']); ?></strong></p>
    </div>

    <?php echo $message; ?>

    <form method="POST">
        <label style="font-weight: bold; color: #2c3e50; text-align: center; display: block;">Overall Rating</label>
        <div class="star-rating">
            <input type="radio" id="star5" name="rating" value="5" required/><label for="star5"><i class="fas fa-star"></i></label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4"><i class="fas fa-star"></i></label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3"><i class="fas fa-star"></i></label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2"><i class="fas fa-star"></i></label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1"><i class="fas fa-star"></i></label>
        </div>

        <label style="font-weight: bold; display: block; margin-bottom: 10px; color: #2c3e50;">Your Feedback</label>
        <textarea name="comment" placeholder="Tell us about the journey, the guide's knowledge, and the scenery..." required></textarea>

        <button type="submit" class="btn-submit">Submit Review</button>
    </form>
</div>

</body>
</html>