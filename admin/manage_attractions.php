<?php
include("includes/admin_auth.php"); 
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

$message = "";

// --- 1. HANDLE ADD ATTRACTION ---
if (isset($_POST['add_attraction'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $dry = isset($_POST['is_dry_season']) ? 1 : 0;
    $long = isset($_POST['is_long_rains']) ? 1 : 0;
    $short = isset($_POST['is_short_rains']) ? 1 : 0;

    // Image Upload Logic
    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $folder = "../images/" . $img_name;

    if (move_uploaded_file($tmp_name, $folder)) {
        $sql = "INSERT INTO attractions (name, location, description, img_url, is_dry_season, is_long_rains, is_short_rains) 
                VALUES ('$name', '$location', '$description', '$img_name', '$dry', '$long', '$short')";
        if (mysqli_query($link, $sql)) {
            $message = "<p class='alert alert-success'>Attraction added successfully!</p>";
        }
    } else {
        $message = "<p class='alert alert-danger'>Failed to upload image.</p>";
    }
}

// --- 2. HANDLE DELETE ---
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    mysqli_query($link, "DELETE FROM attractions WHERE id='$id'");
    header("Location: manage_attractions.php");
}

// --- 3. FETCH ATTRACTIONS ---
$result = mysqli_query($link, "SELECT * FROM attractions ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Attractions | Admin</title>
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .main-content { margin-left: 260px; padding: 40px; }
        
        .form-container {
            background: white; padding: 25px; border-radius: 15px; margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        input, textarea, select {
            width: 100%; padding: 12px; margin-top: 5px; border-radius: 8px;
            border: 1px solid #ddd; font-family: inherit;
        }

        .checkbox-group { display: flex; gap: 15px; margin-top: 15px; align-items: center; }
        .checkbox-group label { font-size: 0.85rem; }

        .btn-add {
            background: #27ae60; color: white; border: none; padding: 12px 25px;
            border-radius: 8px; cursor: pointer; margin-top: 15px; font-weight: 600;
        }

        /* Table Styles */
        .table-container { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #eee; color: #7f8c8d; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        
        .img-preview { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; }
        
        .alert { padding: 10px; border-radius: 8px; margin-bottom: 15px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }

        .btn-del { color: #e74c3c; text-decoration: none; font-weight: bold; }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 15px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <h1>Manage Destinations</h1>
    <?php echo $message; ?>

    <div class="form-container">
        <h3>Add New Attraction</h3>
        <form action="manage_attractions.php" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div>
                    <label>Destination Name</label>
                    <input type="text" name="name" placeholder="e.g. Maasai Mara" required>
                </div>
                <div>
                    <label>Location (County/City)</label>
                    <input type="text" name="location" placeholder="e.g. Narok" required>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Tell travelers what's special about this place..." required></textarea>
            </div>

            <div class="form-grid" style="margin-top: 15px;">
                <div>
                    <label>Upload Image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="is_dry_season"> Dry Season</label>
                    <label><input type="checkbox" name="is_long_rains"> Long Rains</label>
                    <label><input type="checkbox" name="is_short_rains"> Short Rains</label>
                </div>
            </div>

            <button type="submit" name="add_attraction" class="btn-add">Save Destination</button>
        </form>
    </div>

    <div class="table-container">
        <h3>Current Destinations</h3>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><img src="../images/<?php echo $row['img_url']; ?>" class="img-preview"></td>
                    <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td>
                        <a href="manage_attractions.php?delete=<?php echo $row['id']; ?>" 
                           class="btn-del" onclick="return confirm('Remove this destination?');">
                           <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>