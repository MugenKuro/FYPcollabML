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

// request data
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["item_id"]) || !isset($_GET["customer_id"])) {
        header("location: purchaseHistory.php");
        exit;
    }
    $_SESSION["item_id"] = $_GET["item_id"];
    ;
    $_SESSION["customer_id"] = $_GET["customer_id"];
    ;

} else {
    $rate = new ratePurchasedItem();
    extract($_POST);
    $rating = json_decode($rate->addItemRating($_SESSION["customer_id"], $_SESSION["item_id"], $rating, $review));
    if ($rating->status == 'success') {
        $_SESSION['flashdata']['type'] = 'success';
        $_SESSION['flashdata']['msg'] = 'Review added successfully.';
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
</head>

<body>

    <?php
    include dirname(__FILE__) . ('/custNavBar.php');
    ?>

    <div>
        <div class="rate-item-container">
            <div class="rate-item-container1">

                <div class="rate-item-container2">
                    <span class="rate-item-text">
                        <span>How was your experience?</span>
                        <br />
                    </span>
                </div>
                <div class="rate-item-container3"></div>
                <div class="rate-item-container4">
                    <form class="update-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                        method="post" enctype="multipart/form-data">
                        <?php
                        if (isset($_SESSION['flashdata'])):
                            ?>
                            <div
                                class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?> my-2 rounded-0">
                                <div class="d-flex align-items-center">
                                    <div class="col-11">
                                        <?php echo $_SESSION['flashdata']['msg'] ?>
                                    </div>
                                    <div class="col-1 text-end">
                                        <div class="float-end"><a href="javascript:void(0)"
                                                class="text-dark text-decoration-none"
                                                onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php unset($_SESSION['flashdata']) ?>
                        <?php endif; ?>
                        <div class="rate-item-container5">
                            <span class="rate-item-text03">
                                <span>Rate</span>
                                <span>this</span>
                                <span>product</span>
                                <br />
                            </span>
                            <select id="rating" name="rating" class="form-control rate-item-select" required>
                                <option value="1" <?php if (isset($_POST['rating']) && $_POST['rating'] === '1')
                                    echo 'selected'; ?>>1</option>
                                <option value="2" <?php if (isset($_POST['rating']) && $_POST['rating'] === '2')
                                    echo 'selected'; ?>>2</option>
                                <option value="3" <?php if (isset($_POST['rating']) && $_POST['rating'] === '3')
                                    echo 'selected'; ?>>3</option>
                                <option value="4" <?php if (isset($_POST['rating']) && $_POST['rating'] === '4')
                                    echo 'selected'; ?>>4</option>
                                <option value="5" <?php if (isset($_POST['rating']) && $_POST['rating'] === '5')
                                    echo 'selected'; ?>>5</option>
                            </select>
                        </div>
                        <div class="rate-item-container6">

                            <label class="rate-item-text08" for="review">Your Review</label>
                            <textarea id="review" name="review" class="form-control"
                                placeholder="Share about your experience on this product" rows="4"
                                required><?= isset($_POST['review']) ? $_POST['review'] : '' ?></textarea>
                        </div>
                        <div class="rate-item-container7">
                            <div class="rate-item-container8">
                                <button type="submit" class="rate-item-button button">
                                    <span class="rate-item-text11">
                                        <span>Submit</span>
                                        <br />
                                    </span>
                                </button>
                                <button type="button" class="rate-item-button1 button"
                                    onclick="window.location='purchaseHistory.php'">
                                    <span class="rate-item-text14">
                                        <span class="rate-item-text15">Cancel</span>
                                        <br />
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</body>

</html>