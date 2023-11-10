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
    if (!isset($_GET["item_id"])) {
        header("location: viewItemByCat.php");
        exit;
    }
    $_SESSION["item_id"] = $_GET["item_id"];

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
        <div class="view-review-container">
            <div class="view-review-container01">
                <div class="view-review-container02">
                    <div class="view-review-container09">
                        <span class="view-review-text13">
                            <span>Reviews</span>
                            <br />
                        </span>
                        <?php
                        $current_item_id = $_SESSION["item_id"];
                        $items = new viewAnItem();
                        $itemReview = json_decode($items->viewReviews($_SESSION['item_id']));

                        if (!empty($itemReview)) {
                            $totalReviews = count($itemReview);
                            $totalRatings = 0; // Variable to store the sum of ratings
                        
                            // Calculate average rating
                            foreach ($itemReview as $review) {
                                $totalRatings += $review->rating_value;
                            }
                            $averageRating = $totalReviews > 0 ? round($totalRatings / $totalReviews, 1) : 0;
                            ?>
                            <span class="view-review-text16">
                                <span>
                                    <?php echo $averageRating; ?> Star
                                </span>
                                <span>Review</span>
                                <br />
                            </span>
                            <span class="view-review-text20">
                                <span>(
                                    <?php echo $totalReviews; ?> Reviews)
                                </span>
                                <br />
                            </span>
                            <?php

                            // Display individual reviews
                            foreach ($itemReview as $review) {
                                $userImage = $review->image_path;
                                $userName = $review->nickname;
                                $rating = $review->rating_value;
                                $reviewText = $review->review_text;
                                ?>
                                <div class="view-review-container10">
                                    <img alt="image" src="<?php echo "." . $userImage; ?>" class="view-review-image1" />
                                    <div class="view-review-container11">
                                        <div class="view-review-container12">
                                            <span class="view-review-text23">
                                                <span>
                                                    <?php echo $userName; ?>
                                                </span>
                                                <br />
                                            </span>
                                            <span class="view-review-text26">
                                                <span class="view-review-text27">
                                                    <?php echo $rating; ?> star
                                                </span>
                                                <br />
                                            </span>
                                        </div>
                                        <span class="view-review-text29">
                                            <span>
                                                <?php echo $reviewText; ?>
                                            </span>
                                            <br />
                                        </span>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "No reviews";
                        }
                        ?>
                    </div>

                    <div class="view-review-container31">
                        <div class="view-review-container32">
                            <?php
                            $current_item_id = $_SESSION["item_id"];
                            ?>
                            <button type="button" class="view-review-button button"
                                onclick="window.location='viewItem.php?item_id=<?php echo $current_item_id; ?>'">
                                <span class="view-review-text86">
                                    <span class="view-review-text87">back</span>
                                    <br />
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>