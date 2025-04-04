<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Example of role check, can be used to restrict access
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lighthouse Ministers</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            height: 100vh;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(36, 2, 99, 0.8)); /* Adding dark and blue gradient for a professional vibe */
            color: #fff;
        }

        .sidebar {
            width: 250px;
            background-color: #003366; /* Dark blue background */
            padding-top: 20px;
            padding-left: 20px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.15);
        }

        .sidebar h2 {
            color: #fff;
            font-size: 24px;
            margin-bottom: 40px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 20px;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar 
        .logout-btn {
            display: block;
            margin: 40px auto;
            padding: 10px 25px;
            background-color:rgb(102, 7, 0); /* Dark blue */
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            text-align: center;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #28a745; /* Green color on hover */
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            flex-grow: 1;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            max-width: 800px;
            margin: 0 auto;
            height: 100%;
            overflow-y: auto;
        }

        .logout-btn:hover {
            background-color: #005cbf; /* Lighter blue on hover */
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="#" onclick="loadContent('manage_events.php')">Manage Events</a></li>
            <li><a href="#" onclick="loadContent('manage_gallery.php')">Manage Gallery</a></li>
            <li><a href="#" onclick="loadContent('manage_applications.php')">Manage Applications</a></li>
            <li><a href="#" onclick="loadContent('manage_users.php')">Manage Users</a></li>
            <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content" id="main-content">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Select an option from the sidebar to manage content.</p>
    </div>

    <script>
        // Function to load content dynamically
        function loadContent(page) {
            fetch(page)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('main-content').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('main-content').innerHTML = 'Error loading content.';
                    console.error('Error loading content:', error);
                });
        }
    </script>

</body>
</html>
