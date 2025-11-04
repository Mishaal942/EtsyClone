<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$query = "DELETE FROM cart WHERE id='$id'";
mysqli_query($conn, $query);

echo "<script>window.history.back();</script>";
exit();
?>
