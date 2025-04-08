<?php
session_start();
include '../db.php'; // Connect to the database

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch all events from the database
$events_query = "SELECT * FROM events ORDER BY event_date DESC";
$events_result = $conn->query($events_query);

// Handle Event Deletion
if (isset($_GET['delete'])) {
    $event_id = $_GET['delete'];
    $delete_query = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
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
            border-radius: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        h3 {
            color: #555;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f8f9fa;
            color: #333;
        }

        table td {
            color: #555;
        }

        table a {
            color: #007bff;
            text-decoration: none;
        }

        table a:hover {
            text-decoration: underline;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            width: 140px;
        }

        .actions a {
            background-color: #f8f9fa;
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .actions a.delete {
            background-color: #dc3545;
            color: white;
        }

        .actions a.delete:hover {
            background-color: #c82333;
        }

        .actions a.edit {
            background-color: #007bff;
            color: white;
        }

        .actions a.edit:hover {
            background-color: #0056b3;
        }

        .event-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Manage Events</h2>

        <a href="add_event.php" class="btn">Add New Event</a>

        <h3>Event List</h3>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Image</th> <!-- New column for the image -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($event = $events_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $event['title']; ?></td>
                        <td><?php echo $event['event_name']; ?></td>
                        <td><?php echo date("F j, Y", strtotime($event['event_date'])); ?></td>
                        <td><?php echo $event['location']; ?></td>
                        <td><?php echo substr($event['description'], 0, 100); ?>...</td>
                        
                        <!-- Display image if exists -->
                        <td>
                            <?php if ($event['event_image']): ?>
                                <img src="../src/<?php echo htmlspecialchars($event['event_image']); ?>" alt="Event Image" class="event-image">
                            <?php else: ?>
                                <p>No Image</p>
                            <?php endif; ?>
                        </td>

                        <td class="actions">
                            <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="edit">Edit</a>
                            <a href="manage_events.php?delete=<?php echo $event['id']; ?>" class="delete" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
