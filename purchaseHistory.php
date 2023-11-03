<?php
// Include file
require_once('auth.php');
require_once dirname(__FILE__) . '\controller\categoriesController.php';
require_once dirname(__FILE__) . '\controller\userController.php';

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

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = new deactivateCustomerAccount();
    $deactivateUser = json_decode($user->deactivateCustAcc($_SESSION['user_id']));
    if (isset($deactivateUser->status)) {
        if ($deactivateUser->status == 'success') {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'account deactivated successfully.';

            // Perform the redirect
            header('Location: login.php');
        } elseif ($deactivateUser->status == 'nothing') {
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Something went wrong.';
        } else {
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = 'Something went wrong.';
        }
    }

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

    <style>
        .wrap-text {
            white-space: nowrap;
            /* Prevent text from wrapping to the next line */
            overflow: hidden;
            /* Hide overflowing text */
            text-overflow: ellipsis;
            /* Add ellipsis (...) when text overflows */
        }
    </style>
</head>

<body>

    <?php
    include dirname(__FILE__) . ('/custNavBar.php');
    ?>

    <div>
        <?php
        $userPurchaseHistory = new viewPurchaseHistory();
        $data = json_decode($userPurchaseHistory->viewPurchasesHistory($_SESSION['user_id']));

        $current_folder = basename(__DIR__);
        $dir = "/" . $current_folder;


        ?>
        <div class="purchase-history-container">
            <div class="purchase-history-container1">
                <h1 class="purchase-history-text">Purchase History</h1>
                <div class="purchase-history-container2">
                    <div class="purchase-history-container3">
                        <span class="purchase-history-text01">
                            <span>Images</span>
                            <br />
                        </span>
                        <span class="purchase-history-text04">
                            <span>Name</span>
                            <br />
                        </span>
                        <div class="purchase-history-container4">
                            <span class="purchase-history-text07">
                                <span>Price</span>
                                <br />
                            </span>
                            <span class="purchase-history-text10">
                                <span>Date</span>
                                <br />
                            </span>
                        </div>
                    </div>
                    <?php
                    // Check if data is not empty
                    if (!empty($data)) {
                        foreach ($data as $purchase) {
                            $item_id = $purchase->item_id;
                            $customer_id = $purchase->customer_id;
                            $image = $purchase->item_image_path;
                            $name = $purchase->item_name;
                            $price = $purchase->price;
                            $date = $purchase->order_date;
                            // Add more fields as needed
                            // You can repeat the HTML block for each purchase
                            echo '<div class="purchase-history-container5" onclick="window.location=\'rateItem.php?item_id=' . $item_id . '&customer_id=' . $customer_id . '\'">';
                            echo '<div class="col-sm-4">';
                            echo '<img alt="image" src="' . $dir . $image . '" class="purchase-history-image" />';
                            echo '</div>';
                            echo '<div class="col-sm-3">';
                            echo '<span class="purchase-history-text19 style="text-align: left;"><span>' . $name . '</span></span>';
                            echo '</div>';
                            echo '<div class="purchase-history-container6">';
                            echo '<div class="col-sm-3.5">';
                            echo '<span class="purchase-history-text16"><span>$' . $price . '</span></span>';
                            echo '</div>';
                            echo '<div class="col-sm-8">';
                            echo '<span class="purchase-history-text19"><span>' . $date . '</span></span>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        // Handle the case where purchase history data is empty
                        echo 'Nothing to see';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>




</body>

</html>