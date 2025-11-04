<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
$categories = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = trim($_POST['price']);
    $category_id = $_POST['category_id'];

    $imageQuery = "";
    if (!empty($_FILES['image']['name'])) {
        $image = "uploads/" . time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
        $imageQuery = ", image='$image'";
    }

    $update = "UPDATE products SET name='$name', description='$desc', price='$price', category_id=$category_id $imageQuery WHERE id=$id";
    if ($conn->query($update) === TRUE) {
        echo "<script>alert('Product Updated'); window.location.href='my_products.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body { margin: 0; font-family: Arial; background: #f7f7f7; }
        .container {
            width: 450px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h2 { text-align: center; margin-bottom: 15px; }
        input, select, textarea {
            width: 100%;
            margin: 8px 0;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #ff7f50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover { background: #e46d3d; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
        <textarea name="description" rows="4" required><?php echo $product['description']; ?></textarea>
        <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

        <select name="category_id" required>
            <?php while ($cat = $categories->fetch_assoc()): ?>
                <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $product['category_id']) echo "selected"; ?>>
                    <?php echo $cat['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="file" name="image">
        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
