<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

// 1. Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// 2. Get BOTH IDs from the URL
if (!isset($_GET['attr_id']) || !isset($_GET['guide_id'])) {
    header("location: attractions.php");
    exit;
}

$attraction_id = mysqli_real_escape_string($link, $_GET['attr_id']);
$guide_id = mysqli_real_escape_string($link, $_GET['guide_id']);

// Fetch details for the preview
$res_place = mysqli_query($link, "SELECT * FROM attractions WHERE id = '$attraction_id'");
$place = mysqli_fetch_assoc($res_place);

$res_guide = mysqli_query($link, "SELECT name, profile_img, rate_per_day FROM guides WHERE id = '$guide_id'");
$guide = mysqli_fetch_assoc($res_guide);

if (!$place || !$guide) {
    header("location: attractions.php");
    exit;
}

// 3. Handle Booking Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $travel_date = mysqli_real_escape_string($link, $_POST['travel_date']);
    $guests = mysqli_real_escape_string($link, $_POST['guests']);

    // Table name corrected to 'bookings'
    $sql = "INSERT INTO bookings (user_id, guide_id, attraction_id, booking_date, num_people, status) 
            VALUES ('$user_id', '$guide_id', '$attraction_id', '$travel_date', '$guests', 'Pending')";
    
    if (mysqli_query($link, $sql)) {
        echo "<script>alert('Booking request sent to " . addslashes($guide['name']) . "! Wait for confirmation.'); window.location.href='my_bookings.php';</script>";
    } else {
        echo "Error: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Booking - Travel Guide Connect</title>
    <style>
        body { background-color: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .booking-form-container { max-width: 500px; margin: 50px auto; background: white; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .booking-form-container h2 { color: #2c3e50; margin-bottom: 25px; text-align: center; font-weight: 700; }
        
        /* Summary Box */
        .booking-summary { background: #fdfdfd; padding: 20px; border-radius: 15px; margin-bottom: 25px; border: 1px solid #eee; }
        .summary-row { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        .summary-row:last-child { margin-bottom: 0; }
        
        .summary-thumb { width: 55px; height: 55px; border-radius: 12px; object-fit: cover; border: 2px solid #f0fdf4; }
        .guide-avatar { width: 55px; height: 55px; border-radius: 50%; object-fit: cover; border: 2px solid #27ae60; }
        
        .label { font-size: 11px; color: #95a5a6; text-transform: uppercase; font-weight: 800; display: block; letter-spacing: 0.5px; }
        .val { font-size: 1rem; color: #2c3e50; font-weight: 600; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 10px; box-sizing: border-box; transition: 0.3s; }
        .form-group input:focus { border-color: #27ae60; outline: none; box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1); }
        
        .total-box { margin-top: 20px; padding: 15px; background: #e8f5e9; border-radius: 10px; text-align: center; color: #2e7d32; font-weight: 700; }

        .btn-book { width: 100%; background: #27ae60; color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.3s; font-size: 1rem; margin-top: 15px; }
        .btn-book:hover { background: #219150; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(33, 145, 80, 0.3); }
    </style>
</head>
<body>
<div class="booking-form-container">
    <h2>Confirm Your Trip</h2>
    
    <div class="booking-summary">
        <div class="summary-row">
            <img src="images/<?php echo htmlspecialchars($place['img_url']); ?>" class="summary-thumb" onerror="this.src='images/default.jpg';">
            <div>
                <span class="label">Destination</span>
                <div class="val"><?php echo htmlspecialchars($place['name']); ?></div>
            </div>
        </div>

        <div class="summary-row">
            <?php 
                $g_img = "images/guides/" . $guide['profile_img'];
                if (empty($guide['profile_img']) || !file_exists($g_img)) {
                    $g_img = "https://ui-avatars.com/api/?name=" . urlencode($guide['name']) . "&background=27ae60&color=fff";
                }
            ?>
            <img src="<?php echo $g_img; ?>" class="guide-avatar">
            <div>
                <span class="label">Your Expert Guide</span>
                <div class="val"><?php echo htmlspecialchars($guide['name']); ?></div>
                <small style="color: #27ae60; font-weight: bold;">Ksh <?php echo number_format($guide['rate_per_day']); ?>/day</small>
            </div>
        </div>
    </div>

    <form action="" method="POST">
        <div class="form-group">
            <label><i class="fas fa-calendar-alt"></i> When are you visiting?</label>
            <input type="date" name="travel_date" min="<?php echo date('Y-m-d'); ?>" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-users"></i> Number of Guests</label>
            <input type="number" id="guests" name="guests" min="1" max="20" value="1" oninput="updateTotal()" required>
        </div>

        <div class="total-box">
            Estimated Total: <span id="display-total">Ksh <?php echo number_format($guide['rate_per_day']); ?></span>
        </div>

        <button type="submit" class="btn-book">Confirm & Send Request</button>
    </form>
</div>

<script>
    function updateTotal() {
        const rate = <?php echo $guide['rate_per_day']; ?>;
        const guests = document.getElementById('guests').value;
        const total = rate * guests;
        document.getElementById('display-total').innerText = "Ksh " + total.toLocaleString();
    }
</script>

</body>
</html>