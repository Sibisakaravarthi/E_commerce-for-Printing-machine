<?php
session_start();
include("dbconfig.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$cart_id = $_POST["cart_id"];

$delete = $conn->prepare("DELETE FROM cart WHERE id = ?");
$delete->bind_param("i", $cart_id);
$delete->execute();

header("Location: cart.php");
exit();
?>
