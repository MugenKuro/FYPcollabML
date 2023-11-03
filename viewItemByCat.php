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
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["category_id"])) {
        header("location: index.php");
        exit;
    }
    $_SESSION["category_id"] = $_GET["category_id"];

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
    ?>
    <div>
        <?php
        $items = new viewItemByCat();
        $itemData = json_decode($items->viewItemByCategory($_SESSION['category_id']));

        $current_folder = basename(__DIR__);
        $dir = "/" . $current_folder;


        ?>
        <link href="./homepage.css" rel="stylesheet" />
        <div class="homepage-container">
            <div class="homepage-container01">
                <?php $counter = 0; ?>
                <?php foreach ($itemData as $item): ?>
                    <?php if ($counter % 4 == 0): ?>
                        <div class="homepage-container02">
                        <?php endif; ?>
                        <div class="homepage-container03"
                            onclick="window.location='viewItem.php?item_id=<?php echo $item->item_id; ?>'">
                            <img alt="image" src="<?php echo $dir . $item->item_image_path; ?>" class="homepage-image" />
                            <span class="item-name">
                                <?php echo $item->item_name; ?>
                            </span>
                            <span>$
                                <?php echo $item->price; ?>
                            </span>
                        </div>
                        <?php if ($counter % 4 == 3 || $counter == count($itemData) - 1): ?>
                        </div>
                    <?php endif; ?>
                    <?php $counter++; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    </div>





</body>

</html>