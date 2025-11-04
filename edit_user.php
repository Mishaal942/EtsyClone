<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $update = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id='$id'";
    mysqli_query($conn, $update);

    header("Location: manage_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body { font-family: Arial; background:#f2f2f2; }
        .container { width: 50%; margin: 50px auto; background:#fff; padding:20px; border-radius:8px; }
        label { display:block; margin-top:10px; font-weight:600; }
        input, select { width:100%; padding:10px; margin-top:5px; }
        button { background:blue; color:white; border:none; padding:10px 15px; margin-top:15px; cursor:pointer; }
        button:hover { background:darkblue; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit User</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label>Role</label>
        <select name="role" required>
            <option value="buyer" <?php if($user['role']=='buyer') echo 'selected'; ?>>Buyer</option>
            <option value="seller" <?php if($user['role']=='seller') echo 'selected'; ?>>Seller</option>
            <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
        </select>

        <button type="submit" name="update">Update</button>
    </form>
</div>
</body>
</html>
