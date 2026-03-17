<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

// 1. Security Check: Only logged-in users
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$message = "";

// 2. Get the Attraction and Guide IDs (usually passed via URL from my_bookings.php)
if (isset($_GET['attraction_id']) && isset($_GET['guide_id'])) {
    $attraction_id = mysqli_real_escape_string($link, $_GET['attraction_id']);
    $guide_id = mysqli_real_escape_string($link, $_GET['guide_id']);
} else {
    header("location: my_bookings.php");
    exit;
}

// 3. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_SESSION['username']; // Using the session username per your table structure
    $rating = mysqli_real_escape_string($link, $_POST['rating']);
    $comment = mysqli_real_escape_string($link, $_POST['comment']);

    $sql = "INSERT INTO reviews (guide_id, attraction_id, user_name, rating, comment) 
            VALUES ('$guide_id', '$attraction_id', '$user_name', '$rating', '$comment')";

    if (mysqli_query($link, $sql)) {
        $message = "<div class='alert success'>Review posted! Thank you for your feedback.</div>";
        echo "<script>setTimeout(() => { window.location.href='my_bookings.php'; }, 2000);</script>";
    } else {
        $message = "<div class='alert error'>Error: Could not save review.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .review-box { max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 10px; margin-bottom: 20px; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 2rem; color: #ddd; cursor: pointer; transition: 0.2s; }
        .star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color: #f1c40f; }
        
        textarea { width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 10px; height: 120px; font-family: inherit; }
        .btn-submit { background: #27ae60; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 15px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="review-box">
    <h2>Share Your Experience</h2>
    <p style="color: #666;">How was your trip? Your feedback helps our guides improve.</p>
    <?php echo $message; ?>

    <form method="POST">
        <label style="font-weight: bold; display: block; margin-bottom: 10px;">Your Rating:</label>
        <div class="star-rating">
            <input type="radio" id="star5" name="rating" value="5" required/><label for="star5"><i class="fas fa-star"></i></label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4"><i class="fas fa-star"></i></label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3"><i class="fas fa-star"></i></label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2"><i class="fas fa-star"></i></label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1"><i class="fas fa-star"></i></label>
        </div>

        <label style="font-weight: bold; display: block; margin-bottom: 10px;">Your Comments:</label>
        <textarea name="comment" placeholder="Describe the service, the guide, and the destination..." required></textarea>

        <button type="submit" class="btn-submit">Post Review</button>
    </form>
</div>

</body>
</html>