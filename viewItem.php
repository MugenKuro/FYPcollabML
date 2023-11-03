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
    if (!isset($_GET["item_id"])) {
        header("location: viewItemByCat.php");
        exit;
    }
    $_SESSION["item_id"] = $_GET["item_id"];
    ;

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

    $category = new viewCatById();
    $categoryData = json_decode($category->viewCategoryById($itemCategory));
    if (!empty($categoryData)) {
        foreach ($categoryData as $cat) {
            // Access item properties and generate the HTML dynamically
            $categoryName = $cat->category_name;
        }
    }

    $current_folder = basename(__DIR__);
    $dir = "/" . $current_folder;

    ?>


        <div>
            <link href="./view-item.css" rel="stylesheet" />
            <div class="view-item-container">
                <div class="view-item-container01">
                    <div class="view-item-container02">
                        <img alt="image" src="<?php echo $dir . $itemImage?>" class="view-item-image" />
                        <div class="view-item-container03">
                            <div class="view-item-container04">
                                <span class="view-item-text">
                                    <span class="view-item-text01">Alexander McQueen Shirt</span>
                                    <br />
                                </span>
                                <span class="view-item-text03">
                                    <span>$</span>
                                    <span>100</span>
                                    <br />
                                </span>
                            </div>
                            <div class="view-item-container05">
                                <div class="view-item-container06">
                                    <img alt="image" src="./images/default_user.jpg" class="view-item-image1" />
                                    <div class="view-item-container07">
                                        <span class="view-item-text07">
                                            <span>Hype Tshirt seller</span>
                                            <br />
                                        </span>
                                        <span class="view-item-text10">
                                            <span class="view-item-text11">5 star</span>
                                            <br />
                                        </span>
                                    </div>
                                </div>
                                <div class="view-item-container08">
                                    <button type="button" class="view-item-button button"
                                        onclick="window.location='cart.php'">
                                        <span class="view-item-text13">
                                            <span>Add to cart</span>
                                            <br />
                                        </span>
                                    </button>
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
                                <span>T-Shirt</span>
                                <br />
                            </span>
                        </div>
                        <div class="view-item-container11">
                            <span class="view-item-text22">
                                <span class="view-item-text23">Description</span>
                                <br />
                            </span>
                            <span class="view-item-text25">
                                &gt; Only provide the best with reasonable price
                            </span>
                        </div>
                        <div class="view-item-container12"></div>
                        <div class="view-item-container13">
                            <span class="view-item-text26">
                                <span>Reviews</span>
                                <br />
                            </span>
                            <span class="view-item-text29">
                                <span>5 Star</span>
                                <span>Review</span>
                                <br />
                            </span>
                            <span class="view-item-text33">
                                <span>(3 Reviews)</span>
                                <br />
                            </span>
                            <div class="view-item-container14">
                                <img alt="image" src="./images/default_user.jpg" class="view-item-image2" />
                                <div class="view-item-container15">
                                    <div class="view-item-container16">
                                        <span class="view-item-text36">
                                            <span>Hannel</span>
                                            <br />
                                        </span>
                                        <span class="view-item-text39">
                                            <span class="view-item-text40">5 star</span>
                                            <br />
                                        </span>
                                    </div>
                                    <span class="view-item-text42">
                                        <span>Product was amazing, good quality.</span>
                                        <br />
                                    </span>
                                </div>
                            </div>
                            <div class="view-item-container17">
                                <img alt="image" src="./images/default_user.jpg" class="view-item-image3" />
                                <div class="view-item-container18">
                                    <div class="view-item-container19">
                                        <span class="view-item-text45">
                                            <span>feebee</span>
                                            <br />
                                        </span>
                                        <span class="view-item-text48">
                                            <span class="view-item-text49">5 star</span>
                                            <br />
                                        </span>
                                    </div>
                                    <span class="view-item-text51">
                                        <span>T-shirt was amazing, love it.</span>
                                        <br />
                                    </span>
                                </div>
                            </div>
                            <div class="view-item-container20">
                                <img alt="image" src="./images/default_user.jpg" class="view-item-image4" />
                                <div class="view-item-container21">
                                    <div class="view-item-container22">
                                        <span class="view-item-text54">
                                            <span>Marina1231</span>
                                            <br />
                                        </span>
                                        <span class="view-item-text57">
                                            <span class="view-item-text58">5 star</span>
                                            <br />
                                        </span>
                                    </div>
                                    <span class="view-item-text60">
                                        <span>good</span>
                                        <br />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="view-item-container23">
                            <span class="view-item-text63">
                                <span>Similar Items</span>
                                <br />
                            </span>
                            <div class="view-item-container24">
                                <div class="view-item-container25">
                                    <img alt="image" src="./images/vintage_hooters_tshirt.jpg" class="view-item-image5" />
                                    <span>
                                        <span>Vintage Hooter T-Shirt</span>
                                        <br />
                                    </span>
                                    <span>$30</span>
                                </div>
                                <div class="view-item-container26">
                                    <img alt="image" src="./images/authentic_adidas_shirt_hiroko.jpg"
                                        class="view-item-image6" />
                                    <span>
                                        <span>Authentic Adidas Tokyo shirt</span>
                                        <br />
                                    </span>
                                    <span>$25</span>
                                </div>
                                <div class="view-item-container27">
                                    <img alt="image" src="./images/jordan_x_j_balvin_shirt.jpg" class="view-item-image7" />
                                    <span>
                                        <span>Jordan x J balvin shirt</span>
                                        <br />
                                    </span>
                                    <div class="view-item-container28">
                                        <span>
                                            <span>$40</span>
                                            <br />
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>