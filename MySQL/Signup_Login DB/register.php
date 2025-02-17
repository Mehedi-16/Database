Here is the PHP and HTML code with short comments for each line:

```php
<?php
include "db.php"; // Include the database connection

$success_message = ""; // Variable to hold success or error messages

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $dob = $_POST["dob"]; // Date of birth
    $email = mysqli_real_escape_string($conn, $_POST["email"]); // Email input
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash the password for security

    // SQL query to insert new user data into the database
    $sql = "INSERT INTO users (name, dob, email, password) VALUES (?, ?, ?, ?)";
    
    // Prepare the query to prevent SQL injection
    $stmt = $conn->prepare($sql);
    // Bind the parameters to the query
    $stmt->bind_param("ssss", $name, $dob, $email, $password);

    // Execute the query and check if successful
    if ($stmt->execute()) {
        $success_message = "✔ Account created successfully!"; // Success message
    } else {
        $success_message = "❌ Error: " . $stmt->error; // Error message if query fails
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Set the character encoding -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Make the page responsive -->
    <title>Create Account - My System</title> <!-- Title of the page -->
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif; /* Style body font */
            background-color: #f4f4f4; /* Set background color */
            margin: 0; /* Remove margin */
            padding: 0; /* Remove padding */
            display: flex; /* Flexbox layout */
            justify-content: center; /* Center the content horizontally */
            align-items: center; /* Center the content vertically */
            height: 100vh; /* Full viewport height */
        }

        .container {
            width: 100%; /* Full width */
            max-width: 400px; /* Maximum width of 400px */
            padding: 30px; /* Padding around content */
            background-color: #fff; /* White background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow for depth */
            border-radius: 8px; /* Rounded corners */
            text-align: center; /* Centered text */
        }

        h2 {
            margin-bottom: 20px; /* Space below header */
            color: #333; /* Header text color */
        }

        input {
            width: 100%; /* Full width */
            padding: 12px; /* Padding inside input fields */
            margin: 10px 0; /* Space between input fields */
            border: 1px solid #ddd; /* Light gray border */
            border-radius: 5px; /* Rounded corners */
            box-sizing: border-box; /* Include padding in element's total width/height */
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green background for submit button */
            color: white; /* White text color */
            border: none; /* Remove border */
            cursor: pointer; /* Pointer cursor on hover */
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        .link-section {
            margin-top: 15px; /* Space above link section */
        }

        .link-section a {
            color: #007BFF; /* Blue text color */
            text-decoration: none; /* Remove underline */
        }

        .link-section a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        .message {
            margin-top: 15px; /* Space above message */
            font-size: 16px; /* Set font size */
            font-weight: bold; /* Make message bold */
        }

        .success {
            color: green; /* Green color for success message */
        }

        .error {
            color: red; /* Red color for error message */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Account</h2> <!-- Page header -->

    <!-- Display success or error message -->
    <?php if ($success_message): ?>
        <p class="message <?= strpos($success_message, '✔') !== false ? 'success' : 'error' ?>">
            <?= $success_message ?> <!-- Show the success/error message -->
        </p>
    <?php endif; ?>

    <!-- Form to create a new account -->
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required> <!-- Input for name -->
        <input type="date" name="dob" required> <!-- Input for date of birth -->
        <input type="email" name="email" placeholder="Email" required> <!-- Input for email -->
        <input type="password" name="password" placeholder="Password" required> <!-- Input for password -->
        <input type="submit" value="Register"> <!-- Submit button -->
    </form>

    <!-- Link to login page if the user already has an account -->
    <div class="link-section">
        <a href="index.php">Already have an account? Login</a> <!-- Login link -->
    </div>
</div>

</body>
</html>
```

This version includes comments explaining each line of the PHP and HTML code for better understanding.