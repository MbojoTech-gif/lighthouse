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
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Header (Navigation) */
        .header {
            background-color: #2C3E50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            position: relative;
        }

        .header nav img {
            height: 50px;
            width: auto;
            margin-right: 15px;
        }

        .header nav h6 {
            display: inline-block;
            font-weight: bold;
            margin-left: 10px;
            vertical-align: middle;
            font-size: 1.2rem;
        }

        .nav-links ul {
            list-style: none;
            margin-top: 10px;
        }

        .nav-links ul li {
            display: inline;
            margin: 0 15px;
        }

        .nav-links ul li a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            font-weight: normal;
        }

        .nav-links ul li a:hover {
            color: #1ABC9C;
        }

        .fa-bars, .fa-times {
            display: none;
        }

        /* Thank You Section */
        .thank-you-container {
            padding: 50px;
            background-color: #fff;
            text-align: center;
            border-radius: 8px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .thank-you-container h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #27AE60;
        }

        .thank-you-container p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #555;
        }

        .thank-you-container a {
            font-size: 1.1rem;
            color: #27AE60;
            text-decoration: none;
            border: 2px solid #27AE60;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .thank-you-container a:hover {
            background-color: #27AE60;
            color: white;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .nav-links ul {
                display: none;
                text-align: center;
            }

            .nav-links i {
                display: block;
                font-size: 2rem;
                cursor: pointer;
                color: white;
                margin: 10px 0;
            }

            .nav-links.active ul {
                display: block;
            }

            .nav-links ul li {
                display: block;
                margin: 15px 0;
            }

            .nav-links ul li a {
                font-size: 1.5rem;
            }

            .thank-you-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<section class="header">
    <nav>
        <img src="src/logo.png" alt="Logo">
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
</section>

<section class="thank-you-container">
    <h2>Thank You for Joining Us!</h2>
    <p>Your application has been submitted successfully. We will review your information and get back to you shortly.</p>
    <a href="index.php">Go back to Home</a>
</section>

<script>
    function showMenu() {
        document.getElementById('navLinks').classList.add('active');
    }

    function hideMenu() {
        document.getElementById('navLinks').classList.remove('active');
    }
</script>
</body>
</html>
