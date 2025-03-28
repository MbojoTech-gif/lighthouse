<?php
require 'db.php';
session_start();

// Handle Registration
if (isset($_POST['register'])) {
    $username = $_POST['newUsername'];
    $email = $_POST['email'];
    $password = $_POST['newPassword'];

    // Store password as plain text (for testing purposes only)
    $plainPassword = $password;

    // Insert into the database
    $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $plainPassword // Plain text password
        ]);
        $_SESSION['message'] = "Registration successful! You can now log in.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

// Handle Login
if (isset($_POST['login'])) {
    $email = $_POST['username'];  // Assuming login by username
    $password = $_POST['password'];

    // Check user in DB
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password_hash']) { // Compare plain text password
        $_SESSION['user'] = $user['username'];
        header("Location: index.php");  // Redirect after successful login
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../styles/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barriecito&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/b29579297b.js" crossorigin="anonymous"></script>
</head>
<body class="login-page">

  <section class="header">
    <nav>
        <a href="index.html"><img src="src/logo.png"></a>
        <p><b><button>LIGHTHOUSE MINISTERS NRB</button></b></p>
        <div class="nav-links" id="navLinks">
            <i class="fa fa-times" onclick="hideMenu()"></i>
            <ul>
            <li><a href="index.php">HOME</a></li>
                        <li><a href="about.php">ABOUT</a></li>
                        <li><a href="gallery.php">GALLERY</a></li>
                        <li><a href="events.php">EVENTS</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
                        <li><button><a href="login.php" class="login-btn">Login</a></button></li>
            </ul>
        </div>
        <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>
  <div class="login-container">
    <div class="login-form">
      <h2 id="formTitle">Login</h2>
      <form id="loginForm" action="login.php" method="POST">
    <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />
    </div>
    <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
    </div>
    <?php if (isset($_SESSION['error'])): ?>
        <p style='color: red;'><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    <button type="submit" name="login">Login</button>
</form>

      <div id="signUpForm" class="hidden">
      <form id="signupForm" action="login.php" method="POST">
    <div class="input-group">
        <label for="newUsername">Username</label>
        <input type="text" id="newUsername" name="newUsername" required />
    </div>
    <div class="input-group">
        <label for="newPassword">Password</label>
        <input type="password" id="newPassword" name="newPassword" required />
    </div>
    <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
    </div>
    <button type="submit" name="register">Sign Up</button>
</form>
      </div>

      <div id="error-message" class="error-message"></div>

      <button id="toggleFormButton">Don't have an account? Sign Up</button>
    </div>
  </div>
</section>

  <script src="script.js"></script>
</body>
</html>