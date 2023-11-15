<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class inventory {
    private $inventory_id;
    private $item_id;
    private $size;
    private $quantity;


    public function __construct($inventory_id = null, $item_id = null, $size = null, $quantity = null) {
        $this->inventory_id = $inventory_id;
        $this->item_id = $item_id;
        $this->size = $size;
        $this->quantity = $quantity;
    }

    public function getInventoryId() {
        return $this->inventory_id;
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

    public function viewInventory($item_id) {
        $sql = "SELECT size
        FROM `inventory`
        WHERE `item_id` = $item_id";
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

    public function viewStock($cart_item_id) {
        $sql = "SELECT quantity FROM inventory WHERE (item_id, size) IN (SELECT item_id, size FROM cartitems WHERE cart_item_id = $cart_item_id)";

        $db = new Db();
        $result = $db->query($sql);
        $data = '';
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = $row['quantity'];

        }
    
        return $data;

    }

    public function viewItemStock($item_id, $size) {
        $sql = "SELECT quantity
        FROM inventory
        WHERE `item_id` = $item_id 
        AND `size` = '$size'";
        $db = new Db();
        $result = $db->query($sql);
        $data = '';
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = $row['quantity'];

        }
    
        return $data;

    }

    public function decreaseQuantity($cart_item_id) {
        $sql = "UPDATE Inventory
        SET quantity = quantity - (
            SELECT quantity
            FROM cartitems
            WHERE cartitems.item_id = inventory.item_id
              AND cartitems.size = inventory.size
              AND cartitems.cart_id = $cart_item_id
        )
        WHERE EXISTS (
            SELECT 1
            FROM cartitems
            WHERE cartitems.item_id = inventory.item_id
              AND cartitems.size = inventory.size
              AND cartitems.cart_id = $cart_item_id
        )";
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