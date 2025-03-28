<?php
session_start();
include '../backend/db.php';  // Go up one level from 'client' and then access 'backend/db.php'


// Handle User Registration
if (isset($_POST['signup'])) {
    $username = htmlspecialchars($_POST['newUsername']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT); // Encrypt password

    // Check if email or username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Username or Email already exists!'); window.location.href='login.php';</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $password])) {
            echo "<script>alert('Registration successful! Please log in.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Try again.'); window.location.href='login.php';</script>";
        }
    }
}

// Handle User Login
if (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Check user in database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['username'];
        echo "<script>alert('Login successful!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Invalid credentials. Try again.'); window.location.href='login.php';</script>";
    }
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>alert('Logged out successfully.'); window.location.href='login.php';</script>";
}
?>
