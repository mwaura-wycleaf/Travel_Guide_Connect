<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

// 1. Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// 2. Get Attraction ID
if (!isset($_GET['id'])) {
    header("location: attractions.php");
    exit;
}
$attraction_id = mysqli_real_escape_string($link, $_GET['id']);
$res = mysqli_query($link, "SELECT * FROM attractions WHERE id = '$attraction_id'");
$place = mysqli_fetch_assoc($res);

// 3. Handle Booking Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $travel_date = mysqli_real_escape_string($link, $_POST['travel_date']);
    $guests = mysqli_real_escape_string($link, $_POST['guests']);

    $sql = "INSERT INTO bookings (user_id, attraction_id, booking_date, num_people, status) 
            VALUES ('$user_id', '$attraction_id', '$travel_date', '$guests', 'Pending')";
    
    if (mysqli_query($link, $sql)) {
        echo "<script>alert('Booking request sent! Wait for admin confirmation.'); window.location.href='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .booking-form-container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .booking-form-container h2 { color: #27ae60; margin-bottom: 20px; text-align: center; }
        .place-preview { background: #f9f9f9; padding: 15px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px; }
        .place-preview img { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-book { width: 100%; background: #27ae60; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-book:hover { background: #219150; }
    </style>
</head>
<body>
<div class="booking-form-container">
    <h2>Book Your Trip</h2>
    <div class="place-preview">
        <img src="images/<?php echo $place['img_url']; ?>">
        <div>
            <strong><?php echo $place['name']; ?></strong><br>
            <small><?php echo $place['location']; ?></small>
        </div>
    </div>
    <form action="" method="POST">
        <div class="form-group">
            <label>Travel Date</label>
            <input type="date" name="travel_date" min="<?php echo date('Y-m-d'); ?>" required>
        </div>
        <div class="form-group">
            <label>Number of Guests</label>
            <input type="number" name="guests" min="1" max="20" value="1" required>
        </div>
        <button type="submit" class="btn-book">Confirm Booking Request</button>
    </form>
</div>
</body>
</html>