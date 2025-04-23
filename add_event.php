<?php
session_start();
include '../db.php'; // Connect to the database

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] == 0) {
        $image_name = $_FILES['event_image']['name'];
        $image_tmp_name = $_FILES['event_image']['tmp_name'];
        $image_size = $_FILES['event_image']['size'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);

        // Set allowed image types (you can add more types if needed)
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            // Define the upload directory (use relative path)
            $upload_dir = "C:/xampp/htdocs/TLHM/client/src/"; // Using forward slashes
            $image_name_unique = uniqid('event_', true) . '.' . $image_extension;
            $image_path = $upload_dir . $image_name_unique;

            // Move the uploaded image to the server
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Insert the event into the database along with the image path
                $insert_query = "INSERT INTO events (title, event_name, event_date, location, description, event_image) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("ssssss", $title, $event_name, $event_date, $location, $description, $image_name_unique);

                if ($stmt->execute()) {
                    header("Location: manage_events.php");
                    exit();
                } else {
                    echo "Error adding event.";
                }
                $stmt->close();
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        // Insert event without an image
        $insert_query = "INSERT INTO events (title, event_name, event_date, location, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssss", $title, $event_name, $event_date, $location, $description);

        if ($stmt->execute()) {
            header("Location: manage_events.php");
            exit();
        } else {
            echo "Error adding event.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
            box-shadow: 0 4px 6px rgb(0, 0, 0);
            border-radius: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        input[type="file"] {
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
        input[type="date"]:focus,
        textarea:focus,
        input[type="file"]:focus {
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
    </style>
</head>
<body>

    <div class="content">
        <h2>Add New Event</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Event Title:</label>
            <input type="text" name="title" required>

            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" required>

            <label for="event_date">Event Date:</label>
            <input type="date" name="event_date" required>

            <label for="location">Location:</label>
            <input type="text" name="location" required>

            <label for="description">Event Description:</label>
            <textarea name="description" required></textarea>

            <label for="event_image">Event Image:</label>
            <input type="file" name="event_image" accept="image/*">

            <button type="submit">Add Event</button>
        </form>
    </div>

</body>
</html>
