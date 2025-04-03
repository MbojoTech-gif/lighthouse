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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <!-- Sidebar -->
 
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


    <!-- Content -->
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

    <style>
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(45deg, #1403a5, #4ac502);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding: 20px;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
            margin: 5px 0;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgb(199, 5, 5);
        }

        /* Active sidebar item */
        .sidebar a.active {
            background-color: rgb(10, 120, 255);
        }
    </style>
</body>
</html>
