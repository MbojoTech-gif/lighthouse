<?php
session_start();
include('db.php'); // Include your existing db.php file

// Fetch gallery members from the database
$result = mysqli_query($conn, "SELECT * FROM gallery");
// Define members
$executive_members = [
    ["name" => "Kennedy Otieno", "position" => "Chairperson", "image" => "src/f.jpg"],
    ["name" => "Alvine Olonde", "position" => "Secretary", "image" => "src/f.jpg"],
    ["name" => "Calvince Kokebe", "position" => "Welfare", "image" => "src/f.jpg"],
    ["name" => "Kevin Otieno", "position" => "Spiritual", "image" => "src/f.jpg"],
    ["name" => "Larry Nyangute", "position" => "Publicity", "image" => "src/f.jpg"],
    ["name" => "Sheila", "position" => "Treasurer", "image" => "src/f.jpg"],
];

$members = [
    ["name" => "Member 1", "image" => "src/f.jpg"],
    ["name" => "Member 2", "image" => "src/f.jpg"],
    ["name" => "Member 3", "image" => "src/f.jpg"],
    ["name" => "Member 4", "image" => "src/f.jpg"],
    ["name" => "Member 5", "image" => "src/f.jpg"],
    ["name" => "Member 6", "image" => "src/f.jpg"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lighthouse Ministers - Gallery</title>t
    <link rel="stylesheet" href="gallery.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/b29579297b.js" crossorigin="anonymous"></script>
</head>
<body>
    <section class="sub-header">
        <nav>
            <img src="src/logo.png" alt="Lighthouse Ministers Logo">
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
        <h1>Gallery</h1>
    </section>

    <section class="gallery">
        <h2>Executive Members</h2>
        <div class="gallery-grid">
            <?php foreach ($executive_members as $member): ?>
                <div class="gallery-item">
                    <img src="<?= $member['image']; ?>" alt="<?= $member['name']; ?>">
                    <h5><?= $member['position']; ?></h5>
                    <p><?= $member['name']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Members</h2>
        <div class="gallery-grid">
            <?php foreach ($members as $member): ?>
                <div class="gallery-item">
                    <img src="<?= $member['image']; ?>" alt="<?= $member['name']; ?>">
                    <p><?= $member['name']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="about.php">ABOUT</a></li>
                    <li><a href="gallery.php">GALLERY</a></li>
                    <li><a href="events.php">EVENTS</a></li>
                    <li><a href="contact.php">CONTACT</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="donate.php">Donate</a></li>
                    <li><a href="#">Sermons</a></li>
                    <li><a href="#">Ministries</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-section join-us">
                <h4>Join Us</h4>
                <p>Become a part of Lighthouse Ministers today!</p>
                <a href="join.php" class="join-btn">Join Now</a>
            </div>
            <div class="footer-section social">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-youtube"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Lighthouse Ministers. All Rights Reserved.</p>
            <p><a href="privacy-policy.php">Privacy Policy</a> | <a href="terms-of-use.php">Terms of Use</a></p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>