<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("connect.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $stmt = mysqli_prepare($connect, "DELETE FROM schools WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)){
        echo "<script>alert('School Deleted!'); window.location='allschools.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($connect);
    }
}
?>