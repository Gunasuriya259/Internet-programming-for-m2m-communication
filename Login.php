<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user credentials (Replace this with your actual authentication logic)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Assume $user_id is retrieved after successful authentication
    $user_id = 1; // Replace with your actual user ID

    // Set user_id in the session
    $_SESSION['user_id'] = $user_id;

    header("Location: index.html"); // Redirect to the main page after successful login
    exit();
}
?>