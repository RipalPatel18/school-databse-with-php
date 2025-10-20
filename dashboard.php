<?php require 'auth.php'; ?>
<?php require 'connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <?php include 'nav.php'; ?>
  <div class="container">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</h1>
    <p class="text-muted">Email: <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
    <?php if (!empty($_SESSION['user']['image'])): ?>
      <img src="uploads/users/<?= htmlspecialchars($_SESSION['user']['image']) ?>" width="100" style="border-radius:50%;">
    <?php endif; ?>

    <hr>
    <div class="d-flex gap-2">
      <a class="btn btn-primary" href="users.php">Manage Users</a>
      <a class="btn btn-secondary" href="schools_list.php">Manage Schools</a>
      <a class="btn btn-outline-dark" href="index.php">Public Schools Index</a>
    </div>
  </div>
</body>
</html>
