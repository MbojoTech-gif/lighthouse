<?php
session_start();
include '../db.php'; // Connect to the database

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Check if event ID is provided
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Fetch event data from the database
    $query = "SELECT id, title, event_name, event_date, location, description, event_image, created_at FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->store_result();

    // Check if the query returned any results
    if ($stmt->num_rows > 0) {
        // Bind result variables for the selected event
        $stmt->bind_result($id, $title, $event_name, $event_date, $location, $description, $event_image, $created_at);
        $stmt->fetch();
    } else {
        echo "Event not found.";
        exit();
    }

    // Update event data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $event_name = $_POST['event_name'];
        $event_date = $_POST['event_date'];
        $location = $_POST['location'];
        $description = $_POST['description'];

        // Handle image upload if a file is selected
        $image_name = $event_image; // Keep existing image if no new one is uploaded

        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] == 0) {
            $image_tmp_name = $_FILES['event_image']['tmp_name'];
            $image_name = "event_" . $event_id . "_" . basename($_FILES['event_image']['name']);
            $image_path = "C:/xampp/htdocs/TLHM/client/src/" . $image_name;  // Save the image in the 'src' folder

            // Move uploaded file to the src directory
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Image uploaded successfully, update event with new image
            } else {
                echo "Error uploading image.";
                exit();
            }
        }

        // Update the event
        $update_query = "UPDATE events SET title = ?, event_name = ?, event_date = ?, location = ?, description = ?, event_image = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssssssi", $title, $event_name, $event_date, $location, $description, $image_name, $event_id);

        if ($stmt->execute()) {
            header("Location: manage_events.php");
            exit();
        } else {
            echo "Error updating event.";
        }
    }
} else {
    echo "Event ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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

        .current-image {
            max-width: 200px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="content">
        <h2>Edit Event</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Event Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" value="<?php echo htmlspecialchars($event_name); ?>" required>

            <label for="event_date">Event Date:</label>
            <input type="date" name="event_date" value="<?php echo htmlspecialchars($event_date); ?>" required>

            <label for="location">Location:</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>

            <label for="description">Event Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($description); ?></textarea>

            <label for="event_image">Event Image (Optional):</label>
            <input type="file" name="event_image" accept="image/*">

            <!-- Display the current image if available -->
            <?php if ($event_image): ?>
                <p>Current Image:</p>
                <img src="../src/<?php echo basename($event_image); ?>" alt="Event Image" class="current-image">
            <?php endif; ?>

            <button type="submit">Update Event</button>
        </form>
    </div>

</body>
</html>
