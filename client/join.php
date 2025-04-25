<?php
require 'db.php';  // Include the database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $voicePart = $_POST['voicePart'];
    $instruments = $_POST['instruments'];
    $experience = $_POST['experience'];

    // Default status for new applications
    $status = 'pending';

    // Prepare the SQL query to insert the data into the 'applications' table
    $sql = "INSERT INTO applications (applicant_name, email, phone, voice_part, instruments, experience, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("sssssss", $name, $email, $phone, $voicePart, $instruments, $experience, $status);

        // Execute the query
        if ($stmt->execute()) {
            // Set success message and redirect
            $_SESSION['message'] = "Application submitted successfully!";
            header("Location: thank_you.php"); // Redirect to the thank-you page
            exit();
        } else {
            // Set error message
            $_SESSION['error'] = "Error: " . $stmt->error;
            header("Location: join.php"); // Redirect back to the form
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle failure to prepare statement
        $_SESSION['error'] = "Error: Unable to prepare SQL statement.";
        header("Location: join.php"); // Redirect back to the form
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Lighthouse Ministers Singing Group</title>
    <link rel="stylesheet" href="style.css">
    <!-- Other meta and stylesheets -->
</head>
<body>
    <section class="header">
        <nav>
            <img src="src/logo.png">
            <h6><b>LIGHTHOUSE MINISTERS NRB</b></h6>
            <!-- Other navigation elements -->
        </nav>
        <div class="join-us-container">
            <div class="join-us">
                <h2>Become a Part of Our Musical Family</h2>      
                <form id="joinForm" action="join.php" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone">

                    <label for="voicePart">Voice Part:</label>
                    <select id="voicePart" name="voicePart">
                        <option value="">Select Voice Part</option>
                        <option value="soprano">Soprano</option>
                        <option value="alto">Alto</option>
                        <option value="tenor">Tenor</option>
                        <option value="bass">Bass</option>
                    </select>

                    <label for="experience">Musical Experience:</label>
                    <textarea id="experience" name="experience" rows="2"></textarea>

                    <label for="instruments">Instruments Played:</label>
                    <input type="text" id="instruments" name="instruments" placeholder="E.g., Piano, Guitar">

                    <button type="submit">Submit</button>

                    <!-- Display error messages -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <?php endif; ?>

                    <!-- Display success message -->
                    <?php if (isset($_SESSION['message'])): ?>
                        <p class="success-message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
                    <?php endif; ?>
                </form>
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
            <p><a href="privacy-policy.php">Privacy Policy</a> | <a href="terms-of-use.php">Terms of Use</a></p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
