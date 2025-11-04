<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = $_GET['id'];
$query = "SELECT * FROM order_items WHERE order_id = '$order_id'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <style>
        body{font-family:Arial;background:#f2f2f2;padding:20px}
        table{width:100%;border-collapse:collapse;background:white}
        th,td{border:1px solid #ddd;padding:10px;text-align:left}
        th{background:#333;color:white}
    </style>
</head>
<body>
<h2>Order #<?php echo $order_id; ?></h2>
<table>
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td>$<?php echo $row['price']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
