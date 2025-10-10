<?php
$connect = mysqli_connect("localhost", "root", "", "schools");

if(!$connect){
    die("Connection failed: " . mysqli_connect_error());
}
?>
