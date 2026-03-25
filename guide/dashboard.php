<?php
session_start();

// Protect page
if(!isset($_SESSION['guide_id'])){
    header("Location: guide_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Guide Dashboard | T-Connect</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), 
                        url('../images/guide_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .container {
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
        }

        .logout-btn {
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            background: #e74c3c;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: 0.3s;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.18);
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .welcome {
            margin-bottom: 25px;
            font-size: 18px;
            opacity: 0.9;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Guide Dashboard</h1>
        <a href="../includes/guide_logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="welcome">
        Welcome, <?php echo $_SESSION['guide_name']; ?> 👋
    </div>

    <div class="cards">

        <div class="card">
            <h3>Manage Availability</h3>
            <a href="availability.php">Open</a>
        </div>

        <div class="card">
            <h3>View Bookings</h3>
            <a href="manage_bookings.php">Open</a>
        </div>

        <div class="card">
            <h3>Reviews</h3>
            <a href="reviews.php">Open</a>
        </div>

        <div class="card">
            <h3>Edit Profile</h3>
            <a href="edit_profile.php">Open</a>
        </div>

    </div>

</div>

</body>
</html>
