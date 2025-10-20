<?php
require_once 'connect.php';
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$sql = "SELECT id, `School Name`, `Board Name`, `City`, `School Level`, `School Number`
        FROM schools ORDER BY id DESC LIMIT 200";
$result = mysqli_query($conn, $sql);
$err = $result === false ? mysqli_error($conn) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All Schools (Public)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <?php include 'nav.php'; ?>
  <div class="container">
    <h1 class="mb-2">All Schools</h1>
    <p class="text-muted">This page is public. All other pages require login.</p>

    <?php if ($err): ?>
      <div class="alert alert-danger">DB Error: <?= e($err) ?></div>
    <?php endif; ?>

    <?php if ($result && mysqli_num_rows($result)>0): ?>
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead><tr>
            <th>#</th><th>School Name</th><th>Board</th><th>City</th><th>Level</th><th>Number</th>
          </tr></thead>
          <tbody>
            <?php while($row=mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= e($row['id']) ?></td>
                <td><?= e($row['School Name']) ?></td>
                <td><?= e($row['Board Name']) ?></td>
                <td><?= e($row['City']) ?></td>
                <td><?= e($row['School Level']) ?></td>
                <td><?= e($row['School Number']) ?></td>
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
