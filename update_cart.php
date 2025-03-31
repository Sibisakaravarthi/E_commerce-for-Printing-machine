<?php
session_start();
include("dbconfig.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$cart_id = $_POST["cart_id"];

if (isset($_POST["increase"])) {
    $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ?");
    $update->bind_param("i", $cart_id);
    $update->execute();
} elseif (isset($_POST["decrease"])) {
    $update = $conn->prepare("UPDATE cart SET quantity = GREATEST(quantity - 1, 1) WHERE id = ?");
    $update->bind_param("i", $cart_id);
    $update->execute();
}

header("Location: cart.php");
exit();
?>
