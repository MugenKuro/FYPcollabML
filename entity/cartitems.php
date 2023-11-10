<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class cartitems {
    private $cart_item_id;
    private $cart_id;
    private $item_id;
    private $size;
    private $quantity;


    public function __construct($cart_item_id = null, $cart_id = null, $item_id = null, $size = null, $quantity = null) {
        $this->cart_item_id = $cart_item_id;
        $this->cart_id = $cart_id;
        $this->item_id = $item_id;
        $this->size = $size;
        $this->quantity = $quantity;
    }

    public function getCartItemId() {
        return $this->cart_item_id;
    }

    public function getCartId() {
        return $this->cart_id;
    }

    public function getItemId() {
        return $this->item_id;
    }

    public function getSize() {
        return $this->size;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function viewCartItem($cart_id) {
        $sql = "SELECT ct.cart_item_id, i.item_image_path, i.item_name, i.price, ct.size, ct.quantity, sc.total_price
        FROM `items` as i, `cartitems` as ct, `shoppingcarts` as sc
        WHERE ct.item_id = i.item_id AND ct.cart_id = sc.cart_id
        AND ct.cart_id = $cart_id AND sc.status = 'Active'";
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

    public function addCartItem($cart_id, $item_id, $size, $quantity) {
        $sql = "INSERT INTO cartitems (cart_id, item_id, size, quantity) VALUES ('$cart_id', '$item_id', '$size', '$quantity')";
        $db = new Db();
        $result = $db->query($sql);
        $data = false;
        if ($result > 0) {
            $data = true;
        }
    
        return $data;
    }

    public function clearCart($cart_id) {
        $sql = "DELETE FROM cartitems
        WHERE cart_id IN (SELECT cart_id FROM shoppingcarts WHERE status = 'Active')
        AND cart_id = $cart_id;
        ";
        $db = new Db();
        $result = $db->query($sql);
        $data = false;
        if ($result > 0) {
            $data = true;
        }
    
        return $data;
    }

    public function removeAnItem($cart_item_id) {
        $sql = "DELETE FROM cartitems
        WHERE cart_item_id = $cart_item_id;
        ";
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