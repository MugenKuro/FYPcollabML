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


}



?>