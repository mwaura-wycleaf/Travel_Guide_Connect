<?php
include("includes/guide_auth.php"); 
include("../includes/db.php"); 

$guide_id = $_SESSION['guide_id'];
$message = "";

// 1. HANDLE UPDATE
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $bio = mysqli_real_escape_string($link, $_POST['bio']);
    $location = mysqli_real_escape_string($link, $_POST['location']);

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_name, "../images/" . $img_name);
        $img_query = ", profile_img = '$img_name'";
    } else {
        $img_query = "";
    }

    $sql = "UPDATE guides SET name='$name', phone='$phone', bio='$bio', location='$location' $img_query WHERE id='$guide_id'";
    
    if (mysqli_query($link, $sql)) {
        $_SESSION['guide_name'] = $name; // Update session name in case it changed
        $message = "<div class='alert success'>Profile updated successfully!</div>";
    } else {
        $message = "<div class='alert error'>Update failed. Please try again.</div>";
    }
}

// 2. FETCH CURRENT DATA
$res = mysqli_query($link, "SELECT * FROM guides WHERE id = '$guide_id'");
$guide = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile | Guide Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; margin: 0; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #2c3e50; color: white; padding: 20px; position: fixed; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; }
        
        .main-content { margin-left: 250px; padding: 40px; width: 100%; }
        
        .profile-container { 
            background: white; padding: 30px; border-radius: 15px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); max-width: 700px;
        }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; }
        .form-group input, .form-group textarea { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;
        }

        .current-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 3px solid #27ae60; }

        .btn-update { 
            background: #27ae60; color: white; border: none; padding: 12px 30px; 
            border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem;
        }

        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Guide Panel</h2>
    <hr style="opacity: 0.2;">
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_bookings.php">My Trips</a>
    <a href="availability.php">Availability</a>
    <a href="edit_profile.php" style="background: #34495e; color: #27ae60;">Edit Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main-content">
    <h1>Edit Your Profile</h1>
    <?php echo $message; ?>

    <div class="profile-container">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Profile Picture</label>
                <img src="../images/<?php echo $guide['profile_img']; ?>" class="current-img" onerror="this.src='../images/default_guide.jpg';">
                <input type="file" name="image" accept="image/*">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($guide['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($guide['phone']); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Current Location</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($guide['location']); ?>" required>
            </div>

            <div class="form-group">
                <label>Professional Bio</label>
                <textarea name="bio" rows="5" required><?php echo htmlspecialchars($guide['bio']); ?></textarea>
            </div>

            <button type="submit" name="update_profile" class="btn-update">Save Changes</button>
        </form>
    </div>
</div>

</body>
</html>
