<?php
// Database connection details
$host = "localhost"; // Hostname
$user = "root"; // Database username
$pass = ""; // Database password
$db = "login_system"; // Database name

// Create connection to MySQL
$conn = new mysqli($host, $user, $pass, $db);

// Check if connection failed
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error); // Error message if connection fails
}
?>
