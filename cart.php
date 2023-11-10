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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div style="display:<?php if (isset($_SESSION['showAlert'])) {
                    echo $_SESSION['showAlert'];
                } else {
                    echo 'none';
                }
                unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>
                        <?php if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                        }
                        unset($_SESSION['showAlert']); ?>
                    </strong>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <td colspan="8">
                                    <h4 class="text-center text-info m-0">Products in your cart!</h4>
                                </td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>
                                    <a href="action.php?clear=all" class="badge-danger badge p-1"
                                        style="background-color: red;"
                                        onclick="return confirm('Are you sure want to clear your cart?');"><i
                                            class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cartitems = new viewCartItems();
                            $cart_id = $cartitems->checkIfCartExist($_SESSION['user_id']);
                            $_SESSION['cart_id'] = $cart_id;
                            $itemData = json_decode($cartitems->viewCartItem($cart_id));
                            $grand_total = 0;
                            $current_folder = basename(__DIR__);
                            $dir = "/" . $current_folder;
                            if (empty($itemData)) {
                                echo '<tr><td colspan="8">No items found in the cart</td></tr>';
                            } else {
                                foreach ($itemData as $item):
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $item->cart_item_id ?>
                                        </td>
                                        <input type="hidden" class="pid" value="<?= $item->cart_item_id ?>">

                                        <td><img src="<?= $dir . $item->item_image_path ?>" width="50"></td>

                                        <td>
                                            <?= $item->item_name ?>
                                        </td>

                                        <td>
                                            <?= $item->size ?>
                                        </td>

                                        <td>
                                            <i class="fas fa-dollar-sign"></i>&nbsp;&nbsp;
                                            <?= number_format($item->price, 2); ?>
                                        </td>
                                        <input type="hidden" class="pprice" value="<?= $item->price ?>">

                                        <td>
                                            <input type="number" class="form-control itemQty" value="<?= $item->quantity ?>"
                                                style="width:75px;">
                                        </td>

                                        <td><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp;
                                            <?= number_format($item->price * $item->quantity, 2); ?>
                                        </td>
                                        <td>
                                            <a href="action.php?remove=<?= $item->cart_item_id ?>&price=<?= $item->price ?>" class="text-danger lead"
                                                onclick="return confirm('Are you sure want to remove this item?');"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php $grand_total += $item->total_price; ?>

                                <tr>
                                    <td colspan="3">
                                        <a href="index.php" class="btn btn-success"><i
                                                class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                                            Shopping</a>
                                    </td>
                                    <td colspan="2"><b>Grand Total</b></td>
                                    <td><b><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp;
                                            <?= number_format($grand_total, 2); ?>
                                        </b></td>
                                    <td colspan="2">
                                        <a href="checkout.php"
                                            class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i
                                                class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




</body>

</html>