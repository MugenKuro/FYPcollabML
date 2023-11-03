<?php
require_once 'sellerEntity.php';

class deleteItem
	{
		public function deleteItem($inputdata)
		{	
			$sellerEntity = new sellerEntity;
            $result = $sellerEntity -> deleteItem($inputdata);

			if($result){
				return true;
			}
			else{
				return false;
			}
		}	
	}

?>