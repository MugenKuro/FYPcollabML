<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class sellers {
    private $seller_id;
    private $user_id;
    private $seller_type;
    private $seller_name;
    private $description;
    private $profile_image;
    private $bank_name;
    private $bank_account_no;
    private $puck_up_address;
    private $preferred_category;

    public function __construct($seller_id = null, $user_id = null, $seller_type = null, $seller_name = null, $description = null, 
    $profile_image = null, $bank_name = null, $bank_account_no = null, $puck_up_address = null, $preferred_category = null) {
        $this->seller_id = $seller_id;
        $this->user_id = $user_id;
        $this->seller_type = $seller_type;
        $this->seller_name = $seller_name;
        $this->description = $description;
        $this->profile_image = $profile_image;
        $this->bank_name = $bank_name;
        $this->bank_account_no = $bank_account_no;
        $this->puck_up_address = $puck_up_address;
        $this->preferred_category = $preferred_category;
    }

    // Getters
    public function getSellerId() {
        return $this->seller_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getSellerType() {
        return $this->seller_type;
    }

    public function getSellerName() {
        return $this->seller_name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getProfileImage() {
        return $this->profile_image;
    }

    public function getBankName() {
        return $this->bank_name;
    }

    public function getBankAccountNo() {
        return $this->bank_account_no;
    }

    public function getPuckUpAddress() {
        return $this->puck_up_address;
    }

    public function getPreferredCategory() {
        return $this->preferred_category;
    }

    public function viewSellers($seller_id) {
        $sql = "SELECT *
        FROM `sellers`
        WHERE `seller_id` = $seller_id";
        $db = new Db();
        $result = $db->query($sql);
        $data = array(); // Initialize an empty array to store category data
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Add each category row to the $data array
            }
        }
    
        return json_encode($data);

    }
    

}



?>