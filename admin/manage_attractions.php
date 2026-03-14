<?php
include("../database/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

if(isset($_POST['add'])){
    $name=$_POST['name'];
    $location=$_POST['location'];
    $category=$_POST['category'];
    $image=$_FILES['image']['name'];
    $temp=$_FILES['image']['tmp_name'];
    move_uploaded_file($temp,"../images/".$image);
    mysqli_query($conn,"INSERT INTO attractions(name,location,category,image) VALUES('$name','$location','$category','$image')");
}

// Delete attraction
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM attractions WHERE id=$id");
    header("Location: manage_attractions.php");
    exit();
}
?>

<div class="main">
<h1>Manage Attractions</h1>

<form method="POST" enctype="multipart/form-data">
<input type="text" name="name" placeholder="Attraction Name" required>
<input type="text" name="location" placeholder="Location" required>
<input type="text" name="category" placeholder="Category" required>
<input type="file" name="image" required>
<button name="add">Add Attraction</button>
</form>

<table>
<tr><th>Name</th><th>Location</th><th>Category</th><th>Image</th><th>Action</th></tr>
<?php
$result = mysqli_query($conn,"SELECT * FROM attractions");
while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
    <td>".$row['name']."</td>
    <td>".$row['location']."</td>
    <td>".$row['category']."</td>
    <td><img src='../images/".$row['image']."' width='60'></td>
    <td><a href='manage_attractions.php?delete=".$row['id']."'>Delete</a></td>
    </tr>";
}
?>
</table>
</div>
</body>
</html>