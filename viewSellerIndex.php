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

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["seller_id"])) {
        header("location: viewItemByCat.php");
        exit;
    }
    $_SESSION["seller_id"] = $_GET["seller_id"];

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
        .item-name {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            /* Number of lines to show */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body>


    <?php
    include dirname(__FILE__) . ('/custNavBar.php');

    $seller = new viewSeller();
    $sellerData = json_decode($seller->viewSellers($_SESSION['seller_id']));

    if (!empty($sellerData)) {
        foreach ($sellerData as $seller) {
            // Access item properties and generate the HTML dynamically
            $sellerDesc = $seller->description;
            $sellerName = $seller->seller_name;
            $sellerImage = $seller->profile_image;
            $sellerUsername = $seller->seller_username;
        }
    }
    ?>
    <div>
        <div class="seller-listings-container">
            <div class="seller-listings-container01">
                <img src="<?php echo '.'. $sellerImage?>" alt="image" class="seller-listings-image" />
                <h1 class="seller-listings-text"><?php echo $sellerName?></h1>
                <h1 class="seller-listings-text"><?php echo "@".$sellerUsername?></h1>
                <div class="seller-listings-container02"></div>
                <span class="seller-listings-text01">
                <?php echo $sellerDesc?>
                </span>
            </div>
            <div class="seller-listings-container03">
                <div class="seller-listings-container04">
                    <h1 class="seller-listings-text02">Listings</h1>
                    <button type="button" class="seller-listings-button button"
                        onclick="window.location='viewSellerReviews.php?seller_id=<?php echo $_SESSION['seller_id']; ?>'">
                        <span class="seller-listings-text03">
                            <span class="seller-listings-text04">view seller reviews</span>
                            <br />
                        </span>
                    </button>
                </div>
                <div class="seller-listings-container05">
                    <?php
                    $seller = new viewSeller();
                    $itemData = json_decode($seller->viewItemBySeller($_SESSION['seller_id']));

                    $count = 0;
                    foreach ($itemData as $item) {
                        // Start a new row for every 4 items
                        if ($count % 4 == 0) {
                            echo '</div><div class="row">';
                        }

                        echo '<div class="seller-listings-container06" onclick="window.location=\'viewItem.php?item_id=' .$item->item_id .'\'">';
                        echo '<img alt="image" src="' . '.' . $item->item_image_path . '" class="seller-listings-image1" />';
                        echo '<span class="item-name">';
                        echo '<span>' . $item->item_name . '</span>';
                        echo '<br />';
                        echo '</span>';
                        echo '<span>$' . $item->price . '</span>';
                        echo '</div>';

                        $count++;
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>





</body>

</html>