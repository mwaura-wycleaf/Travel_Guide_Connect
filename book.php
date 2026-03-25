<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

// 1. Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// 2. Get BOTH Attraction ID and Guide ID from the URL
// These come from the view_attraction.php page we made earlier
if (!isset($_GET['attr_id']) || !isset($_GET['guide_id'])) {
    header("location: attractions.php");
    exit;
}

$attraction_id = mysqli_real_escape_string($link, $_GET['attr_id']);
$guide_id = mysqli_real_escape_string($link, $_GET['guide_id']);

// Fetch details for the preview
$res_place = mysqli_query($link, "SELECT * FROM attractions WHERE id = '$attraction_id'");
$place = mysqli_fetch_assoc($res_place);

$res_guide = mysqli_query($link, "SELECT name, profile_pic FROM guides WHERE id = '$guide_id'");
$guide = mysqli_fetch_assoc($res_guide);

// 3. Handle Booking Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $user_name = $_SESSION['username']; // or 'name' depending on your session variable
    $user_email = $_SESSION['email'];
    $travel_date = mysqli_real_escape_string($link, $_POST['travel_date']);
    $guests = mysqli_real_escape_string($link, $_POST['guests']);

    // CRITICAL: We now include guide_id so it shows up in the guide's manage_bookings.php
    $sql = "INSERT INTO bookings (user_id, guide_id, attraction_id, user_name, user_email, booking_date, num_people, status) 
            VALUES ('$user_id', '$guide_id', '$attraction_id', '$user_name', '$user_email', '$travel_date', '$guests', 'Pending')";
    
    if (mysqli_query($link, $sql)) {
        echo "<script>alert('Booking request sent to " . $guide['name'] . "! Wait for their confirmation.'); window.location.href='my_bookings.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .booking-form-container { max-width: 550px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .booking-form-container h2 { color: #27ae60; margin-bottom: 20px; text-align: center; }
        
        /* New Preview Box showing BOTH the place and the person */
        .booking-summary { background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #eee; }
        .summary-row { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        .summary-row:last-child { margin-bottom: 0; }
        .summary-row img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #27ae60; }
        .summary-row .label { font-size: 12px; color: #777; text-transform: uppercase; font-weight: bold; display: block; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-book { width: 100%; background: #27ae60; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-book:hover { background: #219150; transform: translateY(-2px); }
    </style>
</head>
<body>
<div class="booking-form-container">
    <h2>Confirm Your Trip</h2>
    
    <div class="booking-summary">
        <div class="summary-row">
            <img src="images/attractions/<?php echo $place['image']; ?>">
            <div>
                <span class="label">Destination</span>
                <strong><?php echo $place['name']; ?></strong>
            </div>
        </div>
        <div class="summary-row">
            <img src="images/guides/<?php echo $guide['profile_pic']; ?>">
            <div>
                <span class="label">Your Guide</span>
                <strong><?php echo $guide['name']; ?></strong>
            </div>
        </div>
    </div>

    <form action="" method="POST">
        <div class="form-group">
            <label><i class="fas fa-calendar-alt"></i> Travel Date</label>
            <input type="date" name="travel_date" min="<?php echo date('Y-m-d'); ?>" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-users"></i> Number of Guests</label>
            <input type="number" name="guests" min="1" max="20" value="1" required>
        </div>
        <button type="submit" class="btn-book">Send Request to Guide</button>
    </form>
</div>
</body>
</html>