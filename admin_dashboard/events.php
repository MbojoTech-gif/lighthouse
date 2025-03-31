<?php
// events.php - Manage Events
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

// Handle event addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_location = $_POST['event_location'];
    
    $stmt = $conn->prepare("INSERT INTO events (event_name, event_date, event_location) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $event_name, $event_date, $event_location);
    $stmt->execute();
    $stmt->close();
}

// Handle event deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: events.php");
    exit();
}

$event_list = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="events-container">
        <h2>Manage Events</h2>
        <form method="POST">
            <input type="text" name="event_name" placeholder="Event Name" required><br>
            <input type="date" name="event_date" required><br>
            <input type="text" name="event_location" placeholder="Event Location" required><br>
            <button type="submit">Add Event</button>
        </form>
        <h3>Upcoming Events</h3>
        <ul>
            <?php while ($row = $event_list->fetch_assoc()): ?>
                <li>
                    <?php echo $row['event_name'] . " - " . $row['event_date'] . " at " . $row['event_location']; ?>
                    <a href="events.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
