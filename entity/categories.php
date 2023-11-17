<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class categories
{
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

    public function viewAllCategories()
    {
        $sql = "SELECT * FROM `categories` WHERE status = 'Active'";
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

    public function viewCategoryById($category_id)
    {
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

    public function viewTopCategories()
    {
        $sql = "SELECT 
        category_name,
        item_image_path
    FROM (
        SELECT 
            c.category_name,
            i.item_image_path,
            ROW_NUMBER() OVER (PARTITION BY c.category_id ORDER BY item_count DESC) AS rnum,
            item_count
        FROM 
            Categories c
        JOIN 
            Items i ON c.category_id = i.category_id
        LEFT JOIN (
            SELECT 
                c.category_id,
                i.item_id,
                SUM(ci.quantity) AS item_count
            FROM 
                OrderHistory o
            JOIN 
                CartItems ci ON o.cart_id = ci.cart_id
            JOIN 
                Items i ON ci.item_id = i.item_id
            JOIN 
                Categories c ON i.category_id = c.category_id
            GROUP BY 
                c.category_id, i.item_id
        ) item_counts ON i.item_id = item_counts.item_id
    ) ranked_items
    WHERE 
        rnum = 1
    ORDER BY 
        item_count DESC, category_name
    LIMIT 
        6";

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