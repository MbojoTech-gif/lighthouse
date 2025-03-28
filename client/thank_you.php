<?php
session_start();
include '../backend/db.php';  // Go up one level from 'client' and then access 'backend/db.php'
include '../backend/auth.php'; // Go up one level from 'client' and then access 'backend/auth.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="../styles/style.css">

</head>
<body>
<section class="header">
        <nav>
            <a href="index.html"><img src="src/logo.png"></a>
            <p><b><button>LIGHTHOUSE MINISTERS NRB</button></b></p>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                <li><a href="index.php">HOME</a></li>
                        <li><a href="about.php">ABOUT</a></li>
                        <li><a href="gallery.php">GALLERY</a></li>
                        <li><a href="events.php">EVENTS</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
                        <li><button><a href="login.php" class="login-btn">Login</a></button></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
    <section class="thank-you-container">
        <h2>Thank You for Joining Us!</h2>
        <p>Your application has been submitted successfully. We will review your information and get back to you shortly.</p>
        <a href="index.php">Go back to Home</a>
    </section>
</body>
</html>
