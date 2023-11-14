<?php
session_start();
require_once dirname(__FILE__) . '/controller/userController.php';

// Add products into the cart table
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $qty = $_POST['qty'];
    $total_price = $price * $qty;

    $cart = new addItemsToCart();
    $cart_id = $cart->checkIfCartExist($_SESSION['user_id']);

    if (isset($cart_id)) {
        $addtocart = $cart->addToCart($cart_id, $id, $size, $qty);
        $updateshoppingcart = $cart->updateCartPrice($cart_id, $total_price);
        if ($addtocart) {
            echo '<div class="alert alert-success alert-dismissible mt-2">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Item added to your cart!</strong>
            </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible mt-2">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Item already added to your cart!</strong>
            </div>';
        }
    } else {
        echo '<div class="alert alert-danger alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Something went wrong!</strong>
                </div>';
    }
}

// Remove all items at once from cart
if (isset($_GET['clear'])) {
    $cart = new clearCartItems();
    $result = $cart->clearCart($_SESSION['cart_id']);
    $result2 = $cart->updateCartPriceToZero($_SESSION['cart_id']);

    if ($result) {
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'All Item removed from the cart!';
        header('location:cart.php');
    } else {
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Nothing in the cart!';
        header('location:cart.php');
    }
}

// Remove single items from cart
if (isset($_GET['remove']) && isset($_GET['price'])) {
    $id = $_GET['remove'];
    $price = $_GET['price'];

    $cart = new removeAnCartItem();
    $result = $cart->removeAnItem($id);
    $result2 = $cart->updateCartPriceMinus($_SESSION['cart_id'], $price);

    if ($result) {
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Item removed from the cart!';
        header('location:cart.php');
    } else {
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Item does not exist!';
        header('location:cart.php');
    }
}

// Set total price of the product in the cart table
if (isset($_POST['itemQty'])) {
    $itemQty = $_POST['itemQty'];
    $cartItemId = $_POST['itemId'];
    $itemPrice = $_POST['itemPrice'];

    $tprice = $itemQty * $itemPrice;

    $cart = new checkOutCart();

    $quantity = (int)$cart->viewStock($cartItemId);
    if (isset($quantity) && $itemQty > 0 && $itemQty <= $quantity) {

        $result2 = $cart->updateCartPriceTotal($_SESSION['cart_id'], $tprice, $cartItemId);
        $result = $cart->updateCartItemQty($cartItemId, $itemQty);
        if ($result && $result2) {
            $cartitems = new viewCartItems();
            // Fetch the updated itemData
            $updatedItemData = json_decode($cartitems->viewCartItem($_SESSION['cart_id']));

            // Echo the updated data
            echo json_encode($updatedItemData);
        } else {
            $_SESSION['showAlert'] = 'block';
            $_SESSION['message'] = 'Error. Something went wrong!';
            
        }

    } elseif (isset($quantity) && $itemQty <= 0) {
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Quantity cannot be negative!';
        
    } elseif (isset($quantity) && $itemQty > $quantity) {
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Quantity exceed current stock!';
        
    } else {
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Error. Something went wrong!';
        
    }

}

?>