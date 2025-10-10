<?php
include("connect.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM schools WHERE id=$id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])){
    $board = $_POST['boardname'];
    $number = $_POST['schoolnumber'];
    $name = $_POST['schoolname'];
    $level = $_POST['schoollevel'];
    $city = $_POST['city'];

    $sql = "UPDATE schools SET 
            `Board Name`='$board',
            `School Number`='$number',
            `School Name`='$name',
            `School Level`='$level',
            `City`='$city'
            WHERE id=$id";

    if(mysqli_query($connect, $sql)){
        echo "<script>alert('School Updated!'); window.location='allschools.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit School</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("nav.php"); ?>

<div class="container">
<h2>Edit School</h2>

<form method="post">
    <div class="mb-3">
        <label>Board Name</label>
        <input type="text" name="boardname" class="form-control" value="<?php echo $row['Board Name']; ?>">
    </div>

    <div class="mb-3">
        <label>School Number</label>
        <input type="text" name="schoolnumber" class="form-control" value="<?php echo $row['School Number']; ?>">
    </div>

    <div class="mb-3">
        <label>School Name</label>
        <input type="text" name="schoolname" class="form-control" value="<?php echo $row['School Name']; ?>">
    </div>

    <div class="mb-3">
        <label>School Level</label>
        <input type="text" name="schoollevel" class="form-control" value="<?php echo $row['School Level']; ?>">
    </div>

    <div class="mb-3">
        <label>City</label>
        <input type="text" name="city" class="form-control" value="<?php echo $row['City']; ?>">
    </div>

    <input type="submit" name="update" value="Update School" class="btn btn-primary">
</form>
</div>
</body>
</html>
