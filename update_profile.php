<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user_id'];

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $query = "UPDATE users SET username='$username', email='$email' WHERE id='$id'";
    mysqli_query($conn, $query);

    header("Location: user_profile.php");
    exit();
}

$query = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
<title>Update Profile</title>
<style>
    body{font-family:Arial;background:#f7f7f7;padding:30px}
    .container{background:white;padding:20px;width:50%;margin:auto;border-radius:8px}
    label{display:block;margin-top:10px}
    input{width:100%;padding:8px;margin-top:5px}
    button{background:blue;color:white;padding:10px;border:none;margin-top:15px}
</style>
</head>
<body>
<div class="container">
    <h2>Update Profile</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <button type="submit" name="update">Save Changes</button>
    </form>
</div>
</body>
</html>
