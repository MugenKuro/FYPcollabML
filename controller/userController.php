<?php

// Include file
require_once dirname(__FILE__) . '/../entity/users.php';
require_once dirname(__FILE__) . '/../entity/customers.php';
require_once dirname(__FILE__) . '/../entity/orderhistory.php';
require_once dirname(__FILE__) . '/../entity/itemratings.php';
require_once dirname(__FILE__) . '/../entity/items.php';
require_once dirname(__FILE__) . '/../entity/cartitems.php';
require_once dirname(__FILE__) . '/../entity/inventory.php';
require_once dirname(__FILE__) . '/../entity/sellers.php';
require_once dirname(__FILE__) . '/../entity/shoppingcarts.php';
require_once dirname(__FILE__) . '/../entity/sellerratings.php';

class registerController{
    
    
    public function customerRegister($email, $username, $password, $nickname, $gender, $dob, $firstname, $lastname, $image, $mobile, $address){
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        //Create instance of User
        $new_user = new Users();
        
        //Register User
        $register = json_decode($new_user->customerRegister($email, $username, $param_password, $nickname, $gender, $dob, $firstname, $lastname, $image, $mobile, $address));

        return json_encode($register);
    }

    public function indSellerRegister($email, $username, $password, $sellername, $image_path_profimage, $prefCategory, $bankname, $bankno, $description, 
    $fullname, $dob, $mobile, $passport, $combinedAddress, $combinedPAddress) {
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        //Create instance of User
        $new_user = new Users();
        
        //Register User
        $register = json_decode($new_user->indSellerRegister($email, $username, $param_password, $sellername, $image_path_profimage, $prefCategory, $bankname, $bankno, $description, 
        $fullname, $dob, $mobile, $passport, $combinedAddress, $combinedPAddress));

        return json_encode($register);

    }

    public function bizSellerRegister($email, $username, $password, $sellername, $image_path_profimage, $prefCategory, $bankname, $bankno, $description, 
    $businessname, $uen, $combinedAddress, $combinedPAddress, $image_path_acra) {
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        //Create instance of User
        $new_user = new Users();
        
        //Register User
        $register = json_decode($new_user->bizSellerRegister($email, $username, $param_password, $sellername, $image_path_profimage, $prefCategory, $bankname, $bankno, $description, 
        $businessname, $uen, $combinedAddress, $combinedPAddress, $image_path_acra));

        return json_encode($register);
    }

}

class loginController{
    public function login() {
        $user = new users();
        $login = json_decode($user->login());

        return json_encode($login);
    }
}

class viewAccountSettings {
    public function getUserDetails($user_id) {
        $user = new users();
        $settings = json_decode($user->getUserDetails($user_id));

        return json_encode($settings);
    }

    public function getCustomerDetails($user_id) {
        $customer = new customers();
        $settings = json_decode($customer->getCustomerDetails($user_id));

        return json_encode($settings);

    }

}

