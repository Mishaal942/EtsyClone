<?php
session_start();
include 'config.php'; // DB connection

// Simulate user login if not already
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Make sure this user exists in users table
}

// Check cart
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<h2 style='text-align:center; margin-top:50px;'>Your cart is empty! <a href='index.php'>Go Shopping</a></h2>";
    exit;
}

$show_form = true;
$confirmation = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($name && $email && $address) {
        // Optional: Insert into orders table
        /*
        $stmt = $conn->prepare("INSERT INTO orders (user_id, name, email, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $_SESSION['user_id'], $name, $email, $address);
        $stmt->execute();
        $stmt->close();
        */

        // Clear cart
        $_SESSION['cart'] = [];

        $confirmation = "✅ Your booking is confirmed and soon your delivery will be on your home.";
        $show_form = false;
    } else {
        $confirmation = "❌ Please fill all the fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<style>
body { font-family: Arial; background:#f5f5f5; }
.container { max-width:500px; margin:50px auto; background:white; padding:20px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }
h2 { text-align:center; color:#333; margin-bottom:20px; }
form { display:flex; flex-direction:column; gap:15px; }
input, textarea { padding:10px; font-size:16px; border-radius:5px; border:1px solid #ccc; }
button { padding:12px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; font-size:16px; }
button:hover { background:#218838; }
.confirmation { margin-top:20px; text-align:center; font-size:18px; color:#007bff; }
a { color:#007bff; text-decoration:none; }
</style>
</head>
<body>
<div class="container">
    <h2>Checkout</h2>

    <?php if ($confirmation) { ?>
        <p class="confirmation"><?php echo $confirmation; ?></p>
        <p style="text-align:center;"><a href="index.php">Continue Shopping</a></p>
    <?php } ?>

    <?php if ($show_form) { ?>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <textarea name="address" placeholder="Delivery Address" rows="4" required></textarea>
        <button type="submit">Confirm Booking</button>
    </form>
    <?php } ?>
</div>
</body>
</html>
