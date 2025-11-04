<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $query = "DELETE FROM users WHERE id = '$user_id'";
    mysqli_query($conn, $query);
}

header("Location: manage_users.php");
exit();
?>
