<?php
include("dbconfig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $date_of_birth = $_POST["date_of_birth"];
    $gender = $_POST["gender"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $user_type = $_POST["user_type"];

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, address, date_of_birth, gender, password_hash, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $full_name, $email, $phone, $address, $date_of_birth, $gender, $password, $user_type);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error: Could not register.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="css/registration.css">
</head>
<body>
    <form method="POST">
        <h2>Register</h2>
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address">
        <input type="date" name="date_of_birth" required>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <input type="password" name="password" placeholder="Password" required>
        <select name="user_type" required>
            <option value="individual">Individual</option>
            <option value="business">Business</option>
        </select>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</body>
</html>
