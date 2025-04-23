<?php
// register_admin.php - Register New Admin Account

// Include database connection
include '../db.php';

// Check if an admin account already exists
$result = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'admin'");
$row = $result->fetch_assoc();
if ($row['total'] > 0) {
    // Redirect if admin already exists
    header("Location: index.php"); // Or any page that shows a message like "Admin already exists."
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password before storing
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert new admin into the database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password_hash, role) VALUES (?, ?, ?, ?, ?, 'admin')");
    $stmt->bind_param("sssss", $first_name, $last_name, $username, $email, $password_hash);
    if ($stmt->execute()) {
        // Redirect to index.php after successful creation
        header("Location: index.php"); 
        exit();
    } else {
        $error_message = "Error creating admin account. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            color: green;
            text-align: center;
            margin-top: 20px;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Create Admin Account</h1>
        <form method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required>
            
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required>
            
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">Create Admin</button>
        </form>

        <!-- Show success or error message below the form -->
        <?php
        if (isset($error_message)) {
            echo '<div class="error">' . $error_message . '</div>';
        }
        ?>
    </div>

</body>
</html>
