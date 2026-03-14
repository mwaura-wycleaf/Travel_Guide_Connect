<?php
session_start();
require_once "../includes/db.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != "guide"){
    header("location: ../auth/guide_login.php");
    exit();
}

$guide_id = $_SESSION["id"];
$row = mysqli_fetch_assoc(mysqli_query($link,"SELECT name, phone, bio FROM guides WHERE user_id='$guide_id'"));
$name = $row['name'];
$phone = $row['phone'];
$bio = $row['bio'];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $bio = trim($_POST['bio']);
    mysqli_query($link,"UPDATE guides SET name='$name', phone='$phone', bio='$bio' WHERE user_id='$guide_id'");
    header("location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Profile | Travel Guide Connect</title>
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
<h2>Edit Profile</h2>
<form method="POST">
<input type="text" name="name" value="<?php echo $name; ?>" placeholder="Full Name" required>
<input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="Phone">
<textarea name="bio" placeholder="Bio"><?php echo $bio; ?></textarea>
<button type="submit" class="btn-login"><i class="fas fa-save"></i> Save Changes</button>
</form>
</div>
</div>

</body>
</html>
