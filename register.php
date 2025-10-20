<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'connect.php';

$err = $ok = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass1 = $_POST['password'] ?? '';
    $pass2 = $_POST['password2'] ?? '';

    if ($name === '' || $email === '' || $pass1 === '') {
        $err = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = "Invalid email.";
    } elseif ($pass1 !== $pass2) {
        $err = "Passwords do not match.";
    } else {

        $imageName = null;
        if (!empty($_FILES['image']['name'])) {
            $dir = __DIR__ . "/uploads/users/";
            if (!is_dir($dir)) { mkdir($dir, 0755, true); }
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif','webp'];
            if (!in_array($ext, $allowed)) {
                $err = "Invalid image type.";
            } else {
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/','', $_FILES['image']['name']);
                $target = $dir . $imageName;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $err = "Failed to upload image.";
                }
            }
        }

        if ($err === '') {
            $hash = password_hash($pass1, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO users (name,email,password,image) VALUES (?,?,?,?)");
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hash, $imageName);
            if (mysqli_stmt_execute($stmt)) {
                $ok = "Registration successful. You can now login.";
            } else {
                $err = "Email may already exist or DB error.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <?php include 'nav.php'; ?>
  <div class="container" style="max-width:520px;">
    <h2>Create Account</h2>
    <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
    <?php if ($ok): ?><div class="alert alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data" class="mt-3">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" type="text" name="name" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input class="form-control" type="password" name="password2" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Profile Image (optional)</label>
        <input class="form-control" type="file" name="image" accept="image/*">
      </div>
      <button class="btn btn-success w-100" type="submit">Register</button>
    </form>
  </div>
</body>
</html>
