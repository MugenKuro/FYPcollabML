<?php
// Include file
require_once('auth.php');
require_once dirname(__FILE__) . '/controller/categoriesController.php';
require_once dirname(__FILE__) . '/controller/userController.php';
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Check if the user is logged in and their role matches the allowed roles for this page
if (isset($_SESSION['accountType'])) {
    $userRole = $_SESSION['accountType'];

    // Define the allowed roles for this page
    $allowedRoles = array("Customer");

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

if (isset($_SESSION['cart_id'])) {
    $payment = new makePayment();
    $result = $payment->decreaseQuantity($_SESSION['cart_id']);
    $result2 = $payment->addOrderHistory($_SESSION['cart_id'], $_SESSION['user_id']);
    $result3 = $payment->checkOutCart($_SESSION['cart_id']);

}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <title>iCloth</title>
</head>

<body>

    <?php
    include dirname(__FILE__) . ('/custNavBar.php');
    ?>
    <div>
        <div class="transaction-success-container">
            <div class="transaction-success-container1">
                <div class="transaction-success-container2">
                    <img src="./images/tick.png" alt="image" class="transaction-success-image" />
                    <h1>Transaction Completed</h1>
                    <button type="button" class="transaction-success-button button"
                        onclick="window.location='trending.php'">
                        <span class="transaction-success-text1">
                            <span>Done</span>
                            <br />
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>




</body>

</html>