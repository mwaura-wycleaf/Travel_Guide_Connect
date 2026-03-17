<?php
include("includes/admin_auth.php"); 
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

// --- 1. HANDLE DELETION ---
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    mysqli_query($link, "DELETE FROM reviews WHERE id='$id'");
    header("Location: manage_reviews.php?msg=deleted");
    exit();
}

// --- 2. FETCH REVIEWS WITH DETAILS ---
$sql = "SELECT r.*, u.username, a.name AS attraction_name 
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        JOIN attractions a ON r.attraction_id = a.id
        ORDER BY r.created_at DESC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reviews | Admin</title>
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .main-content { margin-left: 260px; padding: 40px; }
        
        .review-container {
            background: white; padding: 30px; border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .review-card {
            border-bottom: 1px solid #eee;
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .review-card:last-child { border-bottom: none; }

        .star-rating { color: #f1c40f; margin-bottom: 5px; }
        
        .review-meta { font-size: 0.85rem; color: #7f8c8d; margin-bottom: 8px; }
        .review-meta strong { color: #2c3e50; }
        
        .review-text { font-style: italic; color: #555; line-height: 1.6; }

        .btn-delete {
            background: #fff0f0;
            color: #e74c3c;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-delete:hover { background: #e74c3c; color: white; }

        .tag {
            background: #e1f5fe;
            color: #039be5;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-left: 5px;
        }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 15px; }
            .review-card { flex-direction: column; }
            .btn-delete { margin-top: 15px; width: 100%; text-align: center; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="review-container">
        <h1>User Reviews & Feedback</h1>

        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="review-card">
                    <div>
                        <div class="star-rating">
                            <?php 
                            for($i=1; $i<=5; $i++){
                                echo ($i <= $row['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                            }
                            ?>
                        </div>
                        
                        <div class="review-meta">
                            By <strong><?php echo htmlspecialchars($row['username']); ?></strong> 
                            for <span class="tag"><?php echo htmlspecialchars($row['attraction_name']); ?></span>
                            on <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                        </div>

                        <div class="review-text">
                            "<?php echo htmlspecialchars($row['comment']); ?>"
                        </div>
                    </div>

                    <a href="manage_reviews.php?delete=<?php echo $row['id']; ?>" 
                       class="btn-delete" 
                       onclick="return confirm('Delete this review permanently?');">
                        <i class="fas fa-trash-alt"></i> Remove
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; padding: 50px; color:#999;">No reviews found yet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>