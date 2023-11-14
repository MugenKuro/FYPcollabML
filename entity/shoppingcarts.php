<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class shoppingcarts {
    private $cart_id;
    private $customer_id;
    private $total_price;
    private $delivery_address;
    private $status;

    public function __construct($cart_id = null, $customer_id = null, $total_price = null, $delivery_address = null, $status = null) {
        $this->cart_id = $cart_id;
        $this->customer_id = $customer_id;
        $this->total_price = $total_price;
        $this->delivery_address = $delivery_address;
        $this->status = $status;
    }

    // Getters
    public function getCartId() {
        return $this->cart_id;
    }

    public function getCustomerId() {
        return $this->customer_id;
    }

    public function getTotalPrice() {
        return $this->total_price;
    }

    public function getDeliveryAddress() {
        return $this->delivery_address;
    }

    public function getStatus() {
        return $this->status;
    }

    public function checkIfCartExist($user_id) {
        $sql = "SELECT sc.cart_id
        FROM `shoppingcarts` as sc, `customers` as c
        WHERE sc.customer_id = c.customer_id
        AND c.user_id = $user_id AND sc.status = 'Active'";
        $db = new Db();
        $result = $db->query($sql);
        $data = '';
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = $row['cart_id'];

        } elseif ($result->num_rows == 0) {
            $sql = "SELECT customer_id, address FROM customers WHERE user_id = $user_id";
            $result = $db->query($sql);
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $customer_id = $row['customer_id'];
                $address = $row['address'];
            
                $insert_sql = "INSERT INTO shoppingcarts (customer_id, total_price, delivery_address, status) VALUES ('$customer_id', '0', '$address', 'Active')";
                $result = $db->query($insert_sql);
                if ($result > 0) {
                    $data = $db->getLastInsertedId();
                }
                
            }
        }
    
        return $data;

    }

    public function updateCartPrice($cart_id, $total_price) {
        $sql = "UPDATE shoppingcarts SET total_price = total_price + '$total_price' WHERE cart_id = '$cart_id'";
        $db = new Db();
        $result = $db->query($sql);
        $data = false;
        if ($result > 0) {
            $data = true;
        }
    
        return $data;
    }

    public function updateCartPriceToZero($cart_id) {
        $sql = "UPDATE shoppingcarts SET total_price = '0' WHERE cart_id = '$cart_id'";
        $db = new Db();
        $result = $db->query($sql);
        $data = false;
        if ($result > 0) {
            $data = true;
        }
    
        return $data;
    }

    public function updateCartPriceMinus($cart_id, $total_price) {
        $sql = "UPDATE shoppingcarts SET total_price = total_price - '$total_price' WHERE cart_id = '$cart_id'";
        $db = new Db();
        $result = $db->query($sql);
        $data = false;
        if ($result > 0) {
            $data = true;
        }
    
        return $data;
    }

    public function updateCartPriceTotal($cart_id, $total_price, $cartItemId) {
        $db = new Db();
        $sql1 = "SELECT ci.quantity, i.price FROM `cartitems` as ci, `items` as i 
        WHERE ci.item_id = i.item_id AND ci.cart_item_id != '$cartItemId' AND ci.cart_id = '$cart_id'";
        $result1 = $db->query($sql1);
        $data = false;
        $totalPrice = 0;
        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                $quantity = $row['quantity'];
                $price = $row['price'];
        
                // Calculate the total price for the current row
                $rowTotal = $quantity * $price;
        
                // Add the current row total to the overall total
                $totalPrice += $rowTotal;
            }
            $tprice = $totalPrice + $total_price;

        } else {
            $tprice = $total_price;
        }
        $sql = "UPDATE shoppingcarts SET total_price = '$tprice' WHERE cart_id = '$cart_id'";
        $result = $db->query($sql);
        if ($result > 0) {
            $data = true;
        }

    
        return $data;
    }

    public function setCartInactive($cart_id) {
        $sql = "UPDATE shoppingcarts SET status = 'Inactive' WHERE cart_id = '$cart_id'";
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