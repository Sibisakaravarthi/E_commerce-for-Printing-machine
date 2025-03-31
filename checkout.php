<?php
session_start();
include("dbconfig.php"); // Ensure database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Step 1: Calculate total price from the cart
$total_price_query = $conn->prepare("
    SELECT SUM(products.price * cart.quantity) AS total 
    FROM cart 
    INNER JOIN products ON cart.product_id = products.id 
    WHERE cart.user_id = ?
");
$total_price_query->bind_param("i", $user_id);
$total_price_query->execute();
$total_price_result = $total_price_query->get_result();
$total_price_row = $total_price_result->fetch_assoc();
$total_price = $total_price_row['total'] ?? 0;
$total_price_query->close();

// Debugging - Print total price before proceeding
if ($total_price == 0 || $total_price === null) {
    die("Error: No items in the cart or total price calculation failed.");
}

// Step 2: Insert order into the database
$order_query = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'Pending')");
$order_query->bind_param("id", $user_id, $total_price);

if ($order_query->execute()) {
    $order_id = $order_query->insert_id; // Get last inserted order ID
    $order_query->close();

    // Step 3: Clear the cart after order is successfully placed
    $clear_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $clear_cart->bind_param("i", $user_id);
    $clear_cart->execute();
    $clear_cart->close();
} else {
    die("Error placing order: " . $order_query->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        h2 {
            color: #28a745;
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .thank-you {
            font-size: 14px;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>🎉 Order Placed Successfully!</h2>
        <p>Thank you for shopping with us!</p>
        <a href="home.php" class="btn">Continue Shopping</a>
        <p class="thank-you">We appreciate your business and look forward to serving you again!</p>
    </div>

</body>
</html>
