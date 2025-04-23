<?php
session_start();
include('../db.php'); // Adjust path based on your folder structure

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}

// Check if ID is set
if (!isset($_GET['id'])) {
    die("No image ID specified.");
}

$id = intval($_GET['id']);

// Get the image path
$query = "SELECT image_path FROM gallery WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $imagePath = '../src/' . $row['image_path']; // adjust path if needed

    // Delete file from filesystem
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete from database
    $deleteQuery = "DELETE FROM gallery WHERE id = $id";
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: manage_gallery.php?status=deleted"); // redirect back
        exit();
    } else {
        echo "Error deleting from database.";
    }
} else {
    echo "Image not found.";
}
?>
