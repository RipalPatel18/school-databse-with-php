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
<head><meta charset="utf-8"><title>Manage Schools</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <h1>Manage Schools</h1>
  <p><a href="dashboard.php">Dashboard</a> | <a href="addschool.php">Add New School</a></p>
  <hr>
  <table class="table table-striped">
    <thead>
        <tr>
            <th>School Name</th>
            <th>City</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $query = 'SELECT id, `School Name`, City FROM schools ORDER BY `School Name`';
        $schools = mysqli_query($connect, $query);
        while ($school = mysqli_fetch_assoc($schools)) {
          echo '<tr>';
          echo '<td>' . htmlspecialchars($school['School Name']) . '</td>';
          echo '<td>' . htmlspecialchars($school['City']) . '</td>';
          echo '<td>';
          echo '<a href="editschool.php?id=' . $school['id'] . '" class="btn btn-sm btn-warning">Edit</a>';
          echo ' <a href="deleteschool.php?id=' . $school['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>';
          echo '</td>';
          echo '</tr>';
        }
    ?>
    </tbody>
  </table>
</body>
</html>