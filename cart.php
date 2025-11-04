<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) $_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];

// Initialize cart
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Add product
if (isset($_GET['add'])) {
    $pid = intval($_GET['add']);
    if (!in_array($pid, $_SESSION['cart'])) $_SESSION['cart'][] = $pid;
    header("Location: cart.php");
    exit;
}

// Remove product
if (isset($_GET['remove'])) {
    $pid = intval($_GET['remove']);
    if (($key = array_search($pid, $_SESSION['cart'])) !== false) unset($_SESSION['cart'][$key]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

// Fetch products
$products_in_cart = [];
$total = 0.0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', $_SESSION['cart']));
    $res = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    while($row = $res->fetch_assoc()){
        $products_in_cart[] = $row;
        $total += floatval($row['price']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart</title>
<style>
body { font-family: Arial; background:#f5f5f5; }
.container { max-width:800px; margin:50px auto; background:white; padding:20px; border-radius:10px; box-shadow:0 5px 10px rgba(0,0,0,0.1);}
h2 { text-align:center; color:#333; }
table { width:100%; border-collapse: collapse; margin-top:20px;}
th, td { padding:10px; border-bottom:1px solid #ccc; }
th { background:#007bff; color:white; }
button { padding:8px 10px; background:#dc3545; border:none; color:white; border-radius:5px; cursor:pointer; }
button:hover { background:#c82333; }
.checkout { display:block; text-align:center; margin-top:20px; padding:12px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px; }
.checkout:hover { background:#218838; }
.empty { text-align:center; margin-top:20px; color:#777; }
</style>
</head>
<body>
<div class="container">
    <h2>My Cart</h2>

    <?php if(empty($products_in_cart)) { ?>
        <p class="empty">Your cart is empty!</p>
    <?php } else { ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php foreach($products_in_cart as $p){ ?>
            <tr>
                <td><?php echo htmlspecialchars($p['product_name']); ?></td>
                <td>$<?php echo number_format($p['price'],2); ?></td>
                <td>
                    <a href="cart.php?remove=<?php echo $p['id']; ?>"><button>Remove</button></a>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>$<?php echo number_format($total,2); ?></strong></td>
                <td></td>
            </tr>
        </table>
        <a class="checkout" href="checkout.php">Proceed to Checkout</a>
    <?php } ?>
</div>
</body>
</html>
