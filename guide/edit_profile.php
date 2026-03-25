<?php
session_start();
include("../includes/db.php"); 

if(!isset($_SESSION['guide_id'])){
    header("Location: guide_login.php");
    exit();
}

$guide_id = $_SESSION['guide_id'];
$message = "";

// --- 1. MIGRATIONS & SETUP ---
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

$target_dir = "../images/guides/";
if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

// --- 2. HANDLE PROFILE UPDATE ---
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $bio = mysqli_real_escape_string($link, $_POST['bio']);
    
    if (!empty($_FILES['image']['name'])) {
        $pic_name = time() . "_" . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $pic_name)) {
            $sql_pic = ", profile_pic='$pic_name'";
        }
    } else {
        $sql_pic = ""; 
    }

    $update_sql = "UPDATE guides SET name='$name', phone='$phone', location='$location', bio='$bio' $sql_pic WHERE id='$guide_id'";
    
    if (mysqli_query($link, $update_sql)) {
        $_SESSION['guide_name'] = $name; 
        $message = "<div class='alert success'><i class='fas fa-check-circle'></i> Profile updated!</div>";
    }
}

// --- 3. FETCH DATA TO PRE-FILL FORM ---
$res = mysqli_query($link, "SELECT * FROM guides WHERE id = '$guide_id'");
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
        .main-content { margin-left: 250px; padding: 40px; width: calc(100% - 250px); }
        .profile-card { background: white; padding: 35px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #2c3e50; font-weight: 600; }
        .form-group input, .form-group textarea { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; outline: none;
        }
        .form-group input:focus { border-color: #27ae60; }
        .profile-preview { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid #27ae60; background: #eee; }
        .btn-save { background: #27ae60; color: white; border: none; padding: 14px 40px; border-radius: 30px; cursor: pointer; font-weight: bold; width: 100%; transition: 0.3s; }
        .btn-save:hover { background: #1e8449; transform: translateY(-2px); }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">
    <h1 style="text-align: center; color: #2c3e50; margin-bottom: 30px;">Professional Profile</h1>
    
    <div class="profile-card">
        <?php echo $message; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group" style="text-align: center;">
                <img src="../images/guides/<?php echo $current_pic; ?>" class="profile-preview">
                <br>
                <input type="file" name="image" accept="image/*" style="border: none; width: auto;">
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($guide_data['name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($guide_data['phone']); ?>">
            </div>

            <div class="form-group">
                <label>Current Location</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($guide_data['location']); ?>">
            </div>

            <div class="form-group">
                <label>Professional Bio</label>
                <textarea name="bio" rows="4"><?php echo htmlspecialchars($guide_data['bio']); ?></textarea>
            </div>

            <button type="submit" name="update_profile" class="btn-save">Save Changes</button>
        </form>
    </div>
</div>

</body>
</html>