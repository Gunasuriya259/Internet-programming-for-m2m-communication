<?php
session_start();

// Clear any session data on the server
session_unset();
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit();
?>
