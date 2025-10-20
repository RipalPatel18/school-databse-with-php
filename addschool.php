<?php require 'auth.php'; require 'connect.php'; ?>
<?php
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $board  = trim($_POST['boardname'] ?? '');
    $number = trim($_POST['schoolnumber'] ?? '');
    $name   = trim($_POST['schoolname'] ?? '');
    $level  = trim($_POST['schoollevel'] ?? '');
    $city   = trim($_POST['city'] ?? '');

    if ($board==='' || $number==='' || $name==='' || $level==='' || $city==='') {
        $err = "All fields are required.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO schools (`Board Name`,`School Number`,`School Name`,`School Level`,`City`) VALUES (?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "sssss", $board, $number, $name, $level, $city);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: schools_list.php");
            exit;
        } else {
            $err = "DB Error adding school.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><title>Add School</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <?php include 'nav.php'; ?>
  <div class="container" style="max-width:640px;">
    <h2>Add New School</h2>
    <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label class="form-label">Board Name</label><input type="text" name="boardname" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">School Number</label><input type="text" name="schoolnumber" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">School Name</label><input type="text" name="schoolname" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">School Level</label><input type="text" name="schoollevel" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">City</label><input type="text" name="city" class="form-control" required></div>
      <button class="btn btn-success" type="submit">Add School</button>
    </form>
  </div>
</body>
</html>
