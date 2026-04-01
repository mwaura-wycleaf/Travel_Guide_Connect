<?php
// 1. Always start the session first
session_start();
include("../includes/db.php"); 

// 2. Updated Security Check: Match the new Unified Login variables
if(!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'guide'){
    header("Location: ../auth/login.php");
    exit();
}

$guide_id = $_SESSION['id']; // Using the unified session ID
$message = "";

// --- 1. DATABASE SETUP (Ensures columns exist) ---
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
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $bio = $_POST['bio'];
    
    $pic_name = "";
    if (!empty($_FILES['image']['name'])) {
        $pic_name = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $pic_name);
    }

    // Use Prepared Statement for security and handling special characters in Bio
    if ($pic_name != "") {
        $stmt = $link->prepare("UPDATE guides SET name=?, phone=?, location=?, bio=?, profile_pic=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $phone, $location, $bio, $pic_name, $guide_id);
    } else {
        $stmt = $link->prepare("UPDATE guides SET name=?, phone=?, location=?, bio=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $phone, $location, $bio, $guide_id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['name'] = $name; // Update session name so sidebar updates immediately
        $message = "<div class='alert success'><i class='fas fa-check-circle'></i> Profile updated successfully!</div>";
    } else {
        $message = "<div class='alert error'>Update failed. Please try again.</div>";
    }
    $stmt->close();
}

// --- 3. FETCH DATA TO PRE-FILL FORM ---
$stmt = $link->prepare("SELECT * FROM guides WHERE id = ?");
$stmt->bind_param("i", $guide_id);
$stmt->execute();
$res = $stmt->get_result();
$guide_data = $res->fetch_assoc();
$current_pic = (!empty($guide_data['profile_pic'])) ? $guide_data['profile_pic'] : 'default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; margin: 0; display: flex; }
        
        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            width: calc(100% - 250px); 
            min-height: 100vh;
        }

        .profile-card { 
            background: white; 
            padding: 35px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
            max-width: 700px; 
            margin: 0 auto; 
        }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #2c3e50; font-weight: 600; font-size: 0.9rem; }
        .form-group input, .form-group textarea { 
            width: 100%; padding: 14px; border: 1.5px solid #eef0f2; border-radius: 12px; outline: none; transition: 0.3s;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: #27ae60; background: #fff; }
        
        .profile-image-section { text-align: center; margin-bottom: 30px; }
        .profile-preview { 
            width: 130px; height: 130px; border-radius: 50%; object-fit: cover; 
            margin-bottom: 15px; border: 4px solid #27ae60; padding: 3px; background: white;
        }

        .btn-save { 
            background: #2c3e50; color: white; border: none; padding: 16px; 
            border-radius: 12px; cursor: pointer; font-weight: bold; width: 100%; transition: 0.3s; 
        }
        .btn-save:hover { background: #27ae60; transform: translateY(-2px); }

        .alert { padding: 15px; border-radius: 12px; margin-bottom: 25px; text-align: center; font-weight: 500; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        @media (max-width: 992px) {
            .main-content { margin-left: 0; width: 100%; padding: 20px; }
        }
    </style>
</head>
<body>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">
    <h1 style="text-align: center; color: #2c3e50; margin-bottom: 30px;">Professional Profile</h1>
    
    <div class="profile-card">
        <?php echo $message; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="profile-image-section">
                <img src="../images/guides/<?php echo htmlspecialchars($current_pic); ?>" class="profile-preview">
                <br>
                <input type="file" name="image" accept="image/*" style="font-size: 0.8rem; color: #7f8c8d;">
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($guide_data['name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($guide_data['phone'] ?? ''); ?>" placeholder="e.g. +254 700 000 000">
            </div>

            <div class="form-group">
                <label>Current Location</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($guide_data['location'] ?? ''); ?>" placeholder="e.g. Nyeri, Kenya">
            </div>

            <div class="form-group">
                <label>Professional Bio</label>
                <textarea name="bio" rows="5" placeholder="Tell travelers about your experience..."><?php echo htmlspecialchars($guide_data['bio'] ?? ''); ?></textarea>
            </div>

            <button type="submit" name="update_profile" class="btn-save">Save Profile Changes</button>
        </form>
    </div>
</div>

</body>
</html>