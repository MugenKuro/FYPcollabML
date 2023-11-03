<?php
include __DIR__ . "/../entity/admin.php";

class AdminController {
    private $admin;

    public function __construct() {
        $this->admin = new Admin();
    }

    public function addCategory($categoryName, $status) {
        return $this->admin->addCategory($categoryName, $status);
    }

    public function confirmDeletion() {
        // Implement logic here for confirming deletion
        return true; // assume confirmation is true.
    }

    public function deleteCategory($categoryID) {
        return $this->admin->deleteCategory($categoryID);
    }

    public function handleCategoryRequests() {
        return $this->admin->handleCategoryRequests();
    }

    public function getCategoryById($categoryId) {
        return $this->admin->getCategoryById($categoryId);
    }

    public function updateCategory($categoryId, $categoryName, $status) {
        return $this->admin->updateCategory($categoryId, $categoryName, $status);
    }

    public function viewAllCategories() {
        return $this->admin->viewAllCategories();
    }

    public function getAllCustomers() {
        return $this->admin->getAllCustomers();
    }

    public function viewDeactivationRequests() {
        return $this->admin->viewDeactivationRequests();
    }

    public function deactivateSeller($sellerID) {
        return $this->admin->deactivateSeller($sellerID);
    }

    public function viewRegistrationRequests() {
        return $this->admin->viewRegistrationRequests();
    }

    public function approveSeller($sellerID) {
        return $this->admin->approveSeller($sellerID);
    }

    public function viewAllSellers() {
        return $this->admin->viewAllSellers();
    }
}
?>
