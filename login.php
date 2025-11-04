<?php
session_start();
include 'config.php'; // database connection

// If user already logged in, redirect to index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$email = $password = "";
$error = "";

// On form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "All fields are required!";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Login success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "Email not found!";
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
<title>Login</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;padding:0;display:flex;justify-content:center;align-items:center;height:100vh;}
.container{background:#fff;padding:30px;border-radius:10px;box-shadow:0 6px 24px rgba(0,0,0,0.1);width:350px;}
h2{text-align:center;margin-bottom:20px;}
input[type=email], input[type=password]{width:100%;padding:10px;margin:8px 0;border-radius:5px;border:1px solid #ccc;}
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
    <h2>Login</h2>
    <?php if($error) { echo "<div class='error'>".$error."</div>"; } ?>
    <?php if(isset($_GET['signup']) && $_GET['signup'] === 'success'){ echo "<div class='success'>Signup successful! Please login.</div>"; } ?>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
</div>
</body>
</html>
