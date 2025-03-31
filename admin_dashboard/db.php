<?php
// db.php - Database connection
$host = 'localhost';
$user = 'root'; // Change this if using a different user
$pass = ''; // Add password if needed
$dbname = 'lighthouse_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
