<?php
$host = "localhost";  // Change if using a remote database
$user = "root";       // Change if using a different database user
$password = "";       // Change if a password is set
$database = "E_complaint"; // Change to your database name

// Create a database connection
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment below to check if the connection is successful
// echo "Connected successfully";

?>
