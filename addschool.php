<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


require('connect.php');

?>

<!DOCTYPE html>
<html>
<head>
<title>Add School</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Add School</h1>
    <p><a href="dashboard.php">Dashboard</a></p>
    <hr>
    <p>... School creation form content ...</p>
</div>
</body>
</html>