<?php
session_start();
include '../db.php'; // Connect to the database

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Handle the form submission for adding a new photo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $section = $_POST['section'];

    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);

        // Set allowed image types
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            // Define the upload directory (use relative path)
            $upload_dir = "../src/"; // Using forward slashes
            $image_name_unique = uniqid('gallery_', true) . '.' . $image_extension;
            $image_path = $upload_dir . $image_name_unique;

            // Move the uploaded image to the server
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Insert the gallery photo details into the database
                $insert_query = "INSERT INTO gallery (title, description, image_path, section) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("ssss", $title, $description, $image_name_unique, $section);

                if ($stmt->execute()) {
                    $message = "Photo added successfully!";
                } else {
                    $message = "Error adding photo.";
                }
                $stmt->close();
            } else {
                $message = "Error uploading the image.";
            }
        } else {
            $message = "Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        $message = "Please upload an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Photo - Admin</title>
    <link rel="stylesheet" href="style.css">
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        textarea,
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus,
        input[type="file"]:focus,
        select:focus {
            border-color: #007BFF;
            outline: none;
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
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            color: green;
            text-align: center;
            margin-top: 20px;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="content">
        <h2>Add New Photo</h2>

        <?php if (isset($message)): ?>
            <div class="message"><?= $message; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label for="title">Photo Title:</label>
            <input type="text" name="title" required>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea>

            <label for="section">Section:</label>
            <select name="section" required>
                <option value="ASSOCIATES">ASSOCIATES</option>
                <option value="LEADERSHIP">LEADERSHIP</option>
                <option value="MEMBERS">MEMBERS</option>
            </select>

            <label for="image">Upload Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">Add Photo</button>
        </form>

        <a href="manage_gallery.php" class="back-btn">Back to Gallery</a>
    </div>

</body>
</html>
