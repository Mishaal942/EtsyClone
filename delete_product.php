<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id=$id");

echo "<script>alert('Product Deleted'); window.location.href='my_products.php';</script>";
?>
