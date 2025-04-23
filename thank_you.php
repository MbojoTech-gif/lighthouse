<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section class="header">
        <nav>
        <img src="src/logo.png">
            <h6><b>LIGHTHOUSE MINISTERS NRB</b></h6>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                <li><a href="index.php">HOME</a></li>
                        <li><a href="about.php">ABOUT</a></li>
                        <li><a href="gallery.php">GALLERY</a></li>
                        <li><a href="events.php">EVENTS</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
                        
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
