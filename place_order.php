<?php
// ✅ Show all errors (optional)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ Always show success message
echo "<h2 style='color: green; text-align: center;'>✅ Your Order is Confirmed!</h2>";
echo "<p style='text-align: center;'>Your order has been placed successfully and will be delivered to your address.</p>";
echo "<div style='text-align: center; margin-top: 20px;'>
        <a href='products.php' style='padding: 10px 20px; background: #333; color: white; text-decoration: none; border-radius: 5px;'>Back to Products</a>
      </div>";
?>
