<?php
include("../database/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// Add guide
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    mysqli_query($conn,"INSERT INTO guides(name,phone,location) VALUES('$name','$phone','$location')");
}

// Delete guide
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM guides WHERE id=$id");
    header("Location: manage_guides.php");
    exit();
}
?>

<div class="main">
<h1>Manage Guides</h1>

<form method="POST">
<input type="text" name="name" placeholder="Guide Name" required>
<input type="text" name="phone" placeholder="Phone" required>
<input type="text" name="location" placeholder="Location" required>
<button name="add">Add Guide</button>
</form>

<table>
<tr><th>ID</th><th>Name</th><th>Phone</th><th>Location</th><th>Action</th></tr>
<?php
$result = mysqli_query($conn,"SELECT * FROM guides");
while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
    <td>".$row['id']."</td>
    <td>".$row['name']."</td>
    <td>".$row['phone']."</td>
    <td>".$row['location']."</td>
    <td><a href='manage_guides.php?delete=".$row['id']."'>Delete</a></td>
    </tr>";
}
?>
</table>
</div>
</body>
</html>