<?php
session_start();
include('db.php');

// Run the query to fetch gallery data
$result = mysqli_query($conn, "SELECT * FROM gallery");

if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

$associates = [];
$leadership = [];
$members = [];

// Loop through each row and separate by section
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['section'] == 'ASSOCIATES') {
        $associates[] = $row;
    } elseif ($row['section'] == 'LEADERSHIP') {
        $leadership[] = $row;
    } elseif ($row['section'] == 'MEMBERS') {
        $members[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lighthouse Ministers - Gallery</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/b29579297b.js" crossorigin="anonymous"></script>

    <style>
        .gallery {
            padding: 40px 20px;
            background-color: #f9f9f9;
        }

        .section-toggle {
            cursor: pointer;
            background-color: #eee;
            padding: 10px 20px;
            margin-bottom: 10px;
            border-left: 4px solid #555;
            font-size: 20px;
            font-weight: bold;
            color: #222;
        }

        .gallery-grid {
            display: none;
            grid-template-columns: repeat(5, 1fr); /* Set exactly 5 items per row */
            gap: 10px;
            padding: 10px 0;
        }

        .gallery-item {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgb(0, 0, 0);
            text-align: center;
            padding: 10px;
            transition: transform 0.2s ease-in-out;
        }

        .gallery-item:hover {
            transform: scale(1.03);
        }

        .gallery-item img {
            width: 100%;  /* Ensure images stretch to fit the item */
            height: auto;
            max-height: 200px;  /* Set max height for images */
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
        }

        .gallery-item p {
            margin: 6px 0;
            color: #333;
            font-size: 14px;
        }

        /* Lightbox Styles */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            background: rgb(0, 0, 0);
            align-items: center;
            justify-content: center;
            z-index: 999;
            box-shadow: 20px;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 10px;
        }

        .lightbox:target {
            display: flex;
        }

        .lightbox-close {
            position: absolute;
            top: 30px;
            right: 30px;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }
    </style>
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
        <!-- ASSOCIATES -->
        <div class="section-toggle" onclick="toggleSection(this)">ASSOCIATES</div>
        <div class="gallery-grid">
            <?php foreach ($associates as $image): ?>
                <div class="gallery-item">
                    <img src="src/<?= htmlspecialchars($image['image_path']); ?>" alt="<?= htmlspecialchars($image['title']); ?>" onclick="openLightbox(this)">
                    <p><?= htmlspecialchars($image['title']); ?></p>
                    <p><?= htmlspecialchars($image['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- LEADERSHIP -->
        <div class="section-toggle" onclick="toggleSection(this)">LEADERSHIP</div>
        <div class="gallery-grid">
            <?php foreach ($leadership as $image): ?>
                <div class="gallery-item">
                    <img src="src/<?= htmlspecialchars($image['image_path']); ?>" alt="<?= htmlspecialchars($image['title']); ?>" onclick="openLightbox(this)">
                    <p><?= htmlspecialchars($image['title']); ?></p>
                    <p><?= htmlspecialchars($image['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- MEMBERS -->
        <div class="section-toggle" onclick="toggleSection(this)">MEMBERS</div>
        <div class="gallery-grid">
            <?php foreach ($members as $image): ?>
                <div class="gallery-item">
                    <img src="src/<?= htmlspecialchars($image['image_path']); ?>" alt="<?= htmlspecialchars($image['title']); ?>" onclick="openLightbox(this)">
                    <p><?= htmlspecialchars($image['title']); ?></p>
                    <p><?= htmlspecialchars($image['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close">&times;</span>
        <img id="lightbox-img" src="" alt="Enlarged Image">
    </div>
    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-container">
            <!-- Navigation Links -->
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

            <!-- Quick Links -->
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

            <!-- Join Us Section -->
            <div class="footer-section join-us">
                <h4>Join Us</h4>
                <p>Become a part of Lighthouse Ministers today!</p>
                <a href="join.php" class="join-btn">Join Now</a>
            </div>

            <!-- Social Media -->
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

        <!-- Copyright -->
        <div class="footer-bottom">
            <p>&copy; 2024 Lighthouse Ministers. All Rights Reserved.</p>
            <p><a href="privacy-policy.php">Privacy Policy</a> | <a href="terms-of-use.php">Terms of Use</a></p>
        </div>
    </footer>

    <script>
        function toggleSection(header) {
            const grid = header.nextElementSibling;
            grid.style.display = grid.style.display === "grid" ? "none" : "grid";
        }

        function openLightbox(img) {
            const lightbox = document.getElementById("lightbox");
            const lightboxImg = document.getElementById("lightbox-img");
            lightboxImg.src = img.src;
            lightbox.style.display = "flex";
        }

        function closeLightbox() {
            document.getElementById("lightbox").style.display = "none";
        }

        function showMenu() {
            navLinks.style.right = "0";
        }

        function hideMenu() {
            navLinks.style.right = "-250px"; // Moves the menu off-screen
        }
    </script>
</body>
</html>
