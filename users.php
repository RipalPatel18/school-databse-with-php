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
<head>
<title>Manage Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h1>Manage Users</h1>
    <p><a href="dashboard.php">Dashboard</a> | <a href="users_create.php" class="btn btn-success">Create New User</a></p>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT id, name, email, image FROM users ORDER BY name ASC";
            $result = mysqli_query($connect, $query);

            while ($user = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td><img src="uploads/users/' . htmlspecialchars($user['image']) . '" alt="Profile" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"></td>';
                echo '<td>' . htmlspecialchars($user['name']) . '</td>';
                echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                echo '<td>';
                echo '<a href="users_edit.php?id=' . $user['id'] . '" class="btn btn-sm btn-warning">Edit</a> ';
                echo '<a href="users_delete.php?id=' . $user['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete ' . htmlspecialchars($user['name']) . '?\')">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>