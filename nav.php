<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<nav style="background:#f7f7f7; padding:10px; display:flex; gap:12px; align-items:center;">
  <a href="index.php">Public Schools</a>
  <?php if (!empty($_SESSION['user'])): ?>
    <a href="dashboard.php">Dashboard</a>
    <a href="schools_list.php">Manage Schools</a>
    <a href="users.php">Manage Users</a>
    <span style="margin-left:auto;">
      Hello, <?= htmlspecialchars($_SESSION['user']['name']) ?>
      <?php if (!empty($_SESSION['user']['image'])): ?>
        <img src="uploads/users/<?= htmlspecialchars($_SESSION['user']['image']) ?>" width="32" height="32" style="border-radius:50%; vertical-align:middle; margin-left:6px;" alt="Profile">
      <?php endif; ?>
      <a style="margin-left:12px;" href="logout.php">Logout</a>
    </span>
  <?php else: ?>
    <span style="margin-left:auto;"></span>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
  <?php endif; ?>
</nav>
