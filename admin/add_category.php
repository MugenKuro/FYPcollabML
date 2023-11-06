<?php
include __DIR__ . "/../controller/AdminController.php";

$adminController = new AdminController();

$successMessage = ''; // Initialize an empty success message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST["category_name"];

    // Check if the 'active' checkbox is selected
    $status = isset($_POST["active"]) ? "Active" : "Inactive";

    if ($adminController->addCategory($categoryName, $status)) {; 
        header("Location: view_category.php");
    } else {
        $successMessage = "Error adding category!";
    }
}
include "admin_header.php";
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="container">
    <!-- Display the success message if available -->
    <?php if (!empty($successMessage)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><b>Add New Category</b></h2>
                </div>
                <div class="card-body">
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
