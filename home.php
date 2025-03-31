<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrintTech - Advanced Printing Solutions</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <h1>PrintTech</h1>
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="admin_login.php">Admin</a></li>
            <li><a href="login.php">User</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
        </ul>
    </nav>

    <!-- Hero Section with SVG Shape -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="animate__animated animate__fadeInDown">Revolutionize Your Printing Experience</h1>
            <p class="animate__animated animate__fadeInUp">Discover the latest in printing technology with PrintTech. High-quality, reliable, and efficient printing machines for every need.</p>
            <div class="hero-navigation animate__animated animate__fadeInUp">
                <a href="gallery.php" class="btn" >Explore Products</a>
                <a href="contact_us.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="images/printing-machine-hero.jpg" alt="Printing Machine">
            <div class="blend-overlay"></div>
        </div>
        <!-- SVG Wave Shape -->
        <svg class="hero-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#f0f8ff" fill-opacity="1" d="M0,160L48,149.3C96,139,192,117,288,128C384,139,480,181,576,176C672,171,768,117,864,101.3C960,85,1056,107,1152,128C1248,149,1344,171,1392,181.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </section>

    <!-- Featured Products Section -->
    <section id="products" class="featured-products">
        <h2 class="animate__animated animate__fadeIn">Featured Products</h2>
        <div class="product-grid">
            <div class="product-card animate__animated animate__fadeInLeft">
                <img src="images/High_speed_laser_printer.jpg" alt="High-Speed Laser Printer">
                <h3>High-Speed Laser Printer</h3>
                <p>Perfect for high-volume printing with precision and speed.</p>
                <a href="#" class="btn">Learn More</a>
            </div>
            <div class="product-card animate__animated animate__fadeInUp">
                <img src="images/3D printer.jpg" alt="3D Printing Machine">
                <h3>3D Printing Machine</h3>
                <p>Bring your ideas to life with our advanced 3D printers.</p>
                <a href="#" class="btn">Learn More</a>
            </div>
            <div class="product-card animate__animated animate__fadeInRight">
                <img src="images/inkjet printer.jpg" alt="Inkjet Printer">
                <h3>Inkjet Printer</h3>
                <p>Affordable and reliable for everyday printing needs.</p>
                <a href="#" class="btn">Learn More</a>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="about">
        <h2 class="animate__animated animate__fadeIn">About Us</h2>
        <p class="animate__animated animate__fadeIn">At PrintTech, we are committed to delivering cutting-edge printing solutions tailored to your needs. Our team of experts ensures that every product meets the highest standards of quality and performance.</p>
        <img src="images/about_us.jpg" alt="About Us" class="animate__animated animate__fadeIn">
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <h2 class="animate__animated animate__fadeIn">What Our Customers Say</h2>
        <div class="testimonial-grid">
            <div class="testimonial-card animate__animated animate__fadeInLeft">
                <img src="images/sundar pichai.jpg" alt="Customer 1">
                <p>"PrintTech's printers are top-notch! Highly recommended for businesses."</p>
                <h4>- Sundar pichai</h4>
            </div>
            <div class="testimonial-card animate__animated animate__fadeInUp">
                <img src="images/jeff bezos.jpg" alt="Customer 2">
                <p>"The 3D printer is amazing. It has transformed our prototyping process."</p>
                <h4>- Jeff Bezos</h4>
            </div>
            <div class="testimonial-card animate__animated animate__fadeInRight">
                <img src="images/bill gates.jpg" alt="Customer 3">
                <p>"Excellent customer service and high-quality products. Thank you, PrintTech!"</p>
                <h4>- Bill Gates</h4>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="blog">
        <h2 class="animate__animated animate__fadeIn">Latest From Our Blog</h2>
        <div class="blog-grid">
            <div class="blog-card animate__animated animate__fadeInLeft">
                <img src="images/printer_tips.jpeg" alt="Blog 1">
                <h3>5 Tips for Maintaining Your Printer</h3>
                <p>Learn how to keep your printer in top condition for years to come.</p>
                <a href="#" class="btn">Read More</a>
            </div>
            <div class="blog-card animate__animated animate__fadeInUp">
                <img src="images/3d_future.jpg" alt="Blog 2">
                <h3>The Future of 3D Printing</h3>
                <p>Discover the latest trends in 3D printing technology.</p>
                <a href="#" class="btn">Read More</a>
            </div>
            <div class="blog-card animate__animated animate__fadeInRight">
                <img src="images/eco_friendly_printer.jpg" alt="Blog 3">
                <h3>Eco-Friendly Printing Solutions</h3>
                <p>Explore how PrintTech is contributing to a greener planet.</p>
                <a href="#" class="btn">Read More</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About PrintTech</h3>
                <p>PrintTech is a leading provider of advanced printing solutions, offering high-quality machines for businesses and individuals.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="gallery.php">Products</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="contact_us.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 PrintTech. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>