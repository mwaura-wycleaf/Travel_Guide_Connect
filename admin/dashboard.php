<?php
include("../database/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// Fetch counts
$guides = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM guides"));
$users = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));
$attractions = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM attractions"));
$bookings = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM bookings"));
?>

<div class="main">
<h1>Dashboard</h1>
<div class="cards">
    <div class="card"><h3>Total Guides</h3><p><?php echo $guides;?></p></div>
    <div class="card"><h3>Total Attractions</h3><p><?php echo $attractions;?></p></div>
    <div class="card"><h3>Total Users</h3><p><?php echo $users;?></p></div>
    <div class="card"><h3>Total Bookings</h3><p><?php echo $bookings;?></p></div>
</div>
</div>
</body>
</html>