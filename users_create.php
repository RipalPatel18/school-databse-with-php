<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


require 'connect.php';

$message = '';

if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $image_name = 'default.jpg';


    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/users/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $new_filename = uniqid('user_', true) . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_name = $new_filename;
        } else {
            $message = "Warning: Failed to upload image.";
        }
    }


    $stmt = mysqli_prepare($connect, "INSERT INTO users (name, email, password, image) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashed_password, $image_name);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User Created!'); window.location='users.php';</script>";
        exit;
    } else {
        $message .= " Error creating user: " . mysqli_error($connect);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Create User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container mt-4">
    <h2>Create New User</h2>
    <p><a href="users.php">Back to Users List</a></p>
    <?php if ($message): ?>
        <p class="text-danger"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        
        <button type="submit" name="create" class="btn btn-success">Create User</button>
    </form>
</div>
</body>
</html>