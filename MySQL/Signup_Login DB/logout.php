<?php
// Start the session to access session variables
session_start();

// Destroy all data registered to the current session
session_destroy();

// Redirect the user to the index.php page
header("Location: index.php");

// Exit the script to ensure the redirection occurs immediately
exit();
?>
