<?php

// Include file
require_once dirname(__FILE__) . '\..\entity\users.php';
require_once dirname(__FILE__) . '\..\entity\customers.php';
require_once dirname(__FILE__) . '\..\entity\orderhistory.php';
require_once dirname(__FILE__) . '\..\entity\itemratings.php';
require_once dirname(__FILE__) . '\..\entity\items.php';

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
}




?>