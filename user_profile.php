<?php
session_start();
include 'config.php'; // database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Fetch user info
$stmt = $conn->prepare("SELECT id, username, email, created_at FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->num_rows === 1) {
    $user = $res->fetch_assoc();
} else {
    // if user not found, logout
    session_destroy();
    header("Location: login.php");
    exit();
}
$stmt->close();

// Fetch products of this user
$products = [];
$stmt2 = $conn->prepare("SELECT id, product_name, price, image_url, created_at FROM products WHERE user_id=? ORDER BY created_at DESC");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$res2 = $stmt2->get_result();
if ($res2) {
    while ($row = $res2->fetch_assoc()) {
        $products[] = $row;
    }
}
$stmt2->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo htmlspecialchars($user['username']); ?> — Profile</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;padding:20px;color:#333;}
.wrap{max-width:1000px;margin:0 auto;}
.header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.header a{margin-left:10px;text-decoration:none;font-weight:bold;color:#007bff;}
.profile-card{background:#fff;padding:20px;border-radius:10px;display:flex;gap:20px;align-items:center;box-shadow:0 5px 15px rgba(0,0,0,0.1);}
.avatar{width:100px;height:100px;background:#007bff;color:#fff;font-size:36px;font-weight:bold;border-radius:50%;display:flex;align-items:center;justify-content:center;}
.info h2{margin:0;font-size:22px;}
.info p{margin:5px 0;color:#555;}
.products{margin-top:20px;}
.products h3{margin-bottom:10px;}
.products-grid{display:flex;flex-wrap:wrap;gap:15px;}
.product-card{background:#fff;padding:15px;border-radius:10px;box-shadow:0 5px 10px rgba(0,0,0,0.05);width:220px;text-align:center;}
.product-card img{width:100%;height:150px;object-fit:cover;border-radius:5px;}
.product-card .title{font-weight:bold;margin:10px 0 5px 0;}
.product-card .price{color:#28a745;font-weight:bold;}
button{padding:8px 12px;border:none;border-radius:5px;background:#dc3545;color:#fff;cursor:pointer;}
button:hover{background:#c82333;}
.empty{padding:15px;background:#fff;border-radius:10px;text-align:center;color:#555;}
</style>
</head>
<body>

<div class="wrap">
    <div class="header">
        <div>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="profile-card">
        <div class="avatar">
            <?php echo strtoupper(substr($user['username'],0,1)); ?>
        </div>
        <div class="info">
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Member since: <?php echo date("F j, Y", strtotime($user['created_at'])); ?></p>
        </div>
    </div>

    <div class="products">
        <h3>Your Products</h3>
        <?php if(empty($products)) { ?>
            <div class="empty">You haven't added any products yet. <a href="add_product.php">Add your first product</a></div>
        <?php } else { ?>
            <div class="products-grid">
                <?php foreach($products as $p) { ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="">
                        <div class="title"><?php echo htmlspecialchars($p['product_name']); ?></div>
                        <div class="price">$<?php echo number_format($p['price'],2); ?></div>
                        <form method="post" action="delete_product.php" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <input type="hidden" name="id" value="<?php echo intval($p['id']); ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
