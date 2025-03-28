<?php
session_start();

?>

<!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lighthouse Ministers</title>
    <link rel="stylesheet" href="../styles/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barriecito&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/b29579297b.js" crossorigin="anonymous"></script>
    </head>
    <body class="index-page">

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
            <div class="container">
                <h1>The Lighthouse Ministers</h1>
                <p>We share the message of hope and faith through inspiring and uplifting music.</p>
                <a href="https://www.youtube.com/@lighthouseministersnrb" class="hero-btn">Visit Us To Know More</a>
            </div>

        </section>
       
        <section class="about-index">
            <div class="about-container">
                <div class="row">
                    <h1>About Lighthouse Ministers</h1>
                    <div class="abouti-col">
                        <p>
                            We preach the everlasting Gospel of Christ and prepare people for His second coming. 
                            We also aim to be a full-service ministry sharing the love of Jesus through:
                            <br><br>
                            <strong>Music, Preaching, and Community Outreach</strong> in schools, prisons, and hospitals, 
                            while also supporting persons with special needs.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
   
<!---------------------ministries-------------------------->
<section class="ministries">
    <div class="ministry-container">
        <!-- Music Ministry -->
        <div class="ministry-content music-ministry">
            <div class="ministry-text">
                <h2>Music Ministry</h2>
                <p>
                    Our Music Ministry is dedicated to spreading the message of Jesus through 
                    inspiring and uplifting music. We believe in the power of worship to transform lives 
                    and bring people closer to God.
                </p>
                <a href="https://www.youtube.com/@lighthouseministersnrb" class="ministry-btn">View Our Music</a>
            </div>
            <div class="ministry-image">
                <img src="src/a.jpg" alt="Music Ministry">
            </div>
        </div>

        <!-- Prayer Band -->
        <div class="ministry-content prayer-band">
            <div class="ministry-text">
                <h2>Prayer Band Team</h2>
                <p>
                    Our Prayer Band is committed to interceding for individuals, communities, and the world. 
                    Through prayer, we strengthen our faith, seek divine intervention, and bring spiritual 
                    revival to those in need.
                </p>
                <a href="prayerband.php" class="ministry-btn">Join Us in Prayer</a>
            </div>
            <div class="ministry-image">
                <img src="src/prayer.jpg" alt="Prayer Band">
            </div>
        </div>

        <!-- Bible Study Group -->
        <div class="ministry-content bible-study">
            <div class="ministry-text">
                <h2>Bible Study Group</h2>
                <p>
                    Our Bible Study Group is dedicated to deepening our understanding of God's Word. 
                    Through scripture reading, discussions, and reflections, we grow spiritually and 
                    strengthen our faith in Christ.
                </p>
                <a href="contact.html" class="ministry-btn">Join Our Study</a>
            </div>
            <div class="ministry-image">
                <img src="src/bible.jpg" alt="Bible Study Group">
            </div>
        </div>
    </div>
</section>


        


    <!--------------footer section------------>

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
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a></p>
        </div>
    </footer>
    <script src="script.js"></script>
    </body>
    </html>