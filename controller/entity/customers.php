<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();
//User Class (User Account)
// Include file
require_once("db.php");

class customers {
    private $customer_id;
    private $user_id;
    private $nickname;
    private $gender;
    private $date_of_birth;
    private $first_name;
    private $last_name;
    private $image_path;
    private $address;
    private $mobile;

    public function __construct($customer_id = null, $user_id = null, $nickname = null, $gender = null, $date_of_birth = null, $first_name = null, 
    $last_name = null, $image_path = null, $address = null, $mobile = null) {
        $this->customer_id = $customer_id;
        $this->user_id = $user_id;
        $this->nickname = $nickname;
        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->image_path = $image_path;
        $this->address = $address;
        $this->mobile = $mobile;
    }
    // Getters
    public function getCustomerId() {
        return $this->customer_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getNickname() {
        return $this->nickname;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getDateOfBirth() {
        return $this->date_of_birth;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getImagePath() {
        return $this->image_path;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function getCustomerDetails($user_id) {
        $sql = "SELECT nickname, gender, date_of_birth, first_name, last_name, image_path, address, mobile FROM `customers` where user_id = ?";
        $db = new Db();
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array(); // Initialize an empty array to store category data
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Add each category row to the $data array
            }
        } else {
            $_SESSION['getCustomerDetails']['error'] = 'Unable to fetch any details.';
        }
    
        return json_encode($data);
    }
    
    public function updateCustomer($user_id, $nickname, $gender, $date_of_birth, $first_name, $last_name, $image_path=NULL, $address, $mobile) {
        $db = new Db();

        $address = $db->escape($address);

        if (is_null($image_path)) {
            $sql = "UPDATE `customers`
            SET `nickname` = '$nickname',
            `gender` = '$gender',
            `date_of_birth` = '$date_of_birth',
            `first_name` = '$first_name',
            `last_name` = '$last_name',
            `address` = '$address',
            `mobile` = '$mobile'
            WHERE `user_id` = '$user_id'";
        } else {
            $sql = "UPDATE `customers`
            SET `nickname` = '$nickname',
            `gender` = '$gender',
            `date_of_birth` = '$date_of_birth',
            `first_name` = '$first_name',
            `last_name` = '$last_name',
            `image_path` = '$image_path',
            `address` = '$address',
            `mobile` = '$mobile'
            WHERE `user_id` = '$user_id'";
        }
        $save = $db->query($sql);

        if ($save > 0) {
            $resp['status'] = 'success';
        } else if ($save == 0) {
            $resp['status'] = 'nothing';
        } else {
            $resp['status'] = 'error';
        }

        return json_encode($resp);
    }


}



?>