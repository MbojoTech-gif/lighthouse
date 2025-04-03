<?php
// dashboard.php - Admin Dashboard with Advanced Analytics
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Define role-based access restrictions
$role = $_SESSION['role'];
$page = basename($_SERVER['PHP_SELF']);

$permissions = [
    'super_admin' => ['dashboard.php', 'music.php', 'events.php', 'gallery.php', 'applications.php', 'settings.php', 'user_roles.php'],
    'editor' => ['dashboard.php', 'music.php', 'events.php', 'gallery.php', 'applications.php'],
    'viewer' => ['dashboard.php']
];

// Restrict access if the user role is not allowed on this page
if (!in_array($page, $permissions[$role])) {
    header("Location: dashboard.php");
    exit();
}

// Fetch counts
$songs_count = $conn->query("SELECT COUNT(*) AS total FROM music")->fetch_assoc()['total'];
$events_count = $conn->query("SELECT COUNT(*) AS total FROM events")->fetch_assoc()['total'];
$gallery_count = $conn->query("SELECT COUNT(*) AS total FROM gallery")->fetch_assoc()['total'];
$applications_count = $conn->query("SELECT COUNT(*) AS total FROM applications")->fetch_assoc()['total'];
$users_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];

// Fetch recent applications
$recent_apps = $conn->query("SELECT users.first_name, users.last_name, users.email 
FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lighthouse Ministers</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Basic layout styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
            padding: 0;
        }

        /* Content Area */
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s ease;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding: 20px;
            overflow-y: auto;
            transition: all 0.3s ease;
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
            background-color:rgb(177, 7, 7);
        }

        /* Active sidebar item */
        .sidebar a.active {
            background-color: rgb(10, 120, 255);
        }

        /* Charts */
        .charts-container {
            display: block;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 30px;
            width: 50%;
            text-align: center;
        }

        .chart-box {
            flex: 2 1 40%;
            min-width: 200px;
            height: 250px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0px 4px 6px rgb(0, 0, 0);
            padding: 10px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .content {
                margin-left: 0;
                width: 90%;
            }

            .charts-container {
                flex-direction: column;
                gap: 15px;
                width: 100%;
            }

            .chart-box {
                width: 100%;
                max-width: 100%;
                height: 200px;
            }
        }

        /* Recent Applications */
        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Lighthouse Ministers</h2>
    <a href="dashboard.php">Dashboard</a>
<a href="music.php">Manage Music</a>
<a href="events.php">Manage Events</a>
<a href="gallery.php">Manage Gallery</a>
<a href="applications.php">Manage Applications</a>
<a href="users.php">Manage Users</a>
<a href="logout.php">Logout</a>

</div>

    <!-- Content Area -->
    <div class="content">
        <h2>Dashboard Overview</h2>
        
        <!-- Recent Applications -->
        <h3>Recent Applications</h3>
        <ul>
            <?php while ($app = $recent_apps->fetch_assoc()): ?>
                <li><?php echo $app['first_name'] . " " . $app['last_name'] . " - " . $app['email']; ?></li>
            <?php endwhile; ?>
        </ul>

        <!-- Charts Container -->
        <div class="charts-container">
            <div class="chart-box">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Chart.js Script -->
    <script>
        // Chart for Dashboard Total Counts
        new Chart(document.getElementById('dashboardChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Songs', 'Events', 'Gallery', 'Applications', 'Users'],
                datasets: [{
                    label: 'Total Count',
                    data: [<?php echo "$songs_count, $events_count, $gallery_count, $applications_count, $users_count"; ?>],
                    backgroundColor: ['#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6']
                }]
            }
        });
    </script>
</body>
</html>
