<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user"] = $row["name"];
            header("Location: dashboard.php");
        } else {
            echo "<p style='color:red;'>Invalid Password!</p>";
        }
    } else {
        echo "<p style='color:red;'>User Not Found!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: #19437D;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2{
            margin-bottom: 20px;
            color: white;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .link-section {
            margin-top: 15px;
        }

        .link-section a {
            color: white;
            text-decoration: none;
        }

        .link-section a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login to Your Account</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Log In">
    </form>
    <div class="link-section">
        <a href="register.php">Create New Account &nbsp &nbsp &nbsp </a> <span style= "color: white" > | </span> <a href="forgot.php"> &nbsp &nbsp &nbsp Forgotten Password?</a>
    </div>
</div>

</body>
</html>
