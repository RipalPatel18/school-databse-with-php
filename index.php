<?php

session_start();
require('connect.php');
$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Schools Index</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>All Schools (Public Index)</h1>
        <?php if ($is_logged_in): ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>! | <a href="dashboard.php">Dashboard</a> | <a href="logout.php">Logout</a></p>
        <?php else: ?>
            <p><a href="login.php">Login</a></p>
        <?php endif; ?>
        <hr>
        <div>
            <?php
            $query = 'SELECT `School Name`, City FROM schools ORDER BY `School Name`'; 
            $schools = mysqli_query($connect, $query);

            while ($school = mysqli_fetch_assoc($schools)) {
                echo '<p>' . htmlspecialchars($school['School Name']) . ' - ' . htmlspecialchars($school['City']) . '</p>';
                if ($is_logged_in) {
                    
                }
            }
            ?>
        </div>
    </div>
</body>
</html>