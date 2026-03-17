<?php
include("includes/admin_auth.php"); 
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

// --- 1. HANDLE USER DELETION ---
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    
    // Prevent the admin from accidentally deleting themselves if they are in the same table
    // (Though usually, admins are in a separate 'admins' table)
    $sql = "DELETE FROM users WHERE id='$id'";
    if (mysqli_query($link, $sql)) {
        header("Location: manage_users.php?msg=deleted");
    } else {
        header("Location: manage_users.php?msg=error");
    }
    exit();
}

// --- 2. FETCH ALL USERS ---
$query = "SELECT id, username, email, created_at FROM users ORDER BY created_at DESC";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | Admin Panel</title>
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .main-content { margin-left: 260px; padding: 40px; }
        
        .user-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th {
            text-align: left;
            padding: 15px;
            background: #f8f9fa;
            color: #7f8c8d;
            border-bottom: 2px solid #eee;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .user-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #2c3e50;
        }

        .user-icon {
            width: 35px;
            height: 35px;
            background: #e1f5fe;
            color: #039be5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 10px;
        }

        .date-badge {
            font-size: 0.8rem;
            color: #95a5a6;
        }

        .btn-delete {
            color: #e74c3c;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn-delete:hover {
            background: rgba(231, 76, 60, 0.1);
        }

        .msg {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 15px; }
            .user-table { display: block; overflow-x: auto; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="user-container">
        <div class="header-flex">
            <h1>Registered Travelers</h1>
            <span style="color: #7f8c8d;">Total: <strong><?php echo mysqli_num_rows($result); ?></strong></span>
        </div>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="msg success"><i class="fas fa-check-circle"></i> User account has been successfully removed.</div>
        <?php endif; ?>

        <table class="user-table">
            <thead>
                <tr>
                    <th>User Details</th>
                    <th>Email Address</th>
                    <th>Joined Date</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($user = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <div class="user-icon"><i class="fas fa-user"></i></div>
                            <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                        </div>
                    </td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <span class="date-badge">
                            <i class="far fa-calendar-alt"></i> 
                            <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="manage_users.php?delete=<?php echo $user['id']; ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone.');">
                           <i class="fas fa-user-minus"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #999;">No registered users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>