<?php
include("../database/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");
?>

<div class="main">
<h1>Manage Users</h1>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th></tr>
<?php
$result = mysqli_query($conn,"SELECT * FROM users");
while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
    <td>".$row['id']."</td>
    <td>".$row['name']."</td>
    <td>".$row['email']."</td>
    </tr>";
}
?>
</table>
</div>
</body>
</html>