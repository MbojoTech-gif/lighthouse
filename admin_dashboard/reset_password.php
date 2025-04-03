<?php
// reset_password.php - Handle password reset
include 'db.php';


if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $conn->query("SELECT id FROM users WHERE reset_token = '$token'");
    
    if ($result->num_rows == 0) {
        die("Invalid or expired token.");
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        $conn->query("UPDATE users SET password = '$new_password', reset_token = NULL WHERE reset_token = '$token'");
        echo "Password successfully reset! <a href='index.php'>Login</a>";
        exit();
    }
} else {
    die("No token provided.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>


<div class="sidebar">
    <h2>Lighthouse Ministers</h2>
    <a href="dashboard.php">Dashboard</a>
<a href="music.php">Manage Music</a>
<a href="events.php">Manage Events</a>
<a href="gallery.php">Manage Gallery</a>
<a href="applications.php">Manage Applications</a>
<a href="users.php">Manage Users</a>
<a href="logout.php">Logout</a>

</div>

    <div class="reset-container">
        <h2>Reset Your Password</h2>
        <form method="POST">
            <label>New Password:</label>
            <input type="password" name="new_password" required><br>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>