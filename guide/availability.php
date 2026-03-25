<?php
// 1. Always start the session first
session_start();

// 2. Correct the paths to your includes
include("../includes/db.php"); 

// 3. Security Check
if(!isset($_SESSION['guide_id'])){
    header("Location: login_guide.php");
    exit();
}

$guide_id = $_SESSION['guide_id'];
$message = "";

// Handle status update
if (isset($_POST['update_status'])) {
    $new_status = $_POST['status']; // '1' or '0'
    
    // Use a prepared statement for security
    $stmt = $link->prepare("UPDATE guides SET is_available = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $guide_id);
    
    if ($stmt->execute()) {
        $message = "<div class='alert success'><i class='fas fa-check-circle'></i> Status updated successfully!</div>";
    } else {
        $message = "<div class='alert error'><i class='fas fa-exclamation-triangle'></i> Failed to update status.</div>";
    }
    $stmt->close();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Availability | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; display: flex; }
        
        /* Sidebar Styles */
        .sidebar { 
            width: 250px; 
            height: 100vh; 
            background: #2c3e50; 
            color: white; 
            padding: 25px; 
            position: fixed; 
            left: 0;
            top: 0;
        }
        .sidebar h2 { font-size: 1.4rem; margin-bottom: 20px; color: #27ae60; text-align: center; }
        .sidebar a { display: block; color: #bdc3c7; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; transition: 0.3s; }
        .sidebar a:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar a.active { background: #34495e; color: #27ae60; font-weight: bold; }
        
        /* Main Content Centering Logic */
        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            width: calc(100% - 250px); 
            display: flex;
            flex-direction: column;
            align-items: center; /* Centers horizontally */
            min-height: 100vh;
        }

        .content-container {
            width: 100%;
            max-width: 600px; /* Tighter width for the status card */
            text-align: center;
        }

        h1 { color: #2c3e50; margin-bottom: 30px; font-size: 2rem; }
        
        .status-card { 
            background: white; 
            padding: 50px 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
        }

        .status-indicator {
            width: 18px; height: 18px; border-radius: 50%; display: inline-block; margin-right: 10px;
        }
        .online { background: #27ae60; box-shadow: 0 0 12px rgba(39, 174, 96, 0.4); }
        .offline { background: #e74c3c; box-shadow: 0 0 12px rgba(231, 76, 60, 0.4); }

        .toggle-btn {
            display: flex; justify-content: center; gap: 20px; margin-top: 35px;
        }

        .radio-label {
            display: block; padding: 18px 35px; border: 2px solid #eef0f2; border-radius: 15px;
            cursor: pointer; transition: 0.3s; font-weight: bold; color: #7f8c8d;
        }

        input[type="radio"] { display: none; }
        
        input[value="1"]:checked + .radio-label { 
            border-color: #27ae60; 
            color: #27ae60; 
            background: rgba(39, 174, 96, 0.05); 
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.1);
        }
        input[value="0"]:checked + .radio-label { 
            border-color: #e74c3c; 
            color: #e74c3c; 
            background: rgba(231, 76, 60, 0.05); 
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.1);
        }

        .btn-save {
            margin-top: 40px; background: #2c3e50; color: white; border: none;
            padding: 16px 60px; border-radius: 35px; cursor: pointer; font-weight: bold;
            font-size: 1rem; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-save:hover { background: #27ae60; transform: translateY(-3px); box-shadow: 0 6px 15px rgba(39, 174, 96, 0.2); }

        .alert { padding: 15px; border-radius: 12px; margin-bottom: 25px; width: 100%; box-sizing: border-box; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Guide Panel</h2>
    <hr style="opacity: 0.1; margin-bottom: 20px;">
    <a href="dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
    <a href="manage_bookings.php"><i class="fas fa-suitcase"></i> My Trips</a>
    <a href="availability.php" class="active"><i class="fas fa-calendar-check"></i> Availability</a>
    <a href="reviews.php"><i class="fas fa-star"></i> Reviews</a>
    <a href="edit_profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a>
    <a href="../includes/guide_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="content-container">
        <h1>Manage Your Availability</h1>
        
        <?php echo $message; ?>

        <div class="status-card">
            <h2 style="color: #2c3e50; margin-bottom: 12px; display: flex; align-items: center; justify-content: center;">
                <span class="status-indicator <?php echo $current_status ? 'online' : 'offline'; ?>"></span>
                <?php echo $current_status ? 'Accepting Tourists' : 'Not Available'; ?>
            </h2>
            <p style="color: #7f8c8d; font-size: 1rem;">Update your status so tourists know when to book your services.</p>

            <form method="POST">
                <div class="toggle-btn">
                    <label>
                        <input type="radio" name="status" value="1" <?php if($current_status == 1) echo 'checked'; ?>>
                        <div class="radio-label"><i class="fas fa-check-circle"></i> AVAILABLE</div>
                    </label>
                    <label>
                        <input type="radio" name="status" value="0" <?php if($current_status == 0) echo 'checked'; ?>>
                        <div class="radio-label"><i class="fas fa-minus-circle"></i> BUSY</div>
                    </label>
                </div>
                <button type="submit" name="update_status" class="btn-save">Save New Status</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>