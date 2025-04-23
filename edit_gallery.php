<?php
session_start();
include '../db.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch existing gallery photo by ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_gallery.php");
    exit();
}

$id = $_GET['id'];

// Get existing data
$stmt = $conn->prepare("SELECT * FROM gallery WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$photo = $result->fetch_assoc();

if (!$photo) {
    echo "Photo not found.";
    exit();
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $section = $_POST['section'];
    $new_image = $photo['image_path']; // Default to existing image

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($extension), $allowed)) {
            $upload_dir = "../src/";
            $unique_name = uniqid('gallery_', true) . '.' . $extension;
            $image_path = $upload_dir . $unique_name;

            if (move_uploaded_file($tmp_name, $image_path)) {
                $new_image = $unique_name;
            } else {
                $message = "Error uploading new image.";
            }
        } else {
            $message = "Invalid image format.";
        }
    }

    if (empty($message)) {
        $update = $conn->prepare("UPDATE gallery SET title = ?, description = ?, section = ?, image_path = ? WHERE id = ?");
        $update->bind_param("ssssi", $title, $description, $section, $new_image, $id);

        if ($update->execute()) {
            header("Location: manage_gallery.php");
            exit();
        } else {
            $message = "Error updating gallery.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Gallery Photo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .content {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
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
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .current-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .current-image img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
        }

        .message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="content">
    <h2>Edit Gallery Photo</h2>

    <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="title">Photo Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($photo['title']) ?>" required>

        <label for="description">Description</label>
        <textarea name="description" required><?= htmlspecialchars($photo['description']) ?></textarea>

        <label for="section">Section</label>
        <select name="section" required>
            <option value="ASSOCIATES" <?= $photo['section'] == 'ASSOCIATES' ? 'selected' : '' ?>>ASSOCIATES</option>
            <option value="LEADERSHIP" <?= $photo['section'] == 'LEADERSHIP' ? 'selected' : '' ?>>LEADERSHIP</option>
            <option value="MEMBERS" <?= $photo['section'] == 'MEMBERS' ? 'selected' : '' ?>>MEMBERS</option>
        </select>

        <div class="current-image">
            <label>Current Image:</label><br>
            <img src="../src/<?= htmlspecialchars($photo['image_path']) ?>" alt="Current Photo">
        </div>

        <label for="image">Upload New Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Update Photo</button>
    </form>
</div>

</body>
</html>
