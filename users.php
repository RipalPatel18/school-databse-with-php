<?php

include("auth.php");
include("connect.php");


$message = "";
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';


if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $image = "";


    if (!empty($_FILES['image']['name'])) {
        $folder = "uploads/users/";
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $target = $folder . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target);
    }

    $sql = "INSERT INTO users (name, email, password, image) VALUES ('$name', '$email', '$password', '$image')";
    if (mysqli_query($conn, $sql)) {
        $message = " User added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}


if ($action == "delete" && !empty($id)) {
    $sql = "DELETE FROM users WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $message = "User deleted successfully!";
    } else {
        $message = "Error deleting user: " . mysqli_error($conn);
    }
}

if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $image = $_POST['old_image'];


    if (!empty($_FILES['image']['name'])) {
        $folder = "uploads/users/";
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $target = $folder . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target);
    }

    $sql = "UPDATE users SET name='$name', email='$email', image='$image' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $message = "✏️ User updated successfully!";
    } else {
        $message = "⚠️ Error: " . mysqli_error($conn);
    }
}


$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<?php include("nav.php"); ?>

<div class="container">
  <h2 class="mb-3">Manage Users</h2>

  <?php if ($message): ?>
    <div class="alert alert-info"><?= $message ?></div>
  <?php endif; ?>


  <form method="POST" enctype="multipart/form-data" class="border p-3 mb-4">
    <h4>Add New User</h4>
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
      <label>Image (optional)</label>
      <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" name="add_user" class="btn btn-success">Add User</button>
  </form>


  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td>
          <?php if ($row['image']): ?>
            <img src="uploads/users/<?= $row['image'] ?>" width="50" height="50" style="border-radius:50%;">
          <?php else: ?>
            No Image
          <?php endif; ?>
        </td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td>
          <a href="users_edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
          <a href="users.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')" class="btn btn-danger btn-sm">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
