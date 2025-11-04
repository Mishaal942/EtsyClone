<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM orders WHERE buyer_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Orders</title>
    <style>
        body{font-family:Arial;background:#f2f2f2;padding:20px}
        table{width:100%;border-collapse:collapse;background:white}
        th,td{border:1px solid #ddd;padding:10px;text-align:left}
        th{background:#333;color:white}
        a{color:blue;text-decoration:none}
    </style>
</head>
<body>
<h2>Your Orders</h2>
<table>
    <tr>
        <th>Order ID</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Date</th>
        <th>View</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td>$<?php echo $row['total_price']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td><a href="order_details.php?id=<?php echo $row['id']; ?>">Details</a></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
