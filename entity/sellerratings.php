<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class sellerratings {
    private $rating_id;
    private $customer_id;
    private $seller_id;
    private $rating_value;
    private $review_text;

    public function __construct($rating_id=NULL, $customer_id=NULL, $seller_id=NULL, $rating_value=NULL, $review_text=NULL) {
        $this->rating_id = $rating_id;
        $this->customer_id = $customer_id;
        $this->seller_id = $seller_id;
        $this->rating_value = $rating_value;
        $this->review_text = $review_text;
    }

    public function getRatingId() {
        return $this->rating_id;
    }

    public function getCustomerId() {
        return $this->customer_id;
    }

    public function getSellerId() {
        return $this->seller_id;
    }

    public function getRatingValue() {
        return $this->rating_value;
    }

    public function getReviewText() {
        return $this->review_text;
    }

    public function addSellerRating($customer_id, $seller_id, $rating_value, $review_text) {
        $db = new Db();
        $customer_id = $db->escape($customer_id);
        $seller_id = $db->escape($seller_id);
        $rating_value = $db->escape($rating_value);
        $review_text = $db->escape($review_text);
        $sql = "SELECT * FROM `sellerratings` where `customer_id` = $customer_id AND `seller_id` = $seller_id ";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type2'] = 'danger';
            $_SESSION['flashdata']['msg2'] = 'You have rated this seller.';
        } else {
            $sql = "INSERT INTO `sellerratings` (`customer_id`, `seller_id`, `rating_value`, `review_text`) 
            VALUES ('$customer_id', '$seller_id', '$rating_value', '$review_text')";
            $save = $db->query($sql);
            if ($save) {
                $resp['status'] = 'success';
            } else {
                $resp['status'] = 'failed';
            }
        }
    
        return json_encode($resp);
    }

    public function viewReviewBySeller($seller_id) {
        $sql = "SELECT sr.rating_id, c.customer_id, u.username, c.nickname, c.image_path, sr.rating_value, sr.review_text
        FROM sellerratings as sr
        JOIN customers as c ON sr.customer_id = c.customer_id
        JOIN users as u ON c.user_id = u.user_id
        WHERE sr.seller_id = $seller_id
        ORDER BY sr.rating_id DESC";
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