<?php
session_start();

// Allow access to login.php and signup.php without a session
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name

// Define pages accessible to admins and users
$admin_pages = ['admin.php', 'adminevent.php', 'listofregistrant.php', 'usermanagement.php'];
$user_pages = ['index.php', 'event.php', 'eventregistration.php'];

// Redirect to login if not logged in, and not on login.php or signup.php
if (!isset($_SESSION['user_name']) && !in_array($current_page, ['login.php', 'signup.php', 'forgot_password.php', 'reset_password.php'])) {
    header("Location: login.php");
    exit();
}

// Fetch session values to be used globally (if session exists)
if (isset($_SESSION['user_name'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
    $role = $_SESSION['user_role'];
    $email = $_SESSION['user_email'];
    $foto = $_SESSION['user_foto'];

    // Role-based access control
    if ($role === 'admin' && in_array($current_page, $user_pages)) {
        // If admin tries to access a user-only page, redirect to the admin dashboard
        header("Location: admin.php");
        exit();
    }

    if ($role === 'user' && in_array($current_page, $admin_pages)) {
        // If user tries to access an admin-only page, redirect to the user dashboard
        header("Location: index.php");
        exit();
    }
}
