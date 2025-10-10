<?php
include("connect.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>All Schools</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("nav.php"); ?>

<div class="container">
<h2>All Schools</h2>

<?php
$sql = "SELECT * FROM schools LIMIT 50";
$result = mysqli_query($connect, $sql);

if(mysqli_num_rows($result) > 0){
    echo "<table class='table table-bordered'>";
    echo "<tr><th>ID</th><th>School Name</th><th>Board Name</th><th>City</th><th>Level</th><th>Action</th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['School Name']."</td>";
        echo "<td>".$row['Board Name']."</td>";
        echo "<td>".$row['City']."</td>";
        echo "<td>".$row['School Level']."</td>";
        echo "<td>
        <a href='editschool.php?id=".$row['id']."' class='btn btn-primary btn-sm'>Edit</a>
        <a href='deleteschool.php?id=".$row['id']."' class='btn btn-danger btn-sm'>Delete</a>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No schools found.";
}
?>
</div>
</body>
</html>
