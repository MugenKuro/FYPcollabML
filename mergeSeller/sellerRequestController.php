<?php
require_once 'sellerEntity.php';

class sellerRequest
	{   
        private $sellerEntity;
        public function __construct()
        {
            $this->sellerEntity = new sellerEntity;
        }
		public function deactivateUser()
		{	
            $result = $this->sellerEntity->deactivateUser();	

			if($result)
            {
				return $result;
			}
			else
            {
				return false;
			}
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
 
?>