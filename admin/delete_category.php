<?php
include "Admin.php";

$admin = new Admin();

if (isset($_GET["category_id"]) && is_numeric($_GET["category_id"])) {
    $categoryID = $_GET["category_id"];

    // Check for confirmation (you can customize this logic)
    $confirmation = $admin->confirmDeletion();

    if ($confirmation) {
        if ($admin->deleteCategory($categoryID)) {
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
