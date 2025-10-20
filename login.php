<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'connect.php';

$err = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare($conn, "SELECT id, name, email, password, image FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user = $res ? mysqli_fetch_assoc($res) : null;

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'image' => $user['image'] ?? ''
        ];
        header("Location: dashboard.php");
        exit;
    } else {
        $err = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <?php include 'nav.php'; ?>
  <div class="container" style="max-width:420px;">
    <h2>Login</h2>
    <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
    <form method="POST" class="mt-3">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" required>
      </div>
      <button class="btn btn-primary w-100" type="submit">Login</button>
    </form>
    <p class="mt-3">Don't have an account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>
