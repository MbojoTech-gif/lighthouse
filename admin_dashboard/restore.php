<?php
// restore.php - Database Restore
session_start();
include 'sidebar.php';
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: dashboard.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['backup_file'])) {
    $backupFile = $_FILES['backup_file']['tmp_name'];
    
    $command = "mysql --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} < $backupFile";
    system($command);
    
    echo "<p>Database restored successfully!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restore Database</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Restore Database</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="backup_file" required>
            <button type="submit">Restore Backup</button>
        </form>
    </div>
</body>
</html>
