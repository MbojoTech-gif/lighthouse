<?php
// notifications.php - Admin Notifications System
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

// Fetch unread notifications
$notifications = $conn->query("SELECT * FROM notifications WHERE status = 'unread' ORDER BY created_at DESC");

// Mark as read when admin views them
if (isset($_POST['mark_read'])) {
    $conn->query("UPDATE notifications SET status = 'read' WHERE status = 'unread'");
    header("Location: notifications.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Notifications</title>
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

    <div class="dashboard-container">
        <h2>Notifications</h2>
        <form method="POST">
            <button type="submit" name="mark_read">Mark All as Read</button>
        </form>
        <ul>
            <?php while ($row = $notifications->fetch_assoc()): ?>
                <li><?php echo $row['message']; ?> - <small><?php echo $row['created_at']; ?></small></li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
