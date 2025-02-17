<?php
// Include database connection
include "db.php";

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email entered in the form
    $email = $_POST["email"];
    
    // SQL query to check if the email exists in the users table
    $sql = "SELECT * FROM users WHERE email='$email'";
    
    // Execute the query and store the result
    $result = $conn->query($sql);

    // Check if a user with the given email is found
    if ($result->num_rows > 0) {
        // If user is found, display a success message
        echo "<p style='color:green;'>User Found! Please Reset Your Password.</p>";
    } else {
        // If no user is found, display an error message
        echo "<p style='color:red;'>User Not Found!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic styles for the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Styling for the form container */
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Heading styles */
        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Styling for the email input field */
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Styling for the submit button */
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        /* Hover effect for the submit button */
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Styling for the link section */
        .link-section a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        /* Hover effect for the link */
        .link-section a:hover {
            text-decoration: underline;
        }

        /* Styling for paragraph elements */
        p {
            margin-top: 20px;
        }

        /* Class for error message */
        .error-message {
            color: red;
        }

        /* Class for success message */
        .success-message {
            color: green;
        }
    </style>
</head>
<body>

<!-- Main container for the forgot password form -->
<div class="container">
    <h2>Forgot Password</h2>
    <!-- Form to submit email -->
    <form method="post">
        <!-- Input field for email -->
        <input type="email" name="email" placeholder="Enter Your Email" required>
        <!-- Submit button -->
        <input type="submit" value="Find Account">
    </form>
    <!-- Link to navigate back to login page -->
    <div class="link-section">
        <a href="index.php">Back to Login</a>
    </div>
</div>

</body>
</html>
