<?php
    require_once dirname(__FILE__) . '.\entity\db.php';
    require_once dirname(__FILE__) . '.\entity\users.php';
    class sellerEntity
    {
        private $db;
        private $users;
        public function __construct()
        {
            $this->db = new Db;
            $this->users = new Users;
        }
        public function __destruct()
        {

        }
        public function showItems()
        {
            // get seller id
            $userID = $this->users->getUserId();
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = $userID";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIDString = $sellerfetch["seller_id"];

            $userQuery = "SELECT * FROM items WHERE seller_id = $sellerIDString";
            $result = $this->db->query($userQuery);
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }


		
		public function getItemData($inputdata)
        {
            $item_id = $inputdata;
            $userQuery = "SELECT items.*, categories.category_name
			FROM items 
			JOIN categories ON items.category_id = categories.category_id
			WHERE `item_id` = $item_id";
            $result = $this->db->query($userQuery);
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }
		
		public function addItem($inputdata)
        {   
			$item_name = $inputdata["item_name"];
			$price = $inputdata["price"];
			$category_id = $inputdata["category_id"];
			$description = $inputdata["description"];
		    $item_image_path = basename($_FILES["item_image_path"]["name"]);
            $quantity = $inputdata["quantity"];
            // get seller id
            $userID = $this->users->getUserId();
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = $userID";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIDString = $sellerfetch["seller_id"];

            $userQuery = "INSERT INTO `items` (item_name, price, category_id, description, item_image_path, quantity, seller_id)
            VALUES ('$item_name', '$price', '$category_id', '$description', '$item_image_path', '$quantity','$sellerIDString' )";

            $result = $this->db->query($userQuery);

            if($result)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
		
        public function deleteItem($inputdata)
        {
            $item_id = $inputdata;

            $userQuery = "DELETE FROM items WHERE `item_id` = $item_id";
            $result = $this->db->query($userQuery);
            if($result){
                return true;
            }else{
                return false;
            }
        }		

		public function dataForEdit($inputdata)
        {
            $item_id = $inputdata;

            $userQuery = "SELECT * FROM items WHERE `item_id` = $item_id";
            $result = $this->db->query($userQuery);
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }
		
		public function getCategoriesForDropdown() {
			$categoriesQuery = "SELECT category_id, category_name FROM categories";
            $result = $this->db->query($categoriesQuery);
			$categories = [];
			if ($result->num_rows > 0) {
				while ($category = $result->fetch_assoc()) {
					$categories[] = $category;
				}
			}
			return $categories;
		}
			
		public function updateItem($inputdata)
		{
			$item_id = $inputdata["item_id"];
			$item_name = $inputdata["item_name"];
			$price = $inputdata["price"];
			$category_id = $inputdata["category_id"];
            $quantity = $inputdata["quantity"];
			$description = $inputdata["description"];

			
			$is_image_uploaded = !empty($_FILES["item_image_path"]["name"]);
			
			if ($is_image_uploaded) {
				$item_image_path = basename($_FILES["item_image_path"]["name"]);
			} else {
				$item_image_path = $inputdata["item_image_path"];
			}
			
			$userQuery = "UPDATE `items` SET `item_name` = '$item_name', 
			`price` = '$price', 
			`category_id` = '$category_id', 
            `quantity` = '$quantity',
			`description` = '$description'

            ";
			
			if ($is_image_uploaded) {
				$userQuery .= ", `item_image_path` = '$item_image_path'";
			}
			
			$userQuery .= " WHERE `item_id` = '$item_id'";
			
			$result = $this->db->query($userQuery);

			if ($result) {
				return true;
			} else {
				return false;
			}

		}
		
		public function searchItem($inputdata)
		{
			$search = $inputdata;
			// get seller id
            /*$userID = $this->users->getUserId();
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = $userID";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIDString = $sellerfetch["seller_id"];
            */
			$userQuery = "SELECT * FROM items WHERE `item_name` LIKE '%$search%'";
			
			$result = $this->db->query($userQuery);
			
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
		}
        public function getSellerData($item_id){
            // get seller id
            $sellerQuery = "SELECT seller_id FROM items where item_id = $item_id";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIDString = $sellerfetch["seller_id"];

            $userQuery = "SELECT sellers.*,sellerRatings.rating_value FROM sellers join sellerRatings on sellerRatings.seller_id = sellers.seller_id WHERE sellers.seller_id= $sellerIDString";
            $result = $this->db->query($userQuery);
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
    }
		public function getItemReviews($item_id) {
			$userQuery = "SELECT * FROM itemratings join customers on itemratings.customer_id = customers.customer_id WHERE item_id = $item_id";
			$result = $this->db->query($userQuery);
			
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
		}
        public function getItemAverage($item_id){
            $userQuery = "SELECT AVG(rating_value) as average_value, COUNT(*) as Review_count from itemratings WHERE item_id = $item_id ";
            $result = $this->db->query($userQuery);
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }

        public function requestCategory($category){
            //get seller id
            $userId = $this->users->getUserId();
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = $userId";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIdString = $sellerfetch["seller_id"];

            $statement = $this->db->prepare("INSERT INTO CategoryRequests (seller_id,category_name,description,status) VALUES($sellerIdString, ?, '----' , 'pending' )");
            $statement->bind_param("s", $category);
            $statement->execute();

            if($statement->num_rows > 0){
                return $statement;
            }else{
                return false;
            }
        }

        public function showRequests(){
            //get seller id
            $userId = $this->users->getUserId();
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = $userId";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIdString = $sellerfetch["seller_id"];

            $userQuery = "SELECT * FROM CategoryRequests WHERE seller_id= $sellerIdString" ;
            $result = $this->db->query($userQuery);
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }

        public function showSettings(){
            //get seller id
            $userId = $this->users->getUserId();
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = $userId";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIdString = $sellerfetch["seller_id"];

            $userQuery = "SELECT * FROM sellers JOIN users ON sellers.user_id = users.user_id  WHERE sellers.user_id= $sellerIdString" ;
            $result = $this->db->query($userQuery);
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }
        public function deactivateUser(){
            $userId = $this->users->getUserId();
            $userQuery = "UPDATE users SET status='pending deactivation' where user_id = $userId";
            $result = $this->db->query($userQuery);
            if($result){
                return true;
            } else {
                return false;
            }
        }

        public function editSettings($inputData){
           // $profile_image = $inputData["profile_image"]; //seller
            $username=  $inputData['username'];
            $password = $inputData['password1'];
            $confirmPass = $inputData['password2']; 
            $sellerName = $inputData['seller_name']; //seller
            $description = $inputData['description']; //seller
            $address = $inputData['pick_up_address']; //seller
            //$paymentQR = $inputData['payment_QR']; //seller
            $email = $inputData['email'];
            $userId = $this->users->getUserId();
            if($password == $confirmPass){
            $statement = $this->db->prepare("UPDATE users SET username = ? , password = ?, email =? where user_id = $userId");
            $statement->bind_param("sss", $username, $password,$email);
            $statement->execute();
            $statement2 = $this->db->prepare("UPDATE sellers set seller_name = ? , description = ?, pick_up_address = ? where user_id = $userId");
            $statement2->bind_param("sss", $sellerName, $description, $address);
            $statement2->execute();
            if($statement && $statement2){
                return true;
            }else{
                return false;
            }
        }}
    }

?>