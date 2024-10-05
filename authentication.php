<?php
session_start();

// Example data to be set in session after login (replace with actual login logic)
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "David"; // Change this based on actual login data
    $_SESSION['user_role'] = "admin"; // Change this based on the actual user's role
}

// Fetch session values to be used globally
$name = $_SESSION['user_name'];
$role = $_SESSION['user_role'];
?>
