<?php
require_once 'sellerEntity.php';

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
 
?>