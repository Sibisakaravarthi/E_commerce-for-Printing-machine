<?php
session_start();
include("dbconfig.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Insert into the database
    $sql = "INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $successMessage = "Your message has been sent!";
    } else {
        $errorMessage = "Error submitting your message. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/contact_us.css">
</head>
<body>

    <div class="container">
        <h2>Contact Us</h2>
        <p>If you have any questions, feel free to reach out to us. We’re here to help!</p>

        <?php if (isset($successMessage)) { echo "<p class='success'>$successMessage</p>"; } ?>
        <?php if (isset($errorMessage)) { echo "<p class='error'>$errorMessage</p>"; } ?>

        <div class="contact-section">
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                <form action="contact_us.php" method="POST">
                    <div class="form-group">
                        <input type="text" id="name" name="name" placeholder="Enter your name" required>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <textarea id="message" name="message" placeholder="drop a message here" rows="4" required></textarea>
                    </div>

                    <button type="submit">Send Message</button>
                </form>
            </div>

            <div class="contact-info">
                <h3>Contact Information</h3>
                <p><strong>Address:</strong> 123, Main Street, Your City, Country</p>
                <p><strong>Email:</strong> support@yourwebsite.com</p>
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Working Hours:</strong> Monday - Friday, 9:00 AM - 6:00 PM</p>
            </div>
        </div>

        <div class="faq-section">
            <h3>Frequently Asked Questions (FAQs)</h3>
            <div class="faq">
                <p><strong>Q: How can I track my order?</strong></p>
                <p>A: You can track your order by logging into your account and navigating to "My Orders".</p>
            </div>
            <div class="faq">
                <p><strong>Q: How do I cancel an order?</strong></p>
                <p>A: If your order has not been shipped, you can cancel it from your account dashboard.</p>
            </div>
            <div class="faq">
                <p><strong>Q: Do you offer international shipping?</strong></p>
                <p>A: Yes, we offer worldwide shipping. Delivery times vary by location.</p>
            </div>
        </div>

        <div class="map-section">
            <h3>Our Location</h3>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345093983!2d144.95373631531865!3d-37.816279742021814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf4c3c64d1d3b8e9e!2sFederation+Square!5e0!3m2!1sen!2sus!4v1510912954064"
                width="100%" height="300" frameborder="0" style="border:0" allowfullscreen>
            </iframe>
        </div>
    </div>

</body>
</html>
