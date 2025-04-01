<?php
session_start();
include 'db.php';
include 'security.php';

$max_attempts = 5;
$warning_attempts = 3;
$lockout_time = 900; // 15 minutes

// Registration logic
$registration_success = false; // Variable to track registration success message
$login_message = ""; // To store login success or error message

// Registration logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate email and password
    if (!validateEmail($email)) {
        $error_message = "Invalid email format";
    } elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES (?, ?, ?, ?, 'viewer')");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashedPassword);

        // Execute and check for errors
        if ($stmt->execute()) {
            $registration_success = true; // Set success message flag
        } else {
            $error_message = "Error: " . $stmt->error;  // Output the error
        }

        $stmt->close();
    }
}





// Login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    if (!validateEmail($email)) {
        echo "Invalid email format";
        exit();
    }

    // Query to check if user exists by email
    $stmt = $conn->prepare("SELECT id, first_name, last_name, password_hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            // Set session data
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_first_name'] = $user['first_name'];
            $_SESSION['admin_last_name'] = $user['last_name'];
            $_SESSION['role'] = $user['role'];

            // Redirect to the dashboard after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function togglePasswordVisibility(id) {
            var passwordField = document.getElementById(id);
            var eyeIcon = document.getElementById(id + '-eye');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }

        function checkPasswordMatch() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm-password').value;
            var message = document.getElementById('password-match-message');
            
            if (password === confirmPassword) {
                message.style.display = 'none'; // Hide warning if passwords match
            } else {
                message.style.display = 'block';
                message.style.color = 'red';
                message.textContent = "Passwords do not match!";
            }
        }

        function showRegisterForm() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        }

        function showLoginForm() {
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="login-container">
        <!-- Login Form -->
        <div id="loginForm">
            <h2>Admin Login</h2>
            <form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required><br>

    <div class="password-container">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <i class="fa fa-eye-slash eye-icon" id="password-eye" onclick="togglePasswordVisibility('password')"></i>
    </div>

    <button type="submit" name="login">Login</button>
</form>

            <!-- Display login message below the form -->
            <?php if (!empty($login_message)): ?>
                <div class="message" style="color: <?= strpos($login_message, 'success') !== false ? 'green' : 'red'; ?>;">
                    <?= $login_message; ?>
                </div>
            <?php endif; ?>

            <p>Don't have an account? <a href="#" onclick="showRegisterForm()">Register</a></p>
        </div>

        <!-- Register Form -->
        <div id="registerForm" style="display:none;">
            <h2>Admin Register</h2>
            <form method="POST" action="">
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    
    <!-- Password Input with Eye Icon -->
    <div class="password-container">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <i class="fa fa-eye-slash eye-icon" id="password-eye" onclick="togglePasswordVisibility('password')"></i>
    </div>

    <!-- Confirm Password Input with Eye Icon -->
    <div class="password-container">
        <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm Password" required onkeyup="checkPasswordMatch()">
        <i class="fa fa-eye-slash eye-icon" id="confirm-password-eye" onclick="togglePasswordVisibility('confirm-password')"></i>
    </div>

    <button type="submit" name="register">Register</button>
</form>



            <!-- Display registration success message below the form -->
            <?php if ($registration_success): ?>
                <div class="message" style="color: green; margin-top: 20px;">
                    Registration successful! You can now <a href="#" onclick="showLoginForm()">login</a>.
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
            
            <p>Already have an account? <a href="#" onclick="showLoginForm()">Login</a></p>
        </div>
    </div>
</body>
</html>
