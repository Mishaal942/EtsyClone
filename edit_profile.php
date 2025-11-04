<?php
// Dummy existing user data (Replace with DB when needed)
$user = [
    "name" => "John Doe",
    "email" => "john@example.com",
    "username" => "johndoe123",
    "address" => "123 Main Street, City, Country",
    "phone" => "+1234567890"
];

$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // ✅ Yahan database update ka code lag sakta hai
    // Filhal dummy success message
    $successMsg = "✅ Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Profile</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .edit-container {
        width: 50%;
        margin: 50px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
    }

    .form-group input, .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 15px;
    }

    .form-group textarea {
        resize: none;
        height: 80px;
    }

    .btn-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn {
        width: 48%;
        padding: 12px 0;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        color: white;
        transition: 0.3s;
        text-align: center;
    }

    .btn-save {
        background: #28a745;
    }

    .btn-save:hover {
        background: #218838;
    }

    .btn-cancel {
        background: #dc3545;
    }

    .btn-cancel:hover {
        background: #c82333;
    }

    .success-message {
        text-align: center;
        background: #d4edda;
        color: #155724;
        padding: 10px;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .edit-container {
            width: 90%;
        }

        .btn-container {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
</head>
<body>

<div class="edit-container">
    <h2>Edit Profile</h2>

    <?php if ($successMsg): ?>
        <div class="success-message"><?php echo $successMsg; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
        </div>

        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>
        </div>

        <div class="form-group">
            <label>Address:</label>
            <textarea name="address" required><?php echo $user['address']; ?></textarea>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-save">Save Changes</button>
            <button type="button" class="btn btn-cancel" onclick="window.location.href='user_profile.php'">Cancel</button>
        </div>
    </form>
</div>

</body>
</html>
