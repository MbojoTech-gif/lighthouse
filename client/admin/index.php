<?php
session_start();
include '../db.php'; // Make sure this points to your DB connection

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Check login in the users table (adjust field names as needed)
    $stmt = $conn->prepare("SELECT id, password_hash, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            $_SESSION['role'] = $role;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Lighthouse Ministers</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg,rgb(36, 2, 99), #feb47b);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .login-box {
            width: 350px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #ffd700;
            font-weight: 700;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #fff;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 16px;
        }

        .login-box input[type="text"]:focus,
        .login-box input[type="password"]:focus {
            outline: none;
            border-color: #ffd700;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            background: #ffd700;
            color: black;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-box button:hover {
            background-color: #f7b600;
        }

        .login-box p {
            color: red;
            font-size: 14px;
            text-align: center;
        }

        .login-box .music-icon {
            font-size: 50px;
            color: rgb(90, 2, 2);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="music-icon">
            🎵
        </div>
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter username" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
