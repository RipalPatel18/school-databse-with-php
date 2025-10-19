<?php

session_start();
include('connect.php'); 

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
   
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    

    $stmt = mysqli_prepare($connect, "SELECT id, name, email, password, image FROM users WHERE email=?");
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
      
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['image'] = $user['image'];
                
                header("Location: dashboard.php"); 
                exit;
            } else {
                $error = "Invalid password."; 
            }
        } else {
            $error = "User not found.";
        }
        mysqli_stmt_close($stmt); 
    } else {
        $error = "Database Error: Could not prepare statement: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
<h2>Login</h2>
<form method="post">
  <div class="mb-3">
    <input class="form-control" type="email" name="email" placeholder="Email" required>
  </div>
  <div class="mb-3">
    <input class="form-control" type="password" name="password" placeholder="Password" required>
  </div>
  <button class="btn btn-primary" type="submit">Login</button>
</form>
<p class="text-danger mt-3"><?php if(isset($error)) echo htmlspecialchars($error); ?></p>
<p>Go to <a href="index.php">Schools Index (Public)</a></p>
</body>
</html>