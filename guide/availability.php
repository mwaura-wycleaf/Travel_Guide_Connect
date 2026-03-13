<?php
session_start();
require_once "../includes/db.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != "guide"){
    header("location: ../auth/guide_login.php");
    exit();
}

$guide_id = $_SESSION["id"];
// Sample query: list availability (adjust table name/fields as per your DB)
$result = mysqli_query($link, "SELECT * FROM availability WHERE guide_id='$guide_id' ORDER BY available_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Availability | Travel Guide Connect</title>
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
<h2>Your Availability</h2>
<a href="add_availability.php"><button class="btn-login"><i class="fas fa-plus"></i> Add New</button></a>

<table>
<tr>
<th>Date</th>
<th>Start Time</th>
<th>End Time</th>
</tr>
<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['available_date']; ?></td>
<td><?php echo $row['start_time']; ?></td>
<td><?php echo $row['end_time']; ?></td>
</tr>
<?php } ?>
</table>
</div>
</div>

</body>
</html>
