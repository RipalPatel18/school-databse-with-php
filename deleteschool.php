<?php require 'auth.php'; require 'connect.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
  $stmt = mysqli_prepare($conn, "DELETE FROM schools WHERE id=?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
}
header("Location: schools_list.php");
exit;
