<?php
include("connect.php");

if(isset($_POST['save'])){
    $board = $_POST['boardname'];
    $number = $_POST['schoolnumber'];
    $name = $_POST['schoolname'];
    $level = $_POST['schoollevel'];
    $city = $_POST['city'];

    $sql = "INSERT INTO schools (`Board Name`, `School Number`, `School Name`, `School Level`, `City`)
            VALUES ('$board','$number','$name','$level','$city')";

    if(mysqli_query($connect, $sql)){
        echo "<script>alert('School Added!'); window.location='allschools.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add School</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("nav.php"); ?>

<div class="container">
<h2>Add New School</h2>

<form method="post">
    <div class="mb-3">
        <label>Board Name</label>
        <input type="text" name="boardname" class="form-control">
    </div>

    <div class="mb-3">
        <label>School Number</label>
        <input type="text" name="schoolnumber" class="form-control">
    </div>

    <div class="mb-3">
        <label>School Name</label>
        <input type="text" name="schoolname" class="form-control">
    </div>

    <div class="mb-3">
        <label>School Level</label>
        <input type="text" name="schoollevel" class="form-control">
    </div>

    <div class="mb-3">
        <label>City</label>
        <input type="text" name="city" class="form-control">
    </div>

    <input type="submit" name="save" value="Add School" class="btn btn-success">
</form>
</div>
</body>
</html>
