<?php
session_start();
require_once "../includes/db.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != "guide"){
    header("location: ../auth/guide_login.php");
    exit();
}

$guide_id = $_SESSION["id"];
// Sample query: join users and bookings table
$result = mysqli_query($link, "SELECT b.id, u.name AS traveler, b.booking_date, b.booking_time, b.status
FROM bookings b
JOIN users u ON b.user_id = u.id
WHERE b.guide_id='$guide_id'
ORDER BY b.booking_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Bookings | Travel Guide Connect</title>
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
<h2>Your Bookings</h2>
<table>
<tr>
<th>Traveler</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
</tr>
<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['traveler']; ?></td>
<td><?php echo $row['booking_date']; ?></td>
<td><?php echo $row['booking_time']; ?></td>
<td><?php echo ucfirst($row['status']); ?></td>
</tr>
<?php } ?>
</table>
</div>
</div>

</body>
</html>
