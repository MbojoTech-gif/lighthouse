<?php
$host = "127.0.0.1"; // Use IP instead of "localhost"
$user = "root";
$password = "Mbojo@2021"; // Replace with the correct password
$database = "lighthouse_ministers";
$port = 3306; // Specify the correct port

// Create connection
$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>
