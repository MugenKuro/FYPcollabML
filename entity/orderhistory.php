<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class orderhistory {
    private $order_id;
    private $customer_id;
    private $cart_id;
    private $order_date;

    public function __construct($order_id = NULL, $customer_id = NULL, $cart_id = NULL, $order_date = NULL) 
    {
        $this->order_id = $order_id;
        $this->customer_id = $customer_id;
        $this->cart_id = $cart_id;
        $this->order_date = $order_date;
    }

    // Getters
    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function getCartId()
    {
        return $this->cart_id;
    }

    public function getOrderDate()
    {
        return $this->order_date;
    }

    public function viewAllOrderHistory($user_id) {
        $sql = "SELECT i.item_id, c.customer_id, i.item_image_path, i.item_name, i.price * ci.quantity as total_price, oh.order_date 
        FROM `items` as i, `customers` as c, `shoppingcarts` as sc, `orderhistory` as oh, `cartitems` as ci
        WHERE i.item_id = ci.item_id AND ci.cart_id = sc.cart_id AND sc.cart_id = oh.cart_id AND sc.customer_id = c.customer_id AND c.user_id = '$user_id'
        ORDER BY oh.order_date DESC";
        $db = new Db();
        $result = $db->query($sql);
    
        $data = array(); // Initialize an empty array
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Add each row to the $data array
            }
        } else {
            $_SESSION['viewAllOrderHistory']['error'] = 'Unable to fetch any result.';
        }
    
        return json_encode($data);
    }

    public function addOrderHistory($cart_id, $user_id) {
        $sql = "INSERT INTO OrderHistory (customer_id, cart_id, order_date) 
        SELECT customers.customer_id, $cart_id, CONVERT_TZ(NOW(), '+00:00', '+08:00')
        FROM customers 
        WHERE customers.user_id = $user_id";
        $db = new Db();
        $result = $db->query($sql);
        $data = false;
    
        if ($result > 0) {
            $data = true;
        }
    
        return $data;
    }
    


}



?>