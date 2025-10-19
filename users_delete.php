<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


require 'connect.php';

$id = $_GET['id'] ?? null;

if ($id) {

    $stmt_select = mysqli_prepare($connect, "SELECT image FROM users WHERE id=?");
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);
    $user = mysqli_fetch_assoc($result_select);
    

    $stmt_delete = mysqli_prepare($connect, "DELETE FROM users WHERE id=?");
    mysqli_stmt_bind_param($stmt_delete, "i", $id);
    
    if (mysqli_stmt_execute($stmt_delete)) {

        if ($user && $user['image'] != 'default.jpg') {
            $file_path = "uploads/users/" . $user['image'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        echo "<script>alert('User Deleted!'); window.location='users.php';</script>";
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($connect);
    }
}
?>