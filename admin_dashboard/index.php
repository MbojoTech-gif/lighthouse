<?php
// index.php - Secure Login with Failed Attempt Tracking & Warning
session_start();
include 'db.php';
include 'security.php';

$max_attempts = 5;
$warning_attempts = 3;
$lockout_time = 900; // 15 minutes

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    if (!validateEmail($email)) {
        echo "Invalid email format";
        exit();
    }

    // Check if user is locked out
    $stmt = $conn->prepare("SELECT failed_attempts, last_attempt FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $failed_attempts = $user['failed_attempts'];
        $last_attempt = strtotime($user['last_attempt']);
        
        if ($failed_attempts >= $max_attempts && (time() - $last_attempt) < $lockout_time) {
            echo "Too many failed attempts. Try again later.";
            exit();
        }
    }
    
    // Verify password
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            // Reset failed attempts
            $stmt = $conn->prepare("UPDATE users SET failed_attempts = 0 WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            header("Location: dashboard.php");
            exit();
        } else {
            // Increment failed attempts
            $stmt = $conn->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, last_attempt = NOW() WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            $failed_attempts++;
            echo "Incorrect password.";
            
            // Show warning if attempts reach threshold
            if ($failed_attempts >= $warning_attempts) {
                echo " Warning: You have " . ($max_attempts - $failed_attempts) . " attempts left before lockout.";
            }
        }
    } else {
        echo "User not found.";
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
