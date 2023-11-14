<?php

// Include file
require_once dirname(__FILE__) . '/../entity/users.php';
require_once dirname(__FILE__) . '/../entity/customers.php';
require_once dirname(__FILE__) . '/../entity/itemratings.php';
require_once dirname(__FILE__) . '/../entity/items.php';
require_once dirname(__FILE__) . '/../entity/sellerEntity.php';


class sellerController {
    private $seller;

    public function __construct() {
        $this->seller = new sellerEntity();
    }
	public function getCategoryName($category_id)
	{
		return $this->seller->getCategoryName($category_id);
	}
	
	public function getItemData($inputdata)
	{
		return $this->seller->getItemData($inputdata);
	}
	
	public function getItemReviews($inputdata)
	{
		return $this->seller->getItemReviews($inputdata);
	}
	
	public function getItemAverage($inputdata)
	{
		return $this->seller->getItemAverage($inputdata);
	}
	
	public function getCategoriesForDropdown()
	{
		return $this->seller->getCategoriesForDropdown();
	}
	
	public function dataForEdit($inputdata)
	{
		return $this->seller->dataForEdit($inputdata);
	}
	
	public function showItems()
	{
		return $this->seller->showItems();
	}
	
	public function showSettings()
	{
		return $this->seller->showSettings();
	}
	
	public function showRequests()
	{
		return $this->seller->showRequests();
	}
	
	public function requestCategory($categories)
	{
		return $this->seller->requestCategory($categories);
	}
	
	public function deactivateUser()
	{
		return $this->seller->deactivateUser();
	}
	
	public function editSettings($inputData)
	{
		return $this->seller->editSettings($inputData);
	}
	
	public function updateItem($inputdata)
	{
		return $this->seller->updateItem($inputdata);
	}
	
	public function addItem($inputdata)
	{
		return $this->seller->addItem($inputdata);
	}
	
	public function getSellerData($inputdata)
	{
		return $this->seller->getSellerData($inputdata);
	}
	public function searchItem($inputdata){
		return $this->seller->searchItem($inputdata);
	}

	public function deleteItem($inputdata){
		return $this->seller->deleteItem($inputdata);
	}

	public function searchItemByName($tags) {
		return $this->seller->searchItemByName($tags);
	}
	public function getInventory($tags) {
		return $this->seller->getInventory($tags);
	}
}
?>