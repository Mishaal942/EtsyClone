<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$products = $conn->query("SELECT * FROM products WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Products</title>
    <style>
        body { margin: 0; font-family: Arial; background: #f5f5f5; }
        .container { padding: 30px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #ff7f50;
            color: white;
        }
        a.btn {
            padding: 6px 10px;
            text-decoration: none;
            background: #ff7f50;
            color: #fff;
            border-radius: 5px;
        }
        a.btn:hover { background: #e06938; }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Listed Products</h2>
    <a href="add_product.php" class="btn">Add More</a>
    <br><br>
    <table>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price ($)</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $products->fetch_assoc()): ?>
            <tr>
                <td><img src="<?php echo $row['image']; ?>" width="80"></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td>
                    <a class="btn" href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a class="btn" href="delete_product.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
