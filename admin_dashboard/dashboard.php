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

// Fetch applications per month
$applications_per_month = $conn->query("SELECT DATE_FORMAT(submitted_at, '%Y-%m') AS month, COUNT(*) AS total FROM applications GROUP BY month ORDER BY month ASC");
$months = [];
$app_counts = [];
while ($row = $applications_per_month->fetch_assoc()) {
    $months[] = $row['month'];
    $app_counts[] = $row['total'];
}

// Fetch most active users
$active_users = $conn->query("SELECT users.name, COUNT(applications.id) AS total_apps FROM users JOIN applications ON users.id = applications.user_id GROUP BY users.id ORDER BY total_apps DESC LIMIT 5");
$user_names = [];
$user_apps = [];
while ($row = $active_users->fetch_assoc()) {
    $user_names[] = $row['name'];
    $user_apps[] = $row['total_apps'];
}

// Fetch peak activity hours
$activity_hours = $conn->query("SELECT HOUR(submitted_at) AS hour, COUNT(*) AS total FROM applications GROUP BY hour ORDER BY hour ASC");
$hours = [];
$hour_counts = [];
while ($row = $activity_hours->fetch_assoc()) {
    $hours[] = $row['hour'] . ':00';
    $hour_counts[] = $row['total'];
}

// Fetch most popular songs
$popular_songs = $conn->query("SELECT title, play_count FROM music ORDER BY play_count DESC LIMIT 5");
$song_titles = [];
$song_counts = [];
while ($row = $popular_songs->fetch_assoc()) {
    $song_titles[] = $row['title'];
    $song_counts[] = $row['play_count'];
}

// Fetch event attendance trends
$event_attendance = $conn->query("SELECT events.title, COUNT(event_registrations.id) AS attendees FROM events LEFT JOIN event_registrations ON events.id = event_registrations.event_id GROUP BY events.id ORDER BY attendees DESC LIMIT 5");
$event_titles = [];
$event_attendees = [];
while ($row = $event_attendance->fetch_assoc()) {
    $event_titles[] = $row['title'];
    $event_attendees[] = $row['attendees'];
}

// Fetch recent applications
$recent_apps = $conn->query("SELECT name, email, submitted_at FROM applications ORDER BY submitted_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        
        <canvas id="dashboardChart" width="400" height="200"></canvas>
        <canvas id="applicationsChart" width="400" height="200"></canvas>
        <canvas id="activeUsersChart" width="400" height="200"></canvas>
        <canvas id="activityHoursChart" width="400" height="200"></canvas>
        <canvas id="popularSongsChart" width="400" height="200"></canvas>
        <canvas id="eventAttendanceChart" width="400" height="200"></canvas>
        
        <script>
            new Chart(document.getElementById('dashboardChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Songs', 'Events', 'Gallery', 'Applications', 'Users'],
                    datasets: [{
                        label: 'Total Count',
                        data: [<?php echo "$songs_count, $events_count, $gallery_count, $applications_count, $users_count"; ?>],
                        backgroundColor: ['red', 'blue', 'green', 'orange', 'purple']
                    }]
                }
            });
            
            new Chart(document.getElementById('applicationsChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [{
                        label: 'Applications Per Month',
                        data: <?php echo json_encode($app_counts); ?>,
                        borderColor: 'blue',
                        fill: false
                    }]
                }
            });
            
            new Chart(document.getElementById('popularSongsChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($song_titles); ?>,
                    datasets: [{
                        label: 'Most Popular Songs',
                        data: <?php echo json_encode($song_counts); ?>,
                        backgroundColor: 'green'
                    }]
                }
            });
            
            new Chart(document.getElementById('eventAttendanceChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($event_titles); ?>,
                    datasets: [{
                        label: 'Event Attendance',
                        data: <?php echo json_encode($event_attendees); ?>,
                        backgroundColor: 'orange'
                    }]
                }
            });
        </script>
        
        <h3>Recent Applications</h3>
        <ul>
            <?php while ($app = $recent_apps->fetch_assoc()): ?>
                <li><?php echo $app['name'] . " - " . $app['email'] . " (" . $app['submitted_at'] . ")"; ?></li>
            <?php endwhile; ?>
        </ul>
        
        <h3>Quick Links</h3>
        <ul>
            <li><a href="music.php">Manage Music</a></li>
            <li><a href="events.php">Manage Events</a></li>
            <li><a href="gallery.php">Manage Gallery</a></li>
            <li><a href="applications.php">Manage Applications</a></li>
            <li><a href="users.php">Manage Users</a></li>
            <li><a href="settings.php">Settings</a></li>
        </ul>
    </div>
</body>
</html>