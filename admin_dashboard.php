<?php
session_start();
include("dbconfig.php");

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch total revenue and total orders
$order_query = $conn->query("SELECT COUNT(id) AS total_orders, SUM(total_price) AS total_revenue FROM orders");
$order_data = $order_query->fetch_assoc();
$total_orders = $order_data['total_orders'] ?? 0;
$total_revenue = $order_data['total_revenue'] ?? 0;

// Fetch total users
$user_query = $conn->query("SELECT COUNT(id) AS total_users FROM users");
$user_data = $user_query->fetch_assoc();
$total_users = $user_data['total_users'] ?? 0;

// Fetch pending complaints
$complaint_query = $conn->query("SELECT COUNT(id) AS pending_complaints FROM complaints WHERE status='Pending'");
$complaint_data = $complaint_query->fetch_assoc();
$pending_complaints = $complaint_data['pending_complaints'] ?? 0;

// Handle product addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO products (name, price, description, image_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $name, $price, $description, $target_file);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Handle product deletion
if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch existing products
$products = $conn->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <h1>Admin Dashboard</h1>
        <div class="nav-links">
            <a href="users.php">Users</a>
            <a href="order.php">Orders</a>
            <a href="complaints.php">Complaints</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container">
        <!-- Dashboard Cards -->
        <div class="dashboard">
            <div class="card">
                <h3>Total Orders</h3>
                <p><?php echo $total_orders; ?></p>
            </div>
            <div class="card">
                <h3>Total Revenue</h3>
                <p>₹<?php echo number_format($total_revenue, 2); ?></p>
            </div>
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="card">
                <h3>Pending Complaints</h3>
                <p><?php echo $pending_complaints; ?></p>
            </div>
        </div>

        <!-- Add Product Form -->
        <div class="product-form">
            <h2>Add New Product</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Product Name" required>
                <input type="number" name="price" step="0.01" placeholder="Price (₹)" required>
                <textarea name="description" placeholder="Product Description" required></textarea>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit" name="add_product">Add Product</button>
            </form>
        </div>

        <!-- Display Existing Products -->
        <h2>Existing Products</h2>
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p><?php echo $product['description']; ?></p>
                    <p>₹<?php echo number_format($product['price'], 2); ?></p>
                    <a href="?delete_product=<?php echo $product['id']; ?>" class="delete-btn">Delete</a>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="edit-btn">Edit</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
