<?php
session_start();
// Database connection
include("../includes/db.php"); 

if(!isset($_SESSION['guide_id'])){
    header("Location: login_guide.php");
    exit();
}

$guide_id = $_SESSION['guide_id'];
$message = "";

// --- 1. AUTOMATIC DATABASE & FOLDER SETUP ---
$check_cols = mysqli_query($link, "SHOW COLUMNS FROM guides");
$existing_cols = [];
while($r = mysqli_fetch_assoc($check_cols)) { $existing_cols[] = $r['Field']; }

$migrations = [
    'phone' => "ALTER TABLE guides ADD COLUMN phone VARCHAR(20) NULL",
    'location' => "ALTER TABLE guides ADD COLUMN location VARCHAR(100) NULL",
    'bio' => "ALTER TABLE guides ADD COLUMN bio TEXT NULL",
    'profile_pic' => "ALTER TABLE guides ADD COLUMN profile_pic VARCHAR(255) DEFAULT 'default.png'"
];

foreach($migrations as $col => $sql) {
    if(!in_array($col, $existing_cols)) { mysqli_query($link, $sql); }
}

// Folder setup
$target_dir = "../images/guides/";
if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

// Automatic Dummy Avatar Download (Standard Silhouette)
$default_file = $target_dir . "default.png";
if (!file_exists($default_file)) {
    // This URL generates a clean gray/white mystery person silhouette
    $dummy_url = "https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y&s=200";
    $img_data = file_get_contents($dummy_url);
    file_put_contents($default_file, $img_data);
}

// --- 2. HANDLE PROFILE UPDATE ---
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $bio = mysqli_real_escape_string($link, $_POST['bio']);
    
    // Check if user is uploading a new file
    if (!empty($_FILES['image']['name'])) {
        $pic_name = time() . "_" . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $pic_name)) {
            $sql_pic = ", profile_pic='$pic_name'";
        }
    } else {
        $sql_pic = ""; // Don't change the picture if none uploaded
    }

    $update_sql = "UPDATE guides SET name='$name', phone='$phone', location='$location', bio='$bio' $sql_pic WHERE id='$guide_id'";
    
    if (mysqli_query($link, $update_sql)) {
        $_SESSION['guide_name'] = $name; 
        $message = "<div class='alert success'><i class='fas fa-check-circle'></i> Profile successfully updated!</div>";
    } else {
        $message = "<div class='alert error'>Error: " . mysqli_error($link) . "</div>";
    }
}

// --- 3. FETCH CURRENT IMAGE FOR PREVIEW ---
$res = mysqli_query($link, "SELECT profile_pic FROM guides WHERE id = '$guide_id'");
$guide_data = mysqli_fetch_assoc($res);
$current_pic = (!empty($guide_data['profile_pic'])) ? $guide_data['profile_pic'] : 'default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile | T-Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #2c3e50; color: white; padding: 25px; position: fixed; }
        .sidebar h2 { color: #27ae60; margin-bottom: 30px; }
        .sidebar a { display: block; color: #bdc3c7; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; }
        .sidebar a.active { background: #34495e; color: #27ae60; font-weight: bold; }
        
        .main-content { margin-left: 250px; padding: 40px; width: calc(100% - 250px); }
        .profile-card { background: white; padding: 35px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #2c3e50; font-weight: 600; }
        .form-group input, .form-group textarea { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; outline: none;
        }
        .form-group input:focus { border-color: #27ae60; }
        
        .profile-preview {
            width: 120px; height: 120px; border-radius: 50%; object-fit: cover;
            margin-bottom: 15px; border: 3px solid #27ae60; background: #eee;
        }

        .btn-save {
            background: #27ae60; color: white; border: none; padding: 14px 40px;
            border-radius: 30px; cursor: pointer; font-weight: bold; width: 100%; transition: 0.3s;
        }
        .btn-save:hover { background: #1e8449; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Guide Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_bookings.php">My Trips</a>
    <a href="availability.php">Availability</a>
    <a href="reviews.php">Reviews</a>
    <a href="edit_profile.php" class="active">Edit Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main-content">
    <h1 style="text-align: center; color: #2c3e50;">Complete Your Profile</h1>
    <?php echo $message; ?>

    <div class="profile-card">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group" style="text-align: center;">
                <label>Profile Image</label>
                <img src="../images/guides/<?php echo $current_pic; ?>" class="profile-preview">
                <br>
                <input type="file" name="image" accept="image/*">
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" placeholder="+254 7xx xxx xxx">
            </div>

            <div class="form-group">
                <label>Current Location</label>
                <input type="text" name="location" placeholder="e.g. Nyeri, Kenya">
            </div>

            <div class="form-group">
                <label>Professional Bio</label>
                <textarea name="bio" rows="4" placeholder="Tell travelers about your expertise..."></textarea>
            </div>

            <button type="submit" name="update_profile" class="btn-save">Update Profile</button>
        </form>
    </div>
</div>

</body>
</html>
