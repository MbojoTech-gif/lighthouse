<?php
// gallery.php - Manage Gallery
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


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

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['gallery_file'])) {
    $caption = $_POST['caption'];
    $event_id = $_POST['event_id'];  // Event ID can be entered by admin
    $file = $_FILES['gallery_file'];
    
    $upload_dir = 'uploads/gallery/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_path = $upload_dir . basename($file['name']);
    
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        $stmt = $conn->prepare("INSERT INTO gallery (event_id, image_url, caption) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $event_id, $file_path, $caption);
        $stmt->execute();
        $stmt->close();
        echo "Image uploaded successfully!";
    } else {
        echo "Error uploading file.";
    }
}

// Handle file deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("SELECT image_url FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();
    
    if ($file_path && file_exists($file_path)) {
        unlink($file_path);
    }
    
    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: gallery.php");
    exit();
}

$gallery_list = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Gallery</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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

    <div class="gallery-container">
        <h2>Manage Gallery</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="number" name="event_id" placeholder="Enter Event ID" required><br>
            <input type="text" name="caption" placeholder="Enter Caption" required><br>
            <input type="file" name="gallery_file" accept="image/*,video/*" required><br>
            <button type="submit">Upload</button>
        </form>
        
        <h3>Gallery</h3>
        <div class="gallery-grid">
            <?php while ($row = $gallery_list->fetch_assoc()): ?>
                <div class="gallery-item">
                    <?php 
                    $file_path = $row['image_url'];
                    $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);
                    if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo "<img src='$file_path' width='150'>";
                    } else {
                        echo "<video width='150' controls><source src='$file_path' type='video/mp4'></video>";
                    }
                    ?>
                    <p><?php echo $row['caption']; ?></p>
                    <a href="gallery.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
