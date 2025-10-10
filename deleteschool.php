<?php
include("connect.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM schools WHERE id=$id";
    if(mysqli_query($connect, $sql)){
        echo "<script>alert('School Deleted!'); window.location='allschools.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($connect);
    }
}
?>
