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
           <h1>Gallery</h1>
           </section> 
           <!-------------gallery content------------->
           <section class="gallery">
            <h2>Executive</h2>
            <div class="row">
                <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>CHAIRPERSON</h5>
                <P>Kennedy Otieno</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>SECRETARY</h5>
                <P>Alvine Olonde</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>WELFARE</h5>
                <P>Calvince Kokebe</p>
                    </div>
                    <br>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>SPIRITUAL</h5>
                <P>Kevin Otieno</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>PUBLICITY</h5>
                <P>Larry Nyangute</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>TREASURER</h5>
                <P>Sheila </p>
                    </div>
                </div>

                <h2>Members</h2>
            <div class="row">
                <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>CHAIRPERSON</h5>
                <P>Kennedy Otieno</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>SECRETARY</h5>
                <P>Alvine Olonde</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>WELFARE</h5>
                <P>Calvince Kokebe</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>SPIRITUAL</h5>
                <P>Kevin Otieno</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>PUBLICITY</h5>
                <P>Larry Nyangute</p>
                    </div>
                    <div class="gallery-col">
                    <img src="src/f.jpg">
                    <h5>TREASURER</h5>
                <P>Sheila </p>
                    </div>
                    <div class="gallery-col">
                        <img src="src/f.jpg">
                        <h5>CHAIRPERSON</h5>
                    <P>Kennedy Otieno</p>
                        </div>
                        <div class="gallery-col">
                        <img src="src/f.jpg">
                        <h5>SECRETARY</h5>
                    <P>Alvine Olonde</p>
                        </div>
                        <div class="gallery-col">
                        <img src="src/f.jpg">
                        <h5>WELFARE</h5>
                    <P>Calvince Kokebe</p>
                        </div>
                        <div class="gallery-col">
                        <img src="src/f.jpg">
                        <h5>SPIRITUAL</h5>
                    <P>Kevin Otieno</p>
                        </div>
                        <div class="gallery-col">
                        <img src="src/f.jpg">
                        <h5>PUBLICITY</h5>
                    <P>Larry Nyangute</p>
                        </div>
                        <div class="gallery-col">
                        <img src="src/f.jpg">
                        <h5>TREASURER</h5>
                    <P>Sheila </p>
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