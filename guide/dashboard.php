<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != "guide"){
    header("location: ../auth/guide_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Guide Dashboard | Travel Guide Connect</title>
<link rel="stylesheet" href="../assets/css/guide.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header>
    <div class="header-container">
        <h2>Travel Guide Connect</h2>
        <nav>
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="availability.php"><i class="fas fa-calendar-check"></i> Availability</a></li>
                <li><a href="manage_bookings.php"><i class="fas fa-book"></i> Bookings</a></li>
                <li><a href="reviews.php"><i class="fas fa-star"></i> Reviews</a></li>
                <li><a href="edit_profile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="../auth/guide_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container">
    <div class="login-card">
        <h2>Welcome, <?php echo $_SESSION["name"]; ?>!</h2>
        <p>Manage your schedule, bookings, and reviews from here.</p>
        <div style="display:flex; flex-direction:column; gap:15px; margin-top:20px;">
            <a href="availability.php"><button class="btn-login"><i class="fas fa-calendar-check"></i> Manage Availability</button></a>
            <a href="manage_bookings.php"><button class="btn-login"><i class="fas fa-book"></i> Manage Bookings</button></a>
            <a href="reviews.php"><button class="btn-login"><i class="fas fa-star"></i> View Reviews</button></a>
            <a href="edit_profile.php"><button class="btn-login"><i class="fas fa-user"></i> Edit Profile</button></a>
        </div>
    </div>
</div>

</body>
</html>
