<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


require 'connect.php';
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
    <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <?php if (!empty($_SESSION['image'])): ?>
        <p><img src="uploads/users/<?php echo htmlspecialchars($_SESSION['image']); ?>" alt="Profile Image" width="100" style="border-radius: 50%;"></p>
    <?php endif; ?>
    
    <h3 class="mt-4">Management Links</h3>
    <hr>
    <p>
        <a href="users.php" class="btn btn-info">Manage Users (CRUD)</a> | 
        <a href="schools_list.php" class="btn btn-info">Manage Schools</a> |
        <a href="index.php" class="btn btn-secondary">Public Schools Index</a>
    </p>
    <p class="mt-4">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </p>
</body>
</html>