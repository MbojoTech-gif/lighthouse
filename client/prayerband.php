<?php
session_start();
include 'db.php'; // Ensure you have a database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query database for user
    $query = "SELECT * FROM prayer_band WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['user'] = $username;
        header("Location: prayerband.php"); // Reload page to show dashboard
        exit();
    } else {
        $_SESSION['error'] = "❌ Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prayer Band - Lighthouse Ministers</title>
    
    <!-- Stylesheets & Fonts -->
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barriecito&family=Nunito+Sans:wght@200..1000&family=Roboto:wght@100..900&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/b29579297b.js" crossorigin="anonymous"></script>
</head>
<body class="prayer-band-page">

    <!-- Header Section -->
    <section class="header">
        <nav>
            <a href="index.html"><img src="src/logo.png" alt="Lighthouse Ministers Logo"></a>
            <p><b><button class="nav-brand">LIGHTHOUSE MINISTERS NRB</button></b></p>
            
            <!-- Navigation Links -->
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
    </section>

    <!-- Login Section -->
    <section class="container" id="auth-container" <?php if (isset($_SESSION['user'])) echo 'style="display: none;"'; ?>>
        <h2 id="auth-title">Prayer Band Login</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="prayerband.php" method="POST" id="login-form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </section>

    <!-- Dashboard Section (only visible after login) -->
    <section class="container" id="dashboard" <?php if (isset($_SESSION['user'])) echo 'style="display: block;"'; ?>>
        <h2>Welcome, <span id="user-email"><?php echo $_SESSION['user']; ?></span></h2>
        <a href="https://meet.google.com/" target="_blank" class="join-meet-btn">Join Prayer Meet</a>

        <div class="comments">
            <h3>Comments</h3>
            <textarea id="comment" placeholder="Share your thoughts..." required></textarea>
            <button onclick="postComment()">Post</button>
            <div id="comment-list"></div>
        </div>

        <!-- Logout Button -->
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </section>

    <!-- Audio for Background Music -->
    <audio id="bg-music" autoplay loop>
        <source src="https://youtu.be/4DLGu4TihXY?si=Mi35OHMY7fFL4G6U" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    
    <button onclick="toggleMusic()" class="music-toggle">🎵 Toggle Music</button>

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

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2024 Lighthouse Ministers. All Rights Reserved.</p>
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a></p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="script.js"></script>

</body>
</html>
