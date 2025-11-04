<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f5f5f5;
        }
        .profile-box {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .details p {
            margin: 10px 0;
            font-size: 16px;
        }
        .btn {
            display: block;
            width: 100%;
            text-align: center;
            background: #ff7f50;
            padding: 10px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .btn:hover {
            background: #e86839;
        }
    </style>
</head>
<body>
<div class="profile-box">
    <h2>Your Profile</h2>
    <div class="details">
        <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Joined:</strong> <?php echo $user['created_at']; ?></p>
    </div>
    <a class="btn" href="index.php">Back to Home</a>
</div>
</body>
</html>
