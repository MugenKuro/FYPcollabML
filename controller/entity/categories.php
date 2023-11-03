<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class categories {
    private $category_id;
    private $category_name;
    private $status;

    public function __construct($category_id = NULL, $category_name = NULL, $status = NULL) 
    {
        $this->category_id = $category_id;
        $this->category_name = $category_name;
        $this->status = $status;
    }
    // Getters
    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function viewAllCategories() {
        $sql = "SELECT * FROM `categories`";
        $db = new Db();
        $result = $db->query($sql);
    
        $data = array(); // Initialize an empty array to store category data
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Add each category row to the $data array
            }
        } else {
            $_SESSION['category']['error'] = 'Unable to fetch categories.';
        }
    
        return json_encode($data);
    }
    
    public function viewCategoryById($category_id) {
        $sql = "SELECT * FROM `categories` WHERE category_id = $category_id";
        $db = new Db();
        $result = $db->query($sql);
    
        $data = array(); // Initialize an empty array to store category data
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Add each category row to the $data array
            }
        } else {
            $_SESSION['category']['error'] = 'Unable to fetch categories.';
        }
    
        return json_encode($data);
    }


}



?>