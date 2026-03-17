<?php
include("includes/guide_auth.php"); 
include("../includes/db.php"); 

$guide_id = $_SESSION['guide_id'];
$message = "";

// Handle status update
if (isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $sql = "UPDATE guides SET is_available = '$new_status' WHERE id = '$guide_id'";
    
    if (mysqli_query($link, $sql)) {
        $message = "<div class='alert success'>Status updated successfully!</div>";
    } else {
        $message = "<div class='alert error'>Failed to update status.</div>";
    }
}

// Fetch current status
$res = mysqli_query($link, "SELECT is_available FROM guides WHERE id = '$guide_id'");
$guide_data = mysqli_fetch_assoc($res);
$current_status = $guide_data['is_available'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Availability | T-Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; margin: 0; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #2c3e50; color: white; padding: 20px; position: fixed; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; }
        
        .main-content { margin-left: 250px; padding: 40px; width: 100%; }
        
        .status-card { 
            max-width: 500px; background: white; padding: 30px; border-radius: 15px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center;
        }

        .status-indicator {
            width: 20px; height: 20px; border-radius: 50%; display: inline-block; margin-right: 10px;
        }
        .online { background: #27ae60; box-shadow: 0 0 10px #27ae60; }
        .offline { background: #e74c3c; box-shadow: 0 0 10px #e74c3c; }

        .toggle-btn {
            display: flex; justify-content: center; gap: 10px; margin-top: 25px;
        }

        .radio-label {
            padding: 15px 25px; border: 2px solid #ddd; border-radius: 10px;
            cursor: pointer; transition: 0.3s; font-weight: bold;
        }

        input[type="radio"] { display: none; }
        
        input[value="1"]:checked + .radio-label { border-color: #27ae60; color: #27ae60; background: #e8f5e9; }
        input[value="0"]:checked + .radio-label { border-color: #e74c3c; color: #e74c3c; background: #fff0f0; }

        .btn-save {
            margin-top: 30px; background: #2c3e50; color: white; border: none;
            padding: 12px 40px; border-radius: 30px; cursor: pointer; font-weight: bold;
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
    <a href="availability.php" style="background: #34495e; color: #27ae60;">Availability</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main-content">
    <h1>Manage Your Availability</h1>
    <?php echo $message; ?>

    <div class="status-card">
        <h3>Current Status: 
            <span class="status-indicator <?php echo $current_status ? 'online' : 'offline'; ?>"></span>
            <?php echo $current_status ? 'Available' : 'Busy / On Trip'; ?>
        </h3>
        <p style="color: #7f8c8d; font-size: 0.9rem;">Updating your status helps the Admin know when to assign you to new travelers.</p>

        <form method="POST">
            <div class="toggle-btn">
                <label>
                    <input type="radio" name="status" value="1" <?php if($current_status) echo 'checked'; ?>>
                    <div class="radio-label">AVAILABLE</div>
                </label>
                <label>
                    <input type="radio" name="status" value="0" <?php if(!$current_status) echo 'checked'; ?>>
                    <div class="radio-label">BUSY</div>
                </label>
            </div>
            <button type="submit" name="update_status" class="btn-save">Update My Status</button>
        </form>
    </div>
</div>

</body>
</html>