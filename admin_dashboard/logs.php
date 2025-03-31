<?php
// logs.php - View System Logs
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: dashboard.php");
    exit();
}
include 'db.php';

$result = $conn->query("SELECT logs.id, users.name AS admin_name, logs.action, logs.timestamp FROM logs JOIN users ON logs.admin_id = users.id ORDER BY logs.timestamp DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>System Logs</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>System Logs</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Admin</th>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['admin_name']; ?></td>
                <td><?php echo $row['action']; ?></td>
                <td><?php echo $row['timestamp']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
