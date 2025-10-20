<?php require 'auth.php'; require 'connect.php'; ?>
<?php
$err = '';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: schools_list.php"); exit; }


$stmt = mysqli_prepare($conn, "SELECT * FROM schools WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = $res ? mysqli_fetch_assoc($res) : null;
if (!$row) { header("Location: schools_list.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $board  = trim($_POST['boardname'] ?? '');
    $number = trim($_POST['schoolnumber'] ?? '');
    $name   = trim($_POST['schoolname'] ?? '');
    $level  = trim($_POST['schoollevel'] ?? '');
    $city   = trim($_POST['city'] ?? '');

    if ($board==='' || $number==='' || $name==='' || $level==='' || $city==='') {
        $err = "All fields are required.";
    } else {
        $up = mysqli_prepare($conn, "UPDATE schools SET `Board Name`=?, `School Number`=?, `School Name`=?, `School Level`=?, `City`=? WHERE id=?");
        mysqli_stmt_bind_param($up, "sssssi", $board, $number, $name, $level, $city, $id);
        if (mysqli_stmt_execute($up)) {
            header("Location: schools_list.php");
            exit;
        } else {
            $err = "DB Error updating school.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><title>Edit School</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <?php include 'nav.php'; ?>
  <div class="container" style="max-width:640px;">
    <h2>Edit School</h2>
    <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label class="form-label">Board Name</label>
        <input type="text" name="boardname" class="form-control" value="<?= htmlspecialchars($row['Board Name']) ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">School Number</label>
        <input type="text" name="schoolnumber" class="form-control" value="<?= htmlspecialchars($row['School Number']) ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">School Name</label>
        <input type="text" name="schoolname" class="form-control" value="<?= htmlspecialchars($row['School Name']) ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">School Level</label>
        <input type="text" name="schoollevel" class="form-control" value="<?= htmlspecialchars($row['School Level']) ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">City</label>
        <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($row['City']) ?>" required>
      </div>
      <button class="btn btn-primary" type="submit">Update School</button>
    </form>
  </div>
</body>
</html>
