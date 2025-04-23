<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Lighthouse Ministers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: url('assets/images/music-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #001f3f;
            color: #fff;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px 10px;
            font-size: 22px;
            background-color: #003366;
            margin: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            border-bottom: 1px solid #004080;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #28a745;
        }

        .sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            flex-grow: 1;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            overflow-y: auto;
            transition: margin-left 0.3s;
        }

        .logout-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #cc0000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #a30000;
        }

        .menu-toggle {
            display: none;
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 24px;
            background-color: #003366;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1001;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                height: 100%;
                top: 0;
                left: 0;
                z-index: 1000;
            }

            .menu-toggle {
                display: block;
            }

            .main-content {
                padding-top: 60px;
            }
        }
    </style>
</head>
<body>

    <!-- Mobile Menu Toggle Button -->
    <div class="menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h2>Lighthouse-Admin</h2>
            <ul>
                <li><a href="#" onclick="loadContent('manage_events.php')"><i class="fas fa-calendar-alt"></i>Manage Events</a></li>
                <li><a href="#" onclick="loadContent('manage_gallery.php')"><i class="fas fa-images"></i>Manage Gallery</a></li>
                <li><a href="#" onclick="loadContent('manage_applications.php')"><i class="fas fa-envelope-open-text"></i>Manage Applications</a></li>
                <li><a href="#" onclick="loadContent('manage_users.php')"><i class="fas fa-users-cog"></i>Manage Users</a></li>
                <li><a href="#" onclick="loadContent('reports.php')"><i class="fas fa-chart-line"></i>Reports</a></li>
                <li><a href="#" onclick="loadContent('settings.php')"><i class="fas fa-cog"></i>Settings</a></li>
            </ul>
            <form action="logout.php" method="POST">
                <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <h1>Welcome to the Admin Dashboard</h1>
            <p>Select a section from the sidebar to manage content.</p>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        function toggleSidebar() {
            sidebar.classList.toggle('collapsed');
        }

        function loadContent(page) {
            fetch(page)
                .then(res => res.text())
                .then(html => {
                    mainContent.innerHTML = html;
                    if (window.innerWidth <= 768) {
                        sidebar.classList.add('collapsed'); // Auto-hide on mobile
                    }
                })
                .catch(err => {
                    mainContent.innerHTML = '<p>Error loading content.</p>';
                    console.error(err);
                });
        }
    </script>

</body>
</html>
