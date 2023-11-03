<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class items {
    private $item_id;
    private $seller_id;
    private $item_name;
    private $category_id;
    private $price;
    private $description;
    private $item_image_path;


    public function __construct($item_id = null, $seller_id = null, $item_name = null, $category_id = null, $price = null, $description = null, $item_image_path = null) {
        $this->item_id = $item_id;
        $this->seller_id = $seller_id;
        $this->item_name = $item_name;
        $this->category_id = $category_id;
        $this->price = $price;
        $this->description = $description;
        $this->item_image_path = $item_image_path;
    }

    public function getItemId() {
        return $this->item_id;
    }

    public function getSellerId() {
        return $this->seller_id;
    }

    public function getItemName() {
        return $this->item_name;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getItemImagePath() {
        return $this->item_image_path;
    }


    public function viewItemByCategory($category_id) {
        $sql = "SELECT * FROM `items` where `category_id` = $category_id";
        $db = new Db();
        $result = $db->query($sql);

    
        $data = array(); // Initialize an empty array to store category data
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Add each category row to the $data array
            }
        } else {
            $_SESSION['viewItemByCategory']['error'] = 'Unable to fetch any details.';
        }
    
        return json_encode($data);
    }
    
    public function viewItem($item_id) {
        $sql = "SELECT * FROM `items` where `item_id` = $item_id";
        $db = new Db();
        $result = $db->query($sql);
        $data = array(); // Initialize an empty array to store category data
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Add each category row to the $data array
            }
        } else {
            $_SESSION['viewItemByCategory']['error'] = 'Unable to fetch any details.';
        }
    
        return json_encode($data);

    }
    


}



?>