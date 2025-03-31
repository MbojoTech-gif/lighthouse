<?php
// log_activity.php - Function to Log Admin Actions
include 'db.php';

function logActivity($admin_id, $action) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO logs (admin_id, action, timestamp) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $admin_id, $action);
    $stmt->execute();
    $stmt->close();
}
?>