<?php
include("../database/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

// Approve/cancel
if(isset($_GET['approve'])){
    $id=$_GET['approve'];
    mysqli_query($conn,"UPDATE bookings SET status='Approved' WHERE id=$id");
}
if(isset($_GET['cancel'])){
    $id=$_GET['cancel'];
    mysqli_query($conn,"UPDATE bookings SET status='Cancelled' WHERE id=$id");
}
?>

<div class="main">
<h1>Manage Bookings</h1>
<table>
<tr><th>ID</th><th>User</th><th>Guide</th><th>Destination</th><th>Status</th><th>Action</th></tr>
<?php
$result = mysqli_query($conn,"SELECT * FROM bookings");
while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
    <td>".$row['id']."</td>
    <td>".$row['user']."</td>
    <td>".$row['guide']."</td>
    <td>".$row['destination']."</td>
    <td>".$row['status']."</td>
    <td>
        <a href='manage_bookings.php?approve=".$row['id']."'>Approve</a> | 
        <a href='manage_bookings.php?cancel=".$row['id']."'>Cancel</a>
    </td>
    </tr>";
}
?>
</table>
</div>
</body>
</html>