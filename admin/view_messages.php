<?php
// 1. Security Gatekeeper
include("includes/admin_auth.php"); 
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

// 2. Handle Marking as Read
if (isset($_GET['mark_read'])) {
    $id = mysqli_real_escape_string($link, $_GET['mark_read']);
    mysqli_query($link, "UPDATE contact_messages SET status='read' WHERE id='$id'");
    header("Location: view_messages.php");
}

// 3. Handle Deletion
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    mysqli_query($link, "DELETE FROM contact_messages WHERE id='$id'");
    header("Location: view_messages.php");
}

// 4. Fetch Messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Enquiries | Admin</title>
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .main-content { margin-left: 260px; padding: 40px; }
        
        .container-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        h1 { color: #2c3e50; margin-bottom: 30px; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8f9fa; padding: 15px; text-align: left; color: #7f8c8d; border-bottom: 2px solid #eee; }
        td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: top; }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .unread { background: #fff3cd; color: #856404; }
        .read { background: #d4edda; color: #155724; }

        .msg-text { font-size: 0.9rem; color: #666; max-width: 400px; line-height: 1.5; }
        
        .btn {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 0.85rem;
            margin-right: 5px;
            display: inline-block;
        }
        .btn-check { background: #27ae60; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .btn:hover { opacity: 0.8; }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 15px; }
            table { display: block; overflow-x: auto; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container-box">
        <h1>Traveler Inquiries</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Sender Info</th>
                    <th>Subject & Message</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="white-space: nowrap;">
                        <?php echo date('d M, Y', strtotime($row['created_at'])); ?>
                    </td>
                    <td>
                        <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                        <small style="color:#27ae60;"><?php echo htmlspecialchars($row['email']); ?></small>
                    </td>
                    <td>
                        <div style="font-weight: bold; color: #2c3e50; margin-bottom: 5px;">
                            <?php echo htmlspecialchars($row['subject']); ?>
                        </div>
                        <div class="msg-text">
                            <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge <?php echo $row['status']; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td style="white-space: nowrap;">
                        <?php if($row['status'] == 'unread'): ?>
                            <a href="view_messages.php?mark_read=<?php echo $row['id']; ?>" class="btn btn-check" title="Mark as Read">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php endif; ?>
                        <a href="view_messages.php?delete=<?php echo $row['id']; ?>" 
                           class="btn btn-delete" 
                           onclick="return confirm('Delete this message forever?');">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 50px; color: #999;">
                            No messages found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>