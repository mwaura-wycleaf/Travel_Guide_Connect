<?php
session_start();
require_once "../includes/db.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != "guide"){
    header("location: ../auth/guide_login.php");
    exit();
}

$guide_id = $_SESSION["id"];
$result = mysqli_query($link, "SELECT r.rating, r.comment, u.name AS traveler 
FROM reviews r
JOIN users u ON r.user_id = u.id
WHERE r.guide_id='$guide_id'
ORDER BY r.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reviews | Travel Guide Connect</title>
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
<h2>Your Reviews</h2>
<table>
<tr>
<th>Traveler</th>
<th>Rating</th>
<th>Comment</th>
</tr>
<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['traveler']; ?></td>
<td><?php echo $row['rating']; ?>/5</td>
<td><?php echo $row['comment']; ?></td>
</tr>
<?php } ?>
</table>
</div>
</div>

</body>
</html>
