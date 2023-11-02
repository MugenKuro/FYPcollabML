<?php
require_once 'sellerEntity.php';

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

?>