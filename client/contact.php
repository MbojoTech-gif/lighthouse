<?php
session_start();


?>

<!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lighthouse Ministers</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barriecito&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/b29579297b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <section class="sub-header">
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
            <h1>Contact Us</h1>
            </section>
<!----------about us content------------->
            <section class="location">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8093463601967!2d36.9812349!3d-1.2885765000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f6d510e784a85%3A0x5605eb8e8f19179f!2sSeventh%20Day%20Adventist%20Jet%20view!5e0!3m2!1sen!2ske!4v1742900135187!5m2!1sen!2ske"
                width="600" height="450" style="border:0;" 
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

        <section class="contact-us">
            <div class="row">
                <div class="contact-col">
                    <div>
                    <i class="fa fa-home"></i>
                    <span>
                        <h5>Jetview SDA Church , Utawala</h5>
                        <p>Kenya, Nairobi</p>
                    </span>
                    </div>
                    <div>
                        <i class="fa fa-phone"></i>
                        <span>
                            <h5>+254 716 282 117</h5>
                            <p>Sunday to Friday , 10AM to 6PM</p>
                        </span>
                        </div>
                        <div>
                            <i class="fa fa-envelope-o"></i>
                            <span>
                                <h5>lighthouseministers23@gmail.com</h5>
                                <p>Email us your query</p>
                            </span>
                            </div>
                </div>
                <div class="contact-col">
                    <form action="https://formspree.io/f/xwplqvar" method="post">
                        <input type="text" name="name" placeholder="Enter your name" required>
                        <input type="email" name="email" placeholder="Enter email address" required>
                        <input type="text" name="subject" placeholder="Enter your subject" required>
                        <textarea rows ="8" name="message" placeholder="Message" required></textarea>
                        <button type="submit" class="hero-btn red-btn">Send Message</button>


                    </form>
                </div>
            </div>

        </section>
        <hr size="10">
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