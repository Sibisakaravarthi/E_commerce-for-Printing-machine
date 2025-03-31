<?php
include("dbconfig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Password reset link sent to your email');</script>";
        // Here you can implement email sending logic
    } else {
        echo "<script>alert('No account found with this email');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/forgot_password.css">
</head>
<body>
    <form method="POST">
        <h2>Forgot Password</h2>
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Reset Password</button>
        <p>Back to <a href="login.php">Login</a></p>
    </form>
</body>
</html>
