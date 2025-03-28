<?php
$host = "localhost";  // Change if using a remote server
$dbname = "lighthouse_ministers";
$username = "root";   // Change if you set a different MySQL username
$password = "";       // Change if your MySQL has a password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());

}

?>
