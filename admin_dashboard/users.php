<?php
// users.php - Manage Admin Users with Email Password Reset
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Define role-based access restrictions
$role = $_SESSION['role'];
$page = basename($_SERVER['PHP_SELF']);

$permissions = [
    'super_admin' => ['dashboard.php', 'music.php', 'events.php', 'gallery.php', 'applications.php', 'settings.php', 'user_roles.php'],
    'editor' => ['dashboard.php', 'music.php', 'events.php', 'gallery.php', 'applications.php'],
    'viewer' => ['dashboard.php']
];

// Restrict access if the user role is not allowed on this page
if (!in_array($page, $permissions[$role])) {
    header("Location: dashboard.php");
    exit();
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: users.php");
    exit();
}

// Handle new user creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    $stmt->close();
    header("Location: users.php");
    exit();
}

// Handle password reset via email
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_email'])) {
    $email = $_POST['email'];
    $result = $conn->query("SELECT id FROM users WHERE email = '$email'");
    
    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $conn->query("UPDATE users SET reset_token = '$token' WHERE email = '$email'");
        
        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";
        $headers = "From: no-reply@yourwebsite.com";
        
        mail($email, $subject, $message, $headers);
        echo "Password reset email sent.";
    } else {
        echo "Email not found.";
    }
}

$user_list = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="users-container">
        <h2>Manage Admin Users</h2>
        
        <h3>Add New User</h3>
        <form method="POST">
            <input type="hidden" name="create_user" value="1">
            <label>Username:</label>
            <input type="text" name="username" required><br>
            
            <label>Email:</label>
            <input type="email" name="email" required><br>
            
            <label>Password:</label>
            <input type="password" name="password" required><br>
            
            <button type="submit">Add User</button>
        </form>
        
        <h3>Reset Password via Email</h3>
        <form method="POST">
            <input type="hidden" name="reset_email" value="1">
            <label>Email:</label>
            <input type="email" name="email" required>
            <button type="submit">Send Reset Email</button>
        </form>
        
        <h3>Existing Users</h3>
        <ul>
            <?php while ($row = $user_list->fetch_assoc()): ?>
                <li>
                    <?php echo $row['username']; ?> (<?php echo $row['email']; ?>)
                    <a href="users.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
