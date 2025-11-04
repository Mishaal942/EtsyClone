<?php
session_start();
include 'config.php'; // yahan db connection hona chahiye

// Show all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set a valid user id for testing (must exist in users table)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_name = trim($_POST['product_name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $user_id = $_SESSION['user_id'];

    if (!empty($product_name) && !empty($price)) {

        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {

            $allowed = ['jpg','jpeg','png','gif'];
            $filename = $_FILES['product_image']['name'];
            $tmpname = $_FILES['product_image']['tmp_name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {

                if (!is_dir('uploads')) mkdir('uploads', 0777, true);

                $newName = 'uploads/' . time() . '_' . basename($filename);

                if (move_uploaded_file($tmpname, $newName)) {

                    // Duplicate check
                    $stmt_check = $conn->prepare("SELECT * FROM products WHERE product_name=? AND user_id=?");
                    $stmt_check->bind_param("si", $product_name, $user_id);
                    $stmt_check->execute();
                    $result_check = $stmt_check->get_result();

                    if ($result_check->num_rows > 0) {
                        $message = "⚠️ Product with this name already exists!";
                    } else {
                        $stmt_insert = $conn->prepare("INSERT INTO products (product_name, price, description, image_url, user_id) VALUES (?, ?, ?, ?, ?)");
                        $stmt_insert->bind_param("sdssi", $product_name, $price, $description, $newName, $user_id);

                        if ($stmt_insert->execute()) {
                            $message = "✅ Product added successfully!";
                        } else {
                            $message = "❌ Database Error: " . $conn->error;
                        }
                        $stmt_insert->close();
                    }
                    $stmt_check->close();

                } else {
                    $message = "❌ Failed to upload image!";
                }

            } else {
                $message = "⚠️ Only JPG, JPEG, PNG, GIF allowed!";
            }

        } else {
            $message = "⚠️ Product image is required!";
        }

    } else {
        $message = "⚠️ Product name and price are required!";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Product</title>
<style>
body { font-family: Arial, sans-serif; background: #f5f5f5; margin:0; padding:0; }
.container { max-width:500px; margin:50px auto; background:white; padding:20px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1);}
h2 { text-align:center; color:#333; margin-bottom:20px; }
label { display:block; margin-bottom:5px; font-weight:bold; }
input, textarea { width:100%; padding:10px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc; }
textarea { resize:none; height:80px; }
button { width:100%; padding:12px; background:#007bff; border:none; color:white; font-size:16px; border-radius:5px; cursor:pointer; }
button:hover { background:#0056b3; }
.message { text-align:center; font-weight:bold; margin-bottom:15px; color:#d9534f; }
.success { color: #28a745; }
.back-link { display:block; text-align:center; margin-top:10px; text-decoration:none; color:#007bff; }
</style>
</head>
<body>

<div class="container">
    <h2>Add New Product</h2>

    <?php if ($message) echo "<div class='message'>$message</div>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Product Name</label>
        <input type="text" name="product_name" placeholder="Enter product title" required>

        <label>Price</label>
        <input type="number" name="price" placeholder="Enter price" step="0.01" required>

        <label>Description</label>
        <textarea name="description" placeholder="Enter product description"></textarea>

        <label>Product Image</label>
        <input type="file" name="product_image" accept="image/*" required>

        <button type="submit">Add Product</button>
    </form>

    <a class="back-link" href="index.php">⬅ Back to Home</a>
</div>

</body>
</html>
