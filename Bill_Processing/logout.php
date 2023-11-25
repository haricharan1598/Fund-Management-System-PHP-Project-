<?php
session_start();

// Check if the user is logged in (replace 'user_id' with your session variable)
if (isset($_SESSION["user_id"])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page you prefer
    header("Location: ../index.html");
    exit();
} else {
    // If the user is not logged in, you can handle this as needed
    // For example, redirect them to the login page
    header("Location: ../index.html");
    exit();
}
?>
