<?php
include("includes/admin_auth.php"); 
include("../includes/db.php"); 
include("../includes/header.php");
include("../includes/sidebar.php");

$message = "";

// --- 1. HANDLE ADD GUIDE ---
if (isset($_POST['add_guide'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $location = mysqli_real_escape_string($link, $_POST['location']);
    $spec = mysqli_real_escape_string($link, $_POST['specialization']);
    $exp = mysqli_real_escape_string($link, $_POST['experience']);
    $bio = mysqli_real_escape_string($link, $_POST['bio']);

    // Image Upload
    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $target_file = "../images/" . $img_name;

    if (move_uploaded_file($tmp_name, $target_file)) {
        $sql = "INSERT INTO guides (name, email, phone, location, specialization, experience_years, bio, profile_img) 
                VALUES ('$name', '$email', '$phone', '$location', '$spec', '$exp', '$bio', '$img_name')";
        
        if (mysqli_query($link, $sql)) {
            $message = "<div class='alert alert-success'>New guide registered successfully!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Error uploading profile photo.</div>";
    }
}

// --- 2. HANDLE DELETE ---
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($link, $_GET['delete']);
    // Optional: Delete the image file from server too
    mysqli_query($link, "DELETE FROM guides WHERE id='$id'");
    header("Location: manage_guides.php");
}

// --- 3. FETCH GUIDES ---
$result = mysqli_query($link, "SELECT * FROM guides ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Guides | Admin</title>
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .main-content { margin-left: 260px; padding: 40px; }
        
        .form-section {
            background: white; padding: 25px; border-radius: 15px; margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .input-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        
        input, select, textarea {
            width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 8px;
        }

        .btn-submit {
            background: #27ae60; color: white; border: none; padding: 12px 30px;
            border-radius: 8px; cursor: pointer; margin-top: 20px; font-weight: 600;
        }

        /* Guide List Styling */
        .guide-list { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; border-bottom: 2px solid #eee; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        
        .guide-thumb { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; }
        .spec-label { background: #e8f5e9; color: #2e7d32; padding: 3px 8px; border-radius: 5px; font-size: 0.8rem; }
        
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        
        .delete-link { color: #e74c3c; text-decoration: none; }

        @media (max-width: 768px) { .main-content { margin-left: 0; padding: 15px; } }
    </style>
</head>
<body>

<div class="main-content">
    <h1>Manage Local Guides</h1>
    <?php echo $message; ?>

    <div class="form-section">
        <h3>Register a New Guide</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="input-grid">
                <div>
                    <label>Full Name</label>
                    <input type="text" name="name" required>
                </div>
                <div>
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="07..." required>
                </div>
            </div>

            <div class="input-grid" style="margin-top: 15px;">
                <div>
                    <label>Location</label>
                    <input type="text" name="location" placeholder="e.g. Nyeri" required>
                </div>
                <div>
                    <label>Specialization</label>
                    <select name="specialization" required>
                        <option value="Hiking">Hiking & Trekking</option>
                        <option value="Wildlife">Wildlife Safaris</option>
                        <option value="Culture">Cultural Tours</option>
                        <option value="Coastal">Coastal/Water Sports</option>
                    </select>
                </div>
                <div>
                    <label>Years of Experience</label>
                    <input type="number" name="experience" min="1" required>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <label>Brief Bio</label>
                <textarea name="bio" rows="3" required></textarea>
            </div>

            <div style="margin-top: 15px;">
                <label>Profile Picture</label>
                <input type="file" name="image" accept="image/*" required>
            </div>

            <button type="submit" name="add_guide" class="btn-submit">Add Guide to Platform</button>
        </form>
    </div>

    <div class="guide-list">
        <h3>Active Professional Guides</h3>
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Expertise</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><img src="../images/<?php echo $row['profile_img']; ?>" class="guide-thumb" onerror="this.src='../images/default_guide.jpg';"></td>
                    <td><strong><?php echo htmlspecialchars($row['name']); ?></strong><br><small><?php echo $row['email']; ?></small></td>
                    <td><span class="spec-label"><?php echo $row['specialization']; ?></span></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td>
                        <a href="manage_guides.php?delete=<?php echo $row['id']; ?>" 
                           class="delete-link" onclick="return confirm('Remove this guide?');">
                           <i class="fas fa-trash-alt"></i> Delete
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