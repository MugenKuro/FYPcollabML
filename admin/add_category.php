<?php
require_once  "../controller/AdminController.php";

$adminController = new AdminController();

$Message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST["category_name"];

    // Check if the 'active' checkbox is selected
    $status = isset($_POST["active"]) ? "Active" : "Inactive";
    $categoryName = $_POST["category_name"];
    
    if (empty($categoryName)) {
        $Message = "Category name cannot be empty!";
    } else {
        if ($adminController->addCategory($categoryName, $status)) {;
            $Message = "Category added successfully!"; 
            header("Location: view_category.php");
        } else {
            $Message = "Error adding category!";
        }
    }
    
}
include "admin_header.php";
?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>
</head>
    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title"><b>Add New Category</b></h2>
                        </div>
                        <div class="card-body">
                            <!-- Display message -->
                            <?php if (!empty($Message)) : ?>
                                <div class="alert alert-<?php echo $Message == 'Category added successfully!' ? 'success' : 'danger'; ?> alert-dismissible mt-3" role="alert">
                                    <?php echo $Message; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="add_category.php">
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name:</label>
                                    <input type="text" class="form-control" id="category_name" name="category_name">
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="active" name="active">
                                    <label class="form-check-label" for="active"><strong>Active</strong></label>
                                </div>
                                <button type="submit" class="btn btn-success">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
