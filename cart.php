<?php
session_start();
include("dbconfig.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch cart items
$query = "SELECT cart.id, cart.product_id, products.name, products.price, products.image_path, cart.quantity 
          FROM cart 
          JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #f0f8ff, #e3f2fd);
}

.navbar {
    display: flex;
    justify-content: space-between;
    background: #ffffff;
    padding: 15px;
    color: rgb(10, 5, 5);
}

.nav-right {
    display: flex;
    gap: 20px;
    align-items: center;
}

.nav-right a:hover {
    color: #28a745;
}

.nav-right a, .logout-btn {
    color: rgb(12, 8, 8);
    text-decoration: none;
    font-weight: bold;
}

.container {
    width: 80%;
    margin: 20px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

.cart-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
}

button {
    padding: 5px 10px;
    background: #28a745;
    color: white;
    border: none;
    cursor: pointer;
}

button.remove-btn {
    background: #dc3545;
}

button.checkout-btn {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    background: #007bff;
}

    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <div class="nav-left">
        <h2>My Store</h2>
    </div>
    <div class="nav-right">
        <span>Welcome, <?php echo $_SESSION["user_name"]; ?></span>
        <a href="order_history.php">Order History</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<div class="container">
    <h2>Your Cart</h2>
    <table>
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="<?php echo $row["image_path"]; ?>" alt="<?php echo $row["name"]; ?>" class="cart-img"></td>
                <td><?php echo $row["name"]; ?></td>
                <td>₹<?php echo number_format($row["price"], 2); ?></td>
                <td>
                    <form action="update_cart.php" method="POST">
                        <input type="hidden" name="cart_id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" name="decrease">-</button>
                        <span><?php echo $row["quantity"]; ?></span>
                        <button type="submit" name="increase">+</button>
                    </form>
                </td>
                <td>₹<?php echo number_format($row["price"] * $row["quantity"], 2); ?></td>
                <td>
                    <form action="remove_from_cart.php" method="POST">
                        <input type="hidden" name="cart_id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" class="remove-btn">Remove</button>
                    </form>
                </td>
            </tr>
            <?php $total_price += $row["price"] * $row["quantity"]; ?>
        <?php endwhile; ?>
        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td>₹<?php echo number_format($total_price, 2); ?></td>
            <td></td>
        </tr>
    </table>

    <form action="checkout.php" method="POST">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <button type="submit" class="checkout-btn">Proceed to Checkout</button>
    </form>
</div>

</body>
</html>
