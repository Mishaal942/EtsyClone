<?php
session_start();
include 'config.php'; // database connection

// If user already logged in, redirect to index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Initialize variables
$username = $email = $password = "";
$error = "";

// On form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            // Insert user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("INSERT INTO users (username,email,password,created_at) VALUES (?,?,?,NOW())");
            $stmt2->bind_param("sss", $username, $email, $hash);
            if ($stmt2->execute()) {
                // Redirect to login page after signup
                header("Location: login.php?signup=success");
                exit();
            } else {
                $error = "Something went wrong! Try again.";
            }
            $stmt2->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign Up</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;padding:0;display:flex;justify-content:center;align-items:center;height:100vh;}
.container{background:#fff;padding:30px;border-radius:10px;box-shadow:0 6px 24px rgba(0,0,0,0.1);width:350px;}
h2{text-align:center;margin-bottom:20px;}
input[type=text], input[type=email], input[type=password]{width:100%;padding:10px;margin:8px 0;border-radius:5px;border:1px solid #ccc;}
button{width:100%;padding:10px;background:#007bff;color:#fff;border:none;border-radius:5px;cursor:pointer;font-weight:bold;}
button:hover{background:#0069d9;}
.error{color:#dc3545;margin:10px 0;text-align:center;}
.success{color:#28a745;margin:10px 0;text-align:center;}
p{text-align:center;margin-top:15px;}
a{text-decoration:none;color:#007bff;}
</style>
</head>
<body>
<div class="container">
    <h2>Sign Up</h2>
    <?php if($error) { echo "<div class='error'>".$error."</div>"; } ?>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
