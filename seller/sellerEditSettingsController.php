<?php
require_once 'sellerEntity.php';

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

?>