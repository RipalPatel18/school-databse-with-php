<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


require 'connect.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ERROR: User ID not provided.");
}

$message = '';


$stmt = mysqli_prepare($connect, "SELECT id, name, email, image FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("ERROR: User not found.");
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $current_image = $user['image'];
    $new_image_name = $current_image;


    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/users/";
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $temp_filename = uniqid('user_', true) . '.' . $file_extension;
        $target_file = $target_dir . $temp_filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
     
            if ($current_image != 'default.jpg' && file_exists($target_dir . $current_image)) {
                unlink($target_dir . $current_image);
            }
            $new_image_name = $temp_filename;
        } else {
            $message .= "Warning: Failed to upload new image. ";
        }
    }
    

    $fields = ['name = ?', 'email = ?', 'image = ?'];
    $params = [$name, $email, $new_image_name];
    $types = 'sss';

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $fields[] = 'password = ?';
        $params[] = $hashed_password;
        $types .= 's';
    }

    $params[] = $id;
    $types .= 'i';
    
    $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
    
    $stmt = mysqli_prepare($connect, $query);
    

    $bind_args = [&$stmt, &$types];
    for ($i = 0; $i < count($params); $i++) {
        $bind_args[] = &$params[$i];
    }
    call_user_func_array('mysqli_stmt_bind_param', $bind_args);

    // 3. Execute Update
    if (mysqli_stmt_execute($stmt)) {
        $message .= "User successfully updated!";
    
        if ($id == $_SESSION['user_id']) {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['image'] = $new_image_name;
        }

        $stmt = mysqli_prepare($connect, "SELECT id, name, email, image FROM users WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
    } else {
        $message .= " Error updating user: " . mysqli_error($connect);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container mt-4">
    <h2>Edit User: <?php echo htmlspecialchars($user['name']); ?></h2>
    <p><a href="users.php">Back to Users List</a></p>
    <?php if ($message): ?>
        <p class="text-success"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label>New Password (Leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="uploads/users/<?php echo htmlspecialchars($user['image']); ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;"><br>
            <label for="image" class="mt-2">Upload New Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        
        <button type="submit" name="update" class="btn btn-primary">Update User</button>
    </form>
</div>
</body>
</html>