<?php
// music.php - Manage Music Uploads
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

// Handle music upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['music_file'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $file = $_FILES['music_file'];
    
    $upload_dir = 'uploads/music/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_path = $upload_dir . basename($file['name']);
    
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        $stmt = $conn->prepare("INSERT INTO music (title, artist, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $artist, $file_path);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

// Handle music deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("SELECT file_path FROM music WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();
    
    if ($file_path && file_exists($file_path)) {
        unlink($file_path);
    }
    
    $stmt = $conn->prepare("DELETE FROM music WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: music.php");
    exit();
}

$music_list = $conn->query("SELECT * FROM music ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Music</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="music-container">
        <h2>Manage Music</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Song Title" required><br>
            <input type="text" name="artist" placeholder="Artist" required><br>
            <input type="file" name="music_file" accept="audio/*" required><br>
            <button type="submit">Upload</button>
        </form>
        <h3>Uploaded Songs</h3>
        <ul>
            <?php while ($row = $music_list->fetch_assoc()): ?>
                <li>
                    <?php echo $row['title'] . " by " . $row['artist']; ?>
                    <audio controls>
                        <source src="<?php echo $row['file_path']; ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <a href="music.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>