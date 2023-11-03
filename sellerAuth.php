<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Check if the user is logged in and their role matches the allowed roles for this page
if (isset($_SESSION['accountType'])) {
    $userRole = $_SESSION['accountType'];

    // Define the allowed roles for this page
    $allowedRoles = array("Seller");

    // Check if the user's role is allowed
    if (!in_array($userRole, $allowedRoles)) {
        // User has access, continue with the page
        header("location: login.php"); // You can create an "access_denied.php" page
        exit;
    }
} else {
    // User is not logged in, redirect them to the login page
    header("location: login.php");
    exit;
}

?>