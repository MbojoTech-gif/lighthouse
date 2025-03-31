<?php
// applications.php - Manage Applications
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

// Handle application deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM applications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: applications.php");
    exit();
}

$application_list = $conn->query("SELECT * FROM applications ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Applications</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="applications-container">
        <h2>Manage Applications</h2>
        <h3>Submitted Applications</h3>
        <ul>
            <?php while ($row = $application_list->fetch_assoc()): ?>
                <li>
                    <strong><?php echo $row['name']; ?></strong> (<?php echo $row['email']; ?>) - <?php echo $row['message']; ?>
                    <a href="applications.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
