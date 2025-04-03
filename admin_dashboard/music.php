<?php
// music.php - Manage Music Uploads
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
// Define role-based access restrictions
$role = $_SESSION['role'];
$page = basename($_SERVER['PHP_SELF']);

$permissions = [
    'super_admin' => ['dashboard.php', 'music.php', 'events.php', 'gallery.php', 'applications.php', 'settings.php', 'user_roles.php'],
    'editor' => ['dashboard.php', 'music.php', 'events.php', 'gallery.php', 'applications.php'],
    'viewer' => ['dashboard.php']
];

if (!in_array($page, $permissions[$role])) {
    header("Location: dashboard.php");
    exit();
}

// Handle music editing
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM music WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $music_to_edit = $result->fetch_assoc();
    $stmt->close();

    // Handle form submission for editing music
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_music'])) {
        $new_title = $_POST['title'];
        $new_artist = $_POST['artist'];
        
        $update_stmt = $conn->prepare("UPDATE music SET title = ?, artist = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $new_title, $new_artist, $edit_id);
        $update_stmt->execute();
        $update_stmt->close();

        header("Location: music.php");
        exit();
    }
}

// Fetch the list of all music
$music_list = $conn->query("SELECT * FROM music ORDER BY id DESC");

// Handle music upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['music_file'])) {
    // Handle file upload
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $file = $_FILES['music_file'];

    // Validate file type (audio)
    $allowed_types = ['audio/mpeg', 'audio/mp3', 'audio/wav'];
    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['error' => 'Invalid file type. Only MP3 and WAV files are allowed.']);
        exit();
    }

    // Process file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file['name']);
    
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Insert music data into database
        $stmt = $conn->prepare("INSERT INTO music (title, artist, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $artist, $target_file);
        $stmt->execute();
        $stmt->close();

        // Prepare response with the newly uploaded music data
        $new_song = [
            'id' => $conn->insert_id,
            'title' => $title,
            'artist' => $artist,
            'file_path' => $target_file
        ];

        // Set the response header to JSON
        header('Content-Type: application/json');
        echo json_encode($new_song); // Return the uploaded song details as JSON
        exit(); // Ensure we stop execution after returning the response
    } else {
        // Handle upload failure
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to upload file.']);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Music</title>
    <link rel="stylesheet" type="text/css" href="assets/css/music.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
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

    <div class="music-container">
        <h2>Manage Music</h2>

        <!-- Upload Music Form -->
        <form id="upload-form" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Song Title" required><br>
            <input type="text" name="artist" placeholder="Artist" required><br>
            <input type="file" name="music_file" accept="audio/*" required><br>
            <button type="submit">Upload Music</button>
        </form>

        <h3>Uploaded Songs</h3>

        <!-- Music Table -->
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Audio</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="music-list">
                <?php while ($row = $music_list->fetch_assoc()): ?>
                    <tr id="song-<?php echo $row['id']; ?>">
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['artist']); ?></td>
                        <td>
                            <audio controls>
                                <source src="<?php echo $row['file_path']; ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="delete-song" data-id="<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Event listener for delete button click
        $(document).on('click', '.delete-song', function() {
            var songId = $(this).data('id'); // Get the song id

            // Send an AJAX request to delete the song
            $.ajax({
                url: 'music.php', // The current page (music.php)
                type: 'GET',
                data: { delete: songId }, // Send the song ID to delete
                success: function(response) {
                    // If delete is successful, remove the row from the table
                    $('#song-' + songId).fadeOut();
                },
                error: function() {
                    alert('An error occurred while deleting the song.');
                }
            });
        });

      // Handle the song upload via AJAX
      $('#upload-form').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this); // Create FormData object

    $.ajax({
        url: 'music.php', // The current page (music.php)
        type: 'POST',
        data: formData, // Send the form data
        contentType: false,
        processData: false,
        success: function(response) {
            try {
                // Check if the response is valid JSON
                var data = response; // Assume it's JSON because we're returning JSON in PHP

                if (data.error) {
                    alert(data.error); // Handle errors
                } else {
                    // After successful upload, dynamically append the song to the table
                    var newRow = `
                        <tr id="song-${data.id}">
                            <td>${data.title}</td>
                            <td>${data.artist}</td>
                            <td>
                                <audio controls>
                                    <source src="${data.file_path}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                            <td>
                                <a href="javascript:void(0);" class="delete-song" data-id="${data.id}">Delete</a>
                            </td>
                        </tr>
                    `;
                    $('#music-list').prepend(newRow); // Add new song at the top of the list
                    $('#upload-form')[0].reset(); // Reset the form
                }
            } catch (e) {
                alert('Error parsing response. Check console for details.');
                console.error(e); // Log the error to the console for debugging
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred while uploading the song.');
            console.error('Error details:', status, error); // Log the error details
        }
    });
});

    </script>
</body>
</html>
