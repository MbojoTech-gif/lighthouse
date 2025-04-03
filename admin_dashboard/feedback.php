<?php
// feedback.php - Admin Feedback Management
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Fetch feedback messages
$feedback = $conn->query("SELECT * FROM feedback ORDER BY created_at DESC");

// Delete a message
if (isset($_POST['delete'])) {
    $feedback_id = $_POST['feedback_id'];
    $conn->query("DELETE FROM feedback WHERE id = $feedback_id");
    header("Location: feedback.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Messages</title>
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
        <h2>Feedback Messages</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $feedback->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
