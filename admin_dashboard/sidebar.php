<?php 
$current_page = basename($_SERVER['PHP_SELF']); 
?>

<head>
    <style>
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(45deg, #1403a5, #4ac502);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding: 20px;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
            margin: 5px 0;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgb(199, 5, 5);
        }

        /* Active page link style */
        .sidebar .active {
            background-color: rgb(0, 123, 255); /* Highlight active page */
        }
    </style>
</head>

<div class="sidebar">
    <h2>Lighthouse Ministers</h2>
    <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
    <a href="music.php" class="<?php echo ($current_page == 'music.php') ? 'active' : ''; ?>">Manage Music</a>
    <a href="events.php" class="<?php echo ($current_page == 'events.php') ? 'active' : ''; ?>">Manage Events</a>
    <a href="gallery.php" class="<?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Manage Gallery</a>
    <a href="applications.php" class="<?php echo ($current_page == 'applications.php') ? 'active' : ''; ?>">Manage Applications</a>
    <a href="users.php" class="<?php echo ($current_page == 'users.php') ? 'active' : ''; ?>">Manage Users</a>
    <a href="logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">Logout</a>
</div>
