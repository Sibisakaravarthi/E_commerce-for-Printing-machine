<?php
session_start();
include("dbconfig.php");

if (!isset($_SESSION["user_id"])) {
    echo "Unauthorized access";
    exit();
}

$user_id = $_SESSION["user_id"];
$order_id = $_POST["order_id"];
$complaint_text = $_POST["complaint"];
$image_path = null;

if (!empty($_FILES["complaint_image"]["name"])) {
    $image_name = time() . "_" . basename($_FILES["complaint_image"]["name"]);
    $image_path = "complaint_images/" . $image_name;
    move_uploaded_file($_FILES["complaint_image"]["tmp_name"], $image_path);
}

$query = "INSERT INTO complaints (user_id, order_id, complaint_text, image_path, status) VALUES (?, ?, ?, ?, 'Pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiss", $user_id, $order_id, $complaint_text, $image_path);
$stmt->execute();

echo "Complaint submitted!";
?>
