<?php
require_once 'sellerEntity.php';

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

?>