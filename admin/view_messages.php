<?php
// 1. CRITICAL: Logic must be at the very top with NO SPACES before <?php
include("includes/admin_auth.php"); 
include("../includes/db.php"); 

if (isset($_GET['mark_read'])) {
    $id = mysqli_real_escape_string($link, $_GET['mark_read']);
    mysqli_query($link, "UPDATE contact_messages SET status='read' WHERE id='$id'");
    header("Location: view_messages.php");
    exit(); 
}

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    mysqli_query($link, "DELETE FROM contact_messages WHERE id='$id'");
    header("Location: view_messages.php");
    exit();
}

$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($link, $sql);

include("../includes/header.php");
include("../includes/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Enquiries | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; margin: 0; }

         header {
            left: 250px !important; /* Push header content to the right of the sidebar */
            width: calc(100% - 250px) !important; /* Prevent header from overflowing right */
            box-sizing: border-box;
        }
        /* Content spacing */
        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            padding-top: 110px; 
        }
        
        .container-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        /* Table UI */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8f9fa; padding: 15px; text-align: left; color: #7f8c8d; border-bottom: 2px solid #eee; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 20px 15px; border-bottom: 1px solid #f9f9f9; vertical-align: top; }

        .status-badge { padding: 5px 12px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; }
        .unread { background: #fff3cd; color: #856404; }
        .read { background: #d4edda; color: #155724; }

        .btn { text-decoration: none; padding: 8px 10px; border-radius: 6px; display: inline-block; }
        .btn-check { color: #27ae60; background: #ebfaf0; margin-right: 8px; }
        .btn-delete { color: #e74c3c; background: #fff5f5; }

        @media (max-width: 992px) {
            header { left: 0 !important; width: 100% !important; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container-box">
        <h1><i class="fas fa-envelope-open-text"></i> Traveler Inquiries</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Sender</th>
                    <th>Subject & Message</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td style="color: #999; font-size: 0.8rem;"><?php echo date('d M, Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                            <small style="color:#27ae60;"><?php echo htmlspecialchars($row['email']); ?></small>
                        </td>
                        <td>
                            <div style="font-weight: 600;"><?php echo htmlspecialchars($row['subject']); ?></div>
                            <div style="color: #666; font-size: 0.9rem; margin-top: 5px;"><?php echo nl2br(htmlspecialchars($row['message'])); ?></div>
                        </td>
                        <td><span class="status-badge <?php echo strtolower($row['status']); ?>"><?php echo strtoupper($row['status']); ?></span></td>
                        <td style="text-align: right; white-space: nowrap;">
                            <?php if(strtolower($row['status']) == 'unread'): ?>
                                <a href="view_messages.php?mark_read=<?php echo $row['id']; ?>" class="btn btn-check"><i class="fas fa-check"></i></a>
                            <?php endif; ?>
                            <a href="view_messages.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this?');"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; padding:50px;">No records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>