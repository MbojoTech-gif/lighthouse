<?php
include 'db.php'; // Ensure this file connects to the database

$email = 'techmbojo@gmail.com';
$password = password_hash('admin123', PASSWORD_BCRYPT);

// Check if the email already exists
$check_sql = "SELECT id FROM users WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo "Admin user already exists!";
} else {
    // Insert the admin user if it doesn't exist
    $sql = "INSERT INTO users (name, email, password, role) 
            VALUES ('Admin', ?, ?, 'super_admin')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    
    if ($stmt->execute()) {
        echo "Admin user created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$check_stmt->close();
$conn->close();
?>