class updateAccountDetails {
    public function updateAccDetails($user_id, $username_change, $username, $password = NULL, $email, $nickname, $gender, 
    $date_of_birth, $first_name, $last_name, $image_path=NULL, $address, $mobile) {
        $user = new users();
        if (!is_null($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        $updateUser = json_decode($user->updateUser($user_id, $username_change, $username, $password, $email));

        $customer = new customers();
        if ($updateUser->status != 'error') {
            $updateCustomer = json_decode($customer->updateCustomer($user_id, $nickname, $gender, $date_of_birth, $first_name, $last_name, $image_path, $address, $mobile));

            if ($updateCustomer->status == 'success' || ($updateCustomer->status == 'nothing' && $updateUser->status == 'success')) {
                $resp['status'] = 'success';
            } elseif ($updateCustomer->status == 'nothing' && $updateUser->status == 'nothing') {
                $resp['status'] = 'nothing';
            } else {
                $resp['status'] = 'error';
            }

        } else {
            $resp['status'] = 'error';
        }

        return json_encode($resp);
    }

}

class deactivateCustomerAccount {
    public function deactivateCustAcc($user_id) {
        $user = new users();
        $deactivateUser = json_decode($user->deactivateUser($user_id));

        if ($deactivateUser->status == 'success') {
            $resp['status'] = 'success';
        } elseif ($deactivateUser->status == 'nothing') {
            $resp['status'] = 'nothing';
        } else {
            $resp['status'] = 'error';
        }
        return json_encode($resp);
    }
}

class viewPurchaseHistory {
    public function viewPurchasesHistory($user_id) {
        $order = new orderhistory();
        $data = json_decode($order->viewAllOrderHistory($user_id));

        return json_encode($data);
    }

}

class ratePurchasedItem {
    public function addItemRating($customer_id, $item_id, $rating_value, $review_text) {
        $rate = new itemratings();
        $data = json_decode($rate->addItemRating($customer_id, $item_id, $rating_value, $review_text));

        return json_encode($data);
    }
}

class viewItemByCat {
    public function viewItemByCategory($category_id) {
        $items = new items();
        $data = json_decode($items->viewItemByCategory($category_id));

        return json_encode($data);
    }
}

class viewAnItem {
    public function viewItem($item_id) {
        $items = new items();
        $data = json_decode($items->viewItem($item_id));

        return json_encode($data);
    }

    public function viewCategoryById($category_id)
    {
        $category = new categories();
        $data = json_decode($category->viewCategoryById($category_id));

        return json_encode($data);
    }

    public function viewSize($item_id) {
        $inventory = new inventory();
        $data = json_decode($inventory->viewInventory($item_id));

        return json_encode($data);
    }

    public function viewReviews($item_id) {
        $reviews = new itemratings();
        $data = json_decode($reviews->viewReviewByItem($item_id));

        return json_encode($data);
    }

    public function viewSellers($seller_id) {
        $sellers = new sellers();
        $data = json_decode($sellers->viewSellers($seller_id));

        return json_encode($data);
    }
    
}

class searchItemByName {
    public function searchItem($tags) {
        $items = new items();
        $data = json_decode($items->searchItemByName($tags));

        return json_encode($data);
    }
}

class viewCartItems {
    public function checkIfCartExist($user_id) {
        $cart = new shoppingcarts();
        $data = $cart->checkIfCartExist($user_id);

        return $data;
    }

    public function viewCartItem($cart_id) {
        $cartitems = new cartitems();
        $data = json_decode($cartitems->viewCartItem($cart_id));

        return json_encode($data);
    }
}

class addItemsToCart {
    public function checkIfCartExist($user_id) {
        $cart = new shoppingcarts();
        $data = $cart->checkIfCartExist($user_id);

        return $data;
    }

    public function addToCart($cart_id, $item_id, $size, $quantity) {
        $cart = new cartitems();
        $data = $cart->addCartItem($cart_id, $item_id, $size, $quantity);

        return $data;
    }

    public function updateCartPrice($cart_id, $total_price) {
        $cart = new shoppingcarts();
        $data = $cart->updateCartPrice($cart_id, $total_price);

        return $data;
    }
}

class clearCartItems {
    public function clearCart($cart_id) {
        $cart = new cartitems();
        $data = $cart->clearCart($cart_id);

        return $data;
    }

    public function updateCartPriceToZero($cart_id) {
        $cart = new shoppingcarts();
        $data = $cart->updateCartPriceToZero($cart_id);

        return $data;
    }
}

class removeAnCartItem {
    public function removeAnItem($cart_item_id) {
        $cart = new cartitems();
        $data = $cart->removeAnItem($cart_item_id);

        return $data;
    }

    public function updateCartPriceMinus($cart_id, $price) {
        $cart = new shoppingcarts();
        $data = $cart->updateCartPriceMinus($cart_id, $price);

        return $data;
    }
}

class checkOutCart {
    public function updateCartPriceTotal($cart_id, $total_price, $cartItemId) {
        $cart = new shoppingcarts();
        $data = $cart->updateCartPriceTotal($cart_id, $total_price, $cartItemId);

        return $data;
    }

    public function viewStock($cart_item_id) {
        $cart = new inventory();
        $data = $cart->viewStock($cart_item_id);

        return $data;
    }

    public function updateCartItemQty($cart_item_id, $quantity) {
        $cart = new cartitems();
        $data = $cart->updateCartItemQty($cart_item_id, $quantity);

        return $data;
    }
}

class makePayment {
    public function decreaseQuantity($cart_item_id) {
        $cart = new inventory();
        $data = $cart->decreaseQuantity($cart_item_id);

        return $data;
    }

    public function addOrderHistory($cart_id, $user_id) {
        $order = new orderhistory();
        $data = $order->addOrderHistory($cart_id, $user_id);

        return $data;
    }

    public function checkOutCart($cart_id) {
        $cart = new shoppingcarts();
        $data = $cart->setCartInactive($cart_id);

        return $data;
    }
}

class viewSeller{
    public function viewItemBySeller($seller_id) {
        $items = new items();
        $data = json_decode($items->viewItemBySeller($seller_id));

        return json_encode($data);
    }

    public function viewSellers($seller_id) {
        $seller = new sellers();
        $data = json_decode($seller->viewSellers($seller_id));

        return json_encode($data);
    }
}

class viewSellerReviews {
    public function viewReviewBySeller($seller_id) {
        $seller = new sellerratings();
        $data = json_decode($seller->viewReviewBySeller($seller_id));

        return json_encode($data);
    }
}



?>