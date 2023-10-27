<?php
require_once 'sellerEntity.php';

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