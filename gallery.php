<?php
session_start();
include("dbconfig.php");

// Check if user is logged in
$user_logged_in = isset($_SESSION["user_id"]);
$user_name = $user_logged_in ? $_SESSION["user_name"] : "Guest";

// Fetch products from the database
$products = $conn->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gallery</title>
    <link rel="stylesheet" href="css/gallery.css">
    <script>
        function checkLogin() {
            <?php if (!$user_logged_in): ?>
                alert("Please log in to add products to your cart.");
                window.location.href = 'login.php';
                return false;
            <?php endif; ?>
            return true;
        }
    </script>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <h1>PrintTech</h1>
        </div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="cart.php">Cart</a></li>
            <?php if ($user_logged_in): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
        <span class="welcome-text">Welcome, <?php echo htmlspecialchars($user_name); ?>!</span>
    </nav>

    <div class="container">
        <h2>Our Products</h2>
        <div class="gallery">
            <?php foreach ($products as $product): ?>
                <div class="gallery-item">
                    <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p><?php echo $product['description']; ?></p>
                    <p>₹<?php echo number_format($product['price'], 2); ?></p>

                    <form action="add_to_cart.php" method="POST" onsubmit="return checkLogin();">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About PrintTech</h3>
                <p>PrintTech is a leading provider of advanced printing solutions, offering high-quality machines for businesses and individuals.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact Us</a></li>
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
