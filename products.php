<?php
session_start();
include 'db.php';

// Fetch all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Products</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f7f7f7; }
        .navbar {
            background: #ff6f61; padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center; color: #fff;
        }
        .navbar a { color: white; text-decoration: none; margin-left: 15px; font-weight: bold; }
        .container { width: 90%; margin: 30px auto; }
        h2 { text-align: center; margin-bottom: 20px; color: #444; }
        .product-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;
        }
        .product-card {
            background: white; padding: 15px; border-radius: 8px;
            text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform .2s;
        }
        .product-card:hover { transform: scale(1.03); }
        .product-card img {
            width: 100%; height: 250px; object-fit: cover;
            border-radius: 8px; margin-bottom: 10px;
        }
        .product-card h3 { margin: 10px 0 5px; font-size: 18px; color: #333; }
        .product-card p { color: #777; margin-bottom: 10px; }
        .product-card button {
            padding: 10px 15px; background: #ff6f61; color: white;
            border: none; border-radius: 5px; cursor: pointer; font-weight: bold;
        }
        .product-card button:hover { background: #e85a4f; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo"><h2>Etsy Clone</h2></div>
    <div>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="cart.php">Cart</a>
            <a href="user_profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <h2>All Products</h2>
    <div class="product-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product-card">
                <img src="<?php echo $row['image']; ?>" alt="Product Image">
                <h3><?php echo $row['name']; ?></h3>
                <p>$<?php echo $row['price']; ?></p>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
