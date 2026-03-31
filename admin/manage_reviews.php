<?php
include("includes/admin_auth.php"); 
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

$message = "";

// --- 1. HANDLE DELETE ---
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    if (mysqli_query($link, "DELETE FROM reviews WHERE id='$id'")) {
        $message = "<div class='alert alert-success'>Review removed.</div>";
    }
}

// --- 2. THE FIXED QUERY ---
// We join on 'user_name' from reviews and 'name' from users
$sql = "SELECT 
            r.*, 
            u.name AS traveler_name, 
            a.name AS attraction_name 
        FROM reviews r 
        JOIN users u ON r.user_name = u.name 
        JOIN attractions a ON r.attraction_id = a.id 
        ORDER BY r.created_at DESC";

$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reviews | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; margin: 0; }

        /* --- LOGO VISIBILITY FIX --- */
        header {
            left: 250px !important;
            width: calc(100% - 250px) !important;
            box-sizing: border-box;
        }

        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            padding-top: 120px; 
        }
        
        .container-box {
            background: white; padding: 30px; border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #eee; color: #7f8c8d; }
        td { padding: 15px; border-bottom: 1px solid #eee; }

        .stars { color: #f1c40f; font-size: 0.9rem; }
        .btn-delete { color: #e74c3c; text-decoration: none; font-weight: bold; }
        
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        @media (max-width: 992px) {
            header { left: 0 !important; width: 100% !important; }
            .main-content { margin-left: 0; padding: 100px 15px; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container-box">
        <h1><i class="fas fa-star"></i> Manage User Reviews</h1>
        
        <?php echo $message; ?>

        <table>
            <thead>
                <tr>
                    <th>Traveler</th>
                    <th>Destination</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['traveler_name']); ?></strong></td>
                        <td><span style="color: #27ae60;"><?php echo htmlspecialchars($row['attraction_name']); ?></span></td>
                        <td class="stars">
                            <?php echo str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']); ?>
                        </td>
                        <td style="font-style: italic; color: #666;">"<?php echo htmlspecialchars($row['comment']); ?>"</td>
                        <td>
                            <a href="manage_reviews.php?delete=<?php echo $row['id']; ?>" 
                               class="btn-delete" onclick="return confirm('Delete this review?');">
                               <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #999;">No reviews found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>