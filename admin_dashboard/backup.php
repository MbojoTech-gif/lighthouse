<?php
// backup.php - Database Backup
session_start();
include 'sidebar.php';
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: dashboard.php");
    exit();
}
include 'db.php';

$backupFile = 'backups/db_backup_' . date("Y-m-d_H-i-s") . '.sql';
$command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > $backupFile";
system($command);

echo "<p>Backup created: <a href='$backupFile'>Download</a></p>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Backup Database</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Backup Database</h2>
        <form method="POST">
            <button type="submit">Create Backup</button>
        </form>
    </div>
</body>
</html>
