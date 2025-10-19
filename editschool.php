<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("connect.php");

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ERROR: School ID not provided.");
}


$stmt = mysqli_prepare($connect, "SELECT * FROM schools WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("ERROR: School not found.");
}

if (isset($_POST['update'])) {
    $board = $_POST['boardname'];
    $number = $_POST['schoolnumber'];
    $name = $_POST['schoolname'];
    $level = $_POST['schoollevel'];
    $city = $_POST['city'];


    $stmt = mysqli_prepare($connect, "UPDATE schools SET `Board Name`=?, `School Number`=?, `School Name`=?, `School Level`=?, `City`=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $board, $number, $name, $level, $city, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('School Updated!'); window.location='allschools.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>