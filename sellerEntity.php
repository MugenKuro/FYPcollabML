<?php
    require_once dirname(__FILE__) . '\entity\db.php';
    require_once dirname(__FILE__) . '\entity\users.php';
    class sellerEntity
    {
        private $db;
        private $users;
        public function __construct()
        {
            $this->db = new Db;
            $this->users = new Users;
        }
        public function showItems()
        {
            // get seller id
            $userID = $_SESSION['user_id'];
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = '$userID'";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIDString = $sellerfetch["seller_id"];

            $userQuery = "SELECT * FROM items WHERE seller_id = '$sellerIDString'";
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
            $item_image_path = '/images/item_images/' . $item_image_path;
            $quantity = $inputdata["quantity"];
            $size = $inputdata["size"];
            // get seller id
            $userID = $this->users->getUserId();
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = $userID";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIDString = $sellerfetch["seller_id"];

            $statement = $this->db->prepare("INSERT INTO items (item_name, price, category_id, description, item_image_path, seller_id) VALUES (?,?,?,?,?,?) ");
            $statement->bind_param("siissi", $item_name, $price, $category_id, $description, $item_image_path,$sellerIDString );
            $statement->execute();
            $last_id = $this->db->getLastInsertedId();

            $statement2 = $this->db->prepare("INSERT INTO Inventory (item_id,size,quantity) VALUES (?,?,?)");
            $statement2->bind_param("isi",$last_id, $size, $quantity);
            $statement2->execute();

            if($statement ){
                return true;
            }else{
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
			`description` = '$description'

            ";
			
			if ($is_image_uploaded) {
                $item_image_path = '/images/item_images/' . $item_image_path;
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
            $userID = $this->users->getUserId();
            $sellerQuery = "SELECT seller_id FROM sellers where user_id = $userID";
            $sellersql = $this->db->query($sellerQuery);
            $sellerfetch = $sellersql->fetch_assoc();
            $sellerIDString = $sellerfetch["seller_id"];
            
			$userQuery = "SELECT * FROM items WHERE seller_id = $sellerIDString AND `item_name` LIKE '%$search%'";
			
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
        public function getCategoryName($category_id){
            $userQuery = "SELECT category_name from categories where category_id = $category_id";
            $result = $this->db->query($userQuery);
            if($result){
                return $result;
            }
            else{
                return false;
            }
        }
		public function getItemReviews($item_id) {
			$userQuery = "SELECT * FROM itemratings join customers on itemratings.customer_id = customers.customer_id WHERE itemratings.item_id = $item_id";
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

            $userQuery = "SELECT * FROM sellers JOIN users ON sellers.user_id = users.user_id  WHERE sellers.seller_id= $sellerIdString" ;
            $result = $this->db->query($userQuery);
                return $result;
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
            $profile_image = $inputData["profile_image"];
            $username=  $inputData['username'];
            $password = $inputData['password1'];
            $confirmPass = $inputData['password2']; 
            $sellerName = $inputData['seller_name']; //seller
            $description = $inputData['description']; //seller
            $address = $inputData['pick_up_address']; //seller
            $email = $inputData['email'];
            $preferred_category = $inputData['preferred_category'];
            $bank_name = $inputData['bank_name'];
            $bank_account_no = $inputData['bank_account_no'];
            $userId = $this->users->getUserId();
            if($password == $confirmPass){
            $statement = $this->db->prepare("UPDATE users SET  username = ? , password = ?, email =? where user_id = $userId");
            $statement->bind_param("sss",  $username, $password, $email);
            $statement->execute();
            $statement2 = $this->db->prepare("UPDATE sellers set preferred_category=? ,bank_name=?, bank_account_no =?, profile_image =? , seller_name = ? , description = ?, pick_up_address = ? where user_id = $userId");
            $statement2->bind_param("issssss",$preferred_category, $bank_name, $bank_account_no, $profile_image, $sellerName, $description, $address);
            $statement2->execute();
            if($statement && $statement2){
                return true;
            }else{
                return false;
            }
        }}
    }

?>