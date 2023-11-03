<?php
include __DIR__ . "/../controller/AdminController.php";

$adminController = new AdminController();

if (isset($_GET["category_id"]) && is_numeric($_GET["category_id"])) {
    $categoryID = $_GET["category_id"];

    // Check for confirmation
    $confirmation = $adminController->confirmDeletion();

    if ($confirmation) {
        if ($adminController->deleteCategory($categoryID)) {
            header("Location: view_category.php");
            exit();
        } else {
            echo "Error: Category not deleted.";
        }
    } else {
        echo "Category deletion canceled.";
    }
} else {
    echo "Category ID not provided or invalid.";
}
?>
