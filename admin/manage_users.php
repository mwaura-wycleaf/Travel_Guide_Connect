<?php
// 1. LOGIC FIRST - Before any HTML output
include("includes/admin_auth.php"); 
include("../includes/db.php"); 

// --- HANDLE USER DELETION ---
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    
    $sql = "DELETE FROM users WHERE id='$id'";
    if (mysqli_query($link, $sql)) {
        header("Location: manage_users.php?msg=deleted");
    } else {
        header("Location: manage_users.php?msg=error");
    }
    exit();
}

// --- FETCH ALL USERS ---
$query = "SELECT id, name, email, created_at FROM users ORDER BY created_at DESC";
$result = mysqli_query($link, $query);

// 2. START THE UI
include("../includes/header.php");
include("../includes/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8fafb; font-family: 'Poppins', sans-serif; margin: 0; }

        /* --- LAYOUT FIXES (Based on your screenshot) --- */
      header {
            left: 250px !important; /* Push header to the right of the 250px sidebar */
            width: calc(100% - 250px) !important; 
            box-sizing: border-box;
        }

        .main-content { 
            margin-left: 260px; 
            padding: 40px; 
            padding-top: 110px; /* Space for the top header bar */
            min-height: 100vh;
        }

        /* --- CARD STYLING --- */
        .user-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            max-width: 1100px;
            margin: 0 auto;
        }

        .table-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .table-header h2 { margin: 0; font-size: 1.8rem; color: #000; font-weight: 700; }
        .table-header i { font-size: 1.5rem; color: #000; }

        /* --- TABLE STYLING --- */
        .user-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        
        .user-table th {
            text-align: left;
            padding: 12px 15px;
            color: #888;
            font-weight: 500;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
            text-transform: capitalize;
        }

        .user-table td {
            padding: 20px 15px;
            border-bottom: 1px solid #f9f9f9;
            color: #444;
            vertical-align: middle;
        }

        .user-info { display: flex; align-items: center; gap: 12px; }
        .user-initials {
            width: 35px; height: 35px;
            background: #e1f5fe; color: #039be5;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; font-weight: bold; font-size: 0.8rem;
        }
        
        /* Action Buttons */
        .btn-delete {
            color: #e74c3c;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
            transition: 0.2s;
            font-size: 0.9rem;
        }
        .btn-delete:hover { background: #fff5f5; }

        /* Alert Messages */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            font-size: 0.95rem;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        @media (max-width: 992px) {
            header { left: 0 !important; width: 100% !important; }
            .main-content { margin-left: 0; padding: 20px; padding-top: 90px; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="user-container">
        
        <div class="table-header">
            <i class="fas fa-users"></i>
            <h2>Manage Registered Travelers</h2>
        </div>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert success">User account has been successfully removed.</div>
        <?php endif; ?>

        <table class="user-table">
            <thead>
                <tr>
                    <th>Traveler</th>
                    <th>Email Address</th>
                    <th>Joined Date</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($user = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-initials">
                                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                    </div>
                                    <strong><?php echo htmlspecialchars($user['name']); ?></strong>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span style="color: #888; font-size: 0.85rem;">
                                    <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="manage_users.php?delete=<?php echo $user['id']; ?>" 
                                   class="btn-delete" 
                                   onclick="return confirm('Permanently delete this user?')">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #999;">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>