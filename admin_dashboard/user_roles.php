<?php
// user_roles.php - Admin User Roles & Permissions
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'super_admin') {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Fetch all users
$users = $conn->query("SELECT id, name, email, role FROM users");

// Update role
if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];
    $conn->query("UPDATE users SET role = '$new_role' WHERE id = $user_id");
    header("Location: user_roles.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage User Roles</title>
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
        <h2>Manage User Roles</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <select name="role">
                            <option value="super_admin" <?php if ($row['role'] == 'super_admin') echo 'selected'; ?>>Super Admin</option>
                            <option value="editor" <?php if ($row['role'] == 'editor') echo 'selected'; ?>>Editor</option>
                            <option value="viewer" <?php if ($row['role'] == 'viewer') echo 'selected'; ?>>Viewer</option>
                        </select>
                        <button type="submit" name="update_role">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
