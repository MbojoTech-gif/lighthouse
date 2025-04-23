<?php
$host = "127.0.0.1"; // Use IP instead of "localhost"
$user = "root";
$password = ""; // Replace with the correct password
$database = "lhm_nrb";
$port = 3306; // Specify the correct port

// Create connection
$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
