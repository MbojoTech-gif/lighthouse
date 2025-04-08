<?php
session_start();
include '../db.php'; // Connect to the database

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch images and descriptions for different sections from the database
$associates_query = "SELECT * FROM gallery WHERE section = 'ASSOCIATES' ORDER BY uploaded_at DESC";
$leaders_query = "SELECT * FROM gallery WHERE section = 'LEADERSHIP' ORDER BY uploaded_at DESC";
$members_query = "SELECT * FROM gallery WHERE section = 'MEMBERS' ORDER BY uploaded_at DESC"; // Updated section

$associates_result = $conn->query($associates_query);
$leaders_result = $conn->query($leaders_query);
$members_result = $conn->query($members_query); // Updated section
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - Lighthouse Ministers</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .content {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgb(0, 0, 0);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #003366;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 22px;
            color: #003366;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .gallery-item img:hover {
            transform: scale(1.1);
        }

        .gallery-item .description {
            padding: 10px;
            background-color: #003366;
            color: #fff;
            text-align: center;
        }

        .gallery-item .description p {
            margin: 0;
            font-size: 16px;
        }

        .add-photo-btn {
            display: block;
            margin: 30px auto;
            padding: 12px 24px;
            background-color: #003366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .add-photo-btn:hover {
            background-color: #005cbf;
        }

        .gallery-actions {
            display: flex;
            justify-content: flex-end;
            margin: 20px 0;
        }

        .edit-btn, .delete-btn {
            padding: 5px 10px;
            border: none;
            background-color: #28a745;
            color: white;
            margin-left: 10px;
            cursor: pointer;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Manage Gallery</h2>
        <a href="add_gallery.php" class="add-photo-btn">Add New Photo</a>

        <h3 class="section-title">ASSOCIATES</h3>
        <div class="gallery-container">
            <?php while ($photo = $associates_result->fetch_assoc()): ?>
                <div class="gallery-item">
                    <img src="../src/<?php echo htmlspecialchars($photo['image_path']); ?>" alt="Associate Photo">
                    <div class="description">
                        <p><?php echo htmlspecialchars($photo['description']); ?></p>
                    </div>
                    <div class="gallery-actions">
                        <button class="edit-btn" onclick="window.location.href='edit_gallery.php?id=<?php echo $photo['id']; ?>'">Edit</button>
                        <button class="delete-btn" onclick="window.location.href='delete_gallery.php?id=<?php echo $photo['id']; ?>'">Delete</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <h3 class="section-title">LEADERSHIP</h3>
        <div class="gallery-container">
            <?php while ($photo = $leaders_result->fetch_assoc()): ?>
                <div class="gallery-item">
                    <img src="../src/<?php echo htmlspecialchars($photo['image_path']); ?>" alt="Leadership Photo">
                    <div class="description">
                        <p><?php echo htmlspecialchars($photo['description']); ?></p>
                    </div>
                    <div class="gallery-actions">
                        <button class="edit-btn" onclick="window.location.href='edit_gallery.php?id=<?php echo $photo['id']; ?>'">Edit</button>
                        <button class="delete-btn" onclick="window.location.href='delete_gallery.php?id=<?php echo $photo['id']; ?>'">Delete</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <h3 class="section-title">MEMBERS</h3> <!-- Updated section title -->
        <div class="gallery-container">
            <?php while ($photo = $members_result->fetch_assoc()): ?>
                <div class="gallery-item">
                    <img src="../src/<?php echo htmlspecialchars($photo['image_path']); ?>" alt="Members Photo">
                    <div class="description">
                        <p><?php echo htmlspecialchars($photo['description']); ?></p>
                    </div>
                    <div class="gallery-actions">
                        <button class="edit-btn" onclick="window.location.href='edit_gallery.php?id=<?php echo $photo['id']; ?>'">Edit</button>
                        <button class="delete-btn" onclick="window.location.href='delete_gallery.php?id=<?php echo $photo['id']; ?>'">Delete</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
