<?php

// Include file
require_once dirname(__FILE__) . '\..\entity\users.php';
require_once dirname(__FILE__) . '\..\entity\customers.php';

class registerController{
    
    
    public function customerRegister($email, $username, $password, $nickname, $gender, $dob, $firstname, $lastname, $image, $mobile, $address){
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        //Create instance of User
        $new_user = new Users();
        
        //Register User
        $register = json_decode($new_user->customerRegister($email, $username, $param_password, $nickname, $gender, $dob, $firstname, $lastname, $image, $mobile, $address));

        return json_encode($register);
    }

    public function indSellerRegister($email, $username, $password, $sellername, $image_path_profimage, $bankname, $bankno, $description, 
    $fullname, $dob, $mobile, $passport, $combinedAddress, $combinedPAddress) {
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        //Create instance of User
        $new_user = new Users();
        
        //Register User
        $register = json_decode($new_user->indSellerRegister($email, $username, $param_password, $sellername, $image_path_profimage, $bankname, $bankno, $description, 
        $fullname, $dob, $mobile, $passport, $combinedAddress, $combinedPAddress));

        return json_encode($register);

    }

    public function bizSellerRegister($email, $username, $password, $sellername, $image_path_profimage, $bankname, $bankno, $description, 
    $businessname, $uen, $combinedAddress, $combinedPAddress, $image_path_acra) {
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        //Create instance of User
        $new_user = new Users();
        
        //Register User
        $register = json_decode($new_user->bizSellerRegister($email, $username, $param_password, $sellername, $image_path_profimage, $bankname, $bankno, $description, 
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
    

}




?>