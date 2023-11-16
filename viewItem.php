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

    <style>
        .view-item-container06 {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .view-item-image1,
        .view-item-text07 {
            transition: transform 0.3s ease-in-out;
        }

        .view-item-container06:hover .view-item-image1 {
            transform: scale(1.1);
        }

        .view-item-container06:hover .view-item-text07 {
            transform: scale(1.1);
        }
    </style>
</head>

<body>

    <?php
    include dirname(__FILE__) . ('/custNavBar.php');

    $totalReviews = 0;

    $items = new viewAnItem();
    $itemData = json_decode($items->viewItem($_SESSION['item_id']));

    if (!empty($itemData)) {
        foreach ($itemData as $item) {
            // Access item properties and generate the HTML dynamically
            $itemName = $item->item_name;
            $itemPrice = $item->price;
            $seller_id = $item->seller_id;
            $itemCategory = $item->category_id;
            $itemDescription = $item->description;
            $itemImage = $item->item_image_path;
        }
    }

    $categoryData = json_decode($items->viewCategoryById($itemCategory));
    if (!empty($categoryData)) {
        foreach ($categoryData as $cat) {
            // Access item properties and generate the HTML dynamically
            $categoryName = $cat->category_name;
        }
    }

    $itemInventory = json_decode($items->viewSize($_SESSION['item_id']));

    $itemReview = json_decode($items->viewReviews($_SESSION['item_id']));

    $itemSeller = json_decode($items->viewSellers($seller_id));
    if (!empty($itemSeller)) {
        foreach ($itemSeller as $seller) {
            // Access item properties and generate the HTML dynamically
            $sellerId = $seller->seller_id;
            $sellerName = $seller->seller_name;
            $sellerImage = $seller->profile_image;
            $sellerUsername = $seller->seller_username;
        }
    }

    $item_id = $_SESSION["item_id"];

    $current_folder = basename(__DIR__);
    $dir = "/" . $current_folder;

    ?>


    <div>
        <link href="./view-item.css" rel="stylesheet" />
        <div class="view-item-container">
            <div class="view-item-container01">
                <div id="message"></div>
                <div class="view-item-container02">
                    <img alt="image" src="<?php echo '.' . $itemImage ?>" class="view-item-image" />
                    <div class="view-item-container03">
                        <div class="view-item-container04">
                            <span class="view-item-text">
                                <span class="view-item-text01">
                                    <?php echo $itemName ?>
                                </span>
                                <br />
                            </span>
                            <span class="view-item-text03">
                                <span>$</span>
                                <span>
                                    <?php echo $itemPrice ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="view-item-container05">
                            <div class="view-item-container06"
                                onclick="window.location='viewSellerIndex.php?seller_id=<?php echo $sellerId; ?>'">
                                <img alt="image" src="<?php echo "." . $sellerImage ?>" class="view-item-image1" />
                                <div class="view-item-container07">
                                    <span class="view-item-text07">
                                        <span>
                                            <?php echo $sellerName ?>
                                        </span>
                                    </span>
                                    <span>
                                        <?php echo "@" . $sellerUsername ?>
                                    </span>
                                </div>
                            </div>
                            <div class="view-item-container08">
                                <form action="" class="add-form-submit">
                                    <div class="col-sm-12">
                                        <label for="size">Size</label>
                                        <select id="size" name="size" class="added_size form-control"
                                            style="margin-bottom: 5px; width: 100%;">
                                            <?php
                                            if (!empty($itemInventory)) {
                                                foreach ($itemInventory as $item) {
                                                    $itemSize = $item->size;
                                                    echo "<option value=\"$itemSize\"";
                                                    echo ">$itemSize</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" class="added_id" value="<?= $item_id ?>">
                                    <input type="hidden" class="added_price" value="<?= $itemPrice ?>">
                                    <input type="hidden" class="added_qty" value="1">
                                    <button type="button" class="view-item-button addItemBtn">
                                        <span class="view-item-text13">
                                            <span>Add to cart</span>
                                            <br />
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="view-item-container09"></div>
                    <div class="view-item-container10">
                        <span class="view-item-text16">
                            <span class="view-item-text17">Category</span>
                            <br />
                        </span>
                        <span class="view-item-text19">
                            <span>
                                <?php echo $categoryName ?>
                            </span>
                            <br />
                        </span>
                    </div>
                    <div class="view-item-container11">
                        <span class="view-item-text22">
                            <span class="view-item-text23">Description</span>
                            <br />
                        </span>
                        <span class="view-item-text25">
                            &gt;
                            <?php echo $itemDescription ?>
                        </span>
                    </div>
                    <div class="view-item-container12"></div>
                    <div class="view-item-container13">
                        <span class="view-item-text26">
                            <span>Reviews</span>
                            <br />
                        </span>
                        <?php
                        $current_item_id = $_SESSION["item_id"];

                        if (!empty($itemReview)) {
                            $totalReviews = count($itemReview);
                            $totalRatings = 0; // Variable to store the sum of ratings
                        
                            // Calculate average rating
                            foreach ($itemReview as $review) {
                                $totalRatings += $review->rating_value;
                            }
                            $averageRating = $totalReviews > 0 ? round($totalRatings / $totalReviews, 1) : 0;
                            ?>
                            <span class="view-item-text29">
                                <span>Average Rating:</span>
                                <span>
                                    <?php echo $averageRating; ?> stars
                                </span>
                                <br />
                            </span>
                            <span class="view-item-text33">
                                <span>(
                                    <?php echo $totalReviews; ?> Reviews)
                                </span>
                                <br />
                            </span>
                            <?php

                            // Display individual reviews
                            for ($i = 0; $i < min(3, count($itemReview)); $i++) {
                                $review = $itemReview[$i];
                                $userImage = $review->image_path;
                                $userName = $review->nickname;
                                $rating = $review->rating_value;
                                $reviewText = $review->review_text;
                                $user_username = $review->username;
                                ?>
                                <div class="view-item-container14">
                                    <img alt="image" src="<?php echo "." . $userImage; ?>" class="view-item-image2" />
                                    <div class="view-item-container15">
                                        <div class="view-item-container16">
                                            <span class="view-item-text36">
                                                <span>
                                                    <?php echo $userName; ?>
                                                </span>
                                            </span>
                                            <span>
                                                <?php echo "@" . $user_username; ?>
                                            </span>
                                            <span class="view-item-text39">
                                                <span class="view-item-text40">
                                                    <?php echo $rating; ?> star
                                                </span>
                                                <br />
                                            </span>
                                        </div>
                                        <span class="view-item-text42">
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
                    <button class="view-item-button" id="viewMoreBtn"
                        onclick="window.location='viewItemReviews.php?item_id=<?php echo $current_item_id; ?>'">
                        <span class="view-item-text13">
                            View More
                        </span>
                    </button>
                    <?php
                    include dirname(__FILE__) . ('/similaritem.php');
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script type="text/javascript">
        $(document).ready(function () {

            // Send product details in the server
            $(".addItemBtn").click(function (e) {
                e.preventDefault();
                var id = $(".add-form-submit .added_id").val();
                var price = $(".add-form-submit .added_price").val();
                var size = $(".add-form-submit .added_size").val();
                var qty = $(".add-form-submit .added_qty").val();

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {
                        id: id,
                        price: price,
                        size: size,
                        qty: qty
                    },
                    success: function (response) {
                        console.log(response);
                        $("#message").html(response);
                        window.scrollTo(0, 0);
                    }
                });
            });
        });
    </script>
</body>

</html>