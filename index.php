<?php
session_start();
include 'config.php';

// Simulate logged-in user
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Make sure this user exists in users table
}

// Fetch products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Marketplace</title>
<style>
body { font-family: Arial; background:#f5f5f5; margin:0; padding:0; }
header { background:#007bff; padding:15px; color:white; display:flex; justify-content:space-between; align-items:center; }
header a { color:white; text-decoration:none; margin-left:15px; font-weight:bold; }
.container { max-width:1000px; margin:20px auto; display:flex; flex-wrap:wrap; gap:20px; }
.product { background:white; padding:15px; border-radius:10px; box-shadow:0 5px 10px rgba(0,0,0,0.1); width:220px; text-align:center; }
img { max-width:100%; height:150px; object-fit:cover; border-radius:5px; }
button { padding:8px 12px; margin-top:10px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; }
button:hover { background:#218838; }
.top-buttons { display:flex; gap:10px; }
</style>
</head>
<body>

<header>
    <div>
        <a href="index.php">Home</a>
        <a href="cart.php">Cart</a>
        <a href="user_profile.php">Profile</a>
    </div>
    <div class="top-buttons">
        <a href="logout.php">Logout</a>
        <a href="add_product.php"><button>Add Product</button></a>
    </div>
</header>

<div class="container">
    <?php while($row = $result->fetch_assoc()){ ?>
        <div class="product">
            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="">
            <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
            <p>$<?php echo number_format($row['price'],2); ?></p>
            <a href="cart.php?add=<?php echo $row['id']; ?>"><button>Add to Cart</button></a>
        </div>
    <?php } ?>
</div>

</body>
</html>
