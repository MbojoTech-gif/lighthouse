<?php
// gallery.php - Manage Gallery
session_start();
include 'sidebar.php';
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

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['gallery_file'])) {
    $file = $_FILES['gallery_file'];
    
    $upload_dir = 'uploads/gallery/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_path = $upload_dir . basename($file['name']);
    
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        $stmt = $conn->prepare("INSERT INTO gallery (file_path) VALUES (?)");
        $stmt->bind_param("s", $file_path);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

// Handle file deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("SELECT file_path FROM gallery WHERE id = ?");
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
    <div class="gallery-container">
        <h2>Manage Gallery</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="gallery_file" accept="image/*,video/*" required><br>
            <button type="submit">Upload</button>
        </form>
        <h3>Gallery</h3>
        <div class="gallery-grid">
            <?php while ($row = $gallery_list->fetch_assoc()): ?>
                <div class="gallery-item">
                    <?php 
                    $file_path = $row['file_path'];
                    $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);
                    if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo "<img src='$file_path' width='150'>";
                    } else {
                        echo "<video width='150' controls><source src='$file_path' type='video/mp4'></video>";
                    }
                    ?>
                    <a href="gallery.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
