<?php require 'auth.php'; require 'connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><title>All Schools</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <?php include 'nav.php'; ?>
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2>All Schools</h2>
      <a href="addschool.php" class="btn btn-success">Add School</a>
    </div>
    <hr>
    <?php
      $sql = "SELECT * FROM schools ORDER BY id DESC LIMIT 200";
      $result = mysqli_query($conn, $sql);
      if ($result && mysqli_num_rows($result) > 0):
    ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead><tr>
          <th>ID</th><th>School Name</th><th>Board Name</th><th>City</th><th>Level</th><th>Action</th>
        </tr></thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['School Name']) ?></td>
              <td><?= htmlspecialchars($row['Board Name']) ?></td>
              <td><?= htmlspecialchars($row['City']) ?></td>
              <td><?= htmlspecialchars($row['School Level']) ?></td>
              <td class="d-flex gap-2">
                <a href="editschool.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="deleteschool.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this school?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
      <p>No schools found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
