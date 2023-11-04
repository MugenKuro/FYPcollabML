<?php

// Include file
require_once dirname(__FILE__) . '/../entity/users.php';
require_once dirname(__FILE__) . '/../entity/customers.php';
require_once dirname(__FILE__) . '/../entity/itemratings.php';
require_once dirname(__FILE__) . '/../entity/items.php';
require_once dirname(__FILE__) . '/../entity/sellerEntity.php';

class itemView
	{
		public function getItemData($inputdata)
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> getItemData($inputdata);	

			if($result)
            {
				return $result;
			}
			else
            {
				return false;
			}
		}	
		
		public function getItemReviews($inputdata)
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> getItemReviews($inputdata);	

			if($result)
            {
				return $result;
			}
			else
            {
				return false;
			}
			
		}	
		public function getItemAverage($inputdata)
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> getItemAverage($inputdata);

			if($result)
            {
				return true;
			}
			else
            {
				return false;
			}
		}		
		public function getSellerData($inputdata)
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> getSellerData($inputdata);

			if($result)
            {
				return true;
			}
			else
            {
				return false;
			}
		}	
	}
	class sellerView
	{   
        private $sellerEntity;
        public function __construct()
        {
            $this->sellerEntity = new sellerEntity;
        }
		public function showItems()
		{	
            $result = $this->sellerEntity->showItems();	

			if($result)
            {
				return $result;
			}
			else
            {
				return false;
			}
		}	

		public function showSettings(){
			$result = $this->sellerEntity->showSettings();

			if($result)
			{
				return $result;
			}
			else
			{
				return false;
			}
		}
		public function getCategoryName($category_id){
            $result = $this->sellerEntity->getCategoryName($category_id);
            if($result){
                return $result;
            }
            else{
                return false;
            }
        }
	}
	class viewRequest
	{   
        private $sellerEntity;
        public function __construct()
        {
            $this->sellerEntity = new sellerEntity;
        }
		public function showRequests()
		{	
            $result = $this->sellerEntity->showRequests();	

			if($result)
            {
				return $result;
			}
			else
            {
				return false;
			}
		}	
	}

	class sellerRequest
	{   
        private $sellerEntity;
        public function __construct()
        {
            $this->sellerEntity = new sellerEntity;
        }	
        public function requestCategory($categories){
            $result = $this->sellerEntity->requestCategory($categories);
            if($result)
            {
				return $result;
			}
			else
            {
				return false;
			}
        }
		
	}
 
	class sellerEdit
	{
		public function deactivateUser()
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> deactivateUser();

			if($result)
            {
				return true;
			}
			else
            {
				return false;
			}
		}	
        public function editSettings($inputData){
            $sellerEntity = new sellerEntity;
            $result = $sellerEntity -> editSettings($inputData);
            if($result)
            {
				return true;
			}
			else
            {
				return false;
			}
        }
	}

	class itemEdit
	{
		public function updateItem($inputdata)
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> updateItem($inputdata);	

			if($result)
            {
				return true;
			}
			else
            {
				return false;
			}
		}
		
		public function getCategoriesForDropdown()
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> getCategoriesForDropdown();	

			if($result)
            {
				return true;
			}
			else
            {
				return false;
			}
		}

		public function dataForEdit($inputdata)
		{	
			$sellerEntity = new sellerEntity;
            $result = $sellerEntity -> dataForEdit($inputdata);

			if($result){
				return $result;
			}
			else{
				return false;
			}
		}
	}
	class itemAdd
	{
		public function addItem($inputdata)
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> addItem($inputdata);	

			if($result)
            {
				return true;
			}
			else
            {
				return false;
			}
		}

		public function getCategoriesForDropdown()
		{	
			$sellerEntity = new sellerEntity;
			$result = $sellerEntity -> getCategoriesForDropdown();	

			if($result)
            {
				return true;
			}
			else
            {
				return false;
			}
		}		
	}
?>