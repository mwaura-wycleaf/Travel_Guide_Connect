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
    exit();
}

// 3. Handle Deletion
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    mysqli_query($link, "DELETE FROM contact_messages WHERE id='$id'");
    header("Location: view_messages.php");
    exit();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; margin: 0; }

        /* --- LOGO VISIBILITY FIX --- */
        header {
            left: 250px !important; /* Push header to the right of the 250px sidebar */
            width: calc(100% - 250px) !important; 
            box-sizing: border-box;
        }

        .main-content { 
            margin-left: 250px; 
            padding: 40px; 
            padding-top: 120px; /* Space for the header height */
            transition: margin-left 0.3s ease; 
        }
        
        .container-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        h1 { color: #2c3e50; margin-bottom: 30px; font-size: 1.8rem; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8f9fa; padding: 15px; text-align: left; color: #7f8c8d; border-bottom: 2px solid #eee; font-size: 0.9rem; }
        td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: top; }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        /* Match database values 'unread' and 'read' */
        .unread { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .read { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .msg-text { font-size: 0.9rem; color: #666; max-width: 400px; line-height: 1.5; margin-top: 5px; }
        
        .btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-right: 5px;
            display: inline-block;
            transition: 0.3s;
        }
        .btn-check { background: #27ae60; color: white; }
        .btn-delete { background: #f8d7da; color: #e74c3c; }
        .btn-delete:hover { background: #e74c3c; color: white; }
        .btn:hover { transform: translateY(-2px); }

        @media (max-width: 992px) {
            header { left: 0 !important; width: 100% !important; }
            .main-content { margin-left: 0; padding: 100px 15px 15px 15px; }
            table { display: block; overflow-x: auto; }
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
                    <th>Sender Info</th>
                    <th>Subject & Message</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="white-space: nowrap; font-size: 0.85rem; color: #7f8c8d;">
                        <?php echo date('d M, Y', strtotime($row['created_at'])); ?>
                    </td>
                    <td>
                        <strong style="color: #2c3e50;"><?php echo htmlspecialchars($row['name']); ?></strong><br>
                        <small style="color:#27ae60; font-weight: 600;"><?php echo htmlspecialchars($row['email']); ?></small>
                    </td>
                    <td>
                        <div style="font-weight: bold; color: #2c3e50;">
                            <?php echo htmlspecialchars($row['subject']); ?>
                        </div>
                        <div class="msg-text">
                            <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge <?php echo strtolower($row['status']); ?>">
                            <?php echo strtoupper($row['status']); ?>
                        </span>
                    </td>
                    <td style="white-space: nowrap;">
                        <?php if(strtolower($row['status']) == 'unread'): ?>
                            <a href="view_messages.php?mark_read=<?php echo $row['id']; ?>" class="btn btn-check" title="Mark as Read">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php endif; ?>
                        <a href="view_messages.php?delete=<?php echo $row['id']; ?>" 
                           class="btn btn-delete" 
                           title="Delete Message"
                           onclick="return confirm('Delete this message forever?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px; color: #999;">
                            <i class="fas fa-inbox fa-3x" style="margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                            No inquiries found in the database.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>