<?php
require_once  "../controller/AdminController.php";

$adminController = new AdminController();

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST["category_name"];

    // Check if the 'active' checkbox is selected
    $status = isset($_POST["active"]) ? "Active" : "Inactive";
    $categoryName = $_POST["category_name"];

    // Check if the category name already exists
    if ($adminController->isCategoryExists($categoryName)) {
        $errorMessage = "Category name already exists!";
    } else {
        if ($adminController->addCategory($categoryName, $status)) {
            echo "Category added successfully!";
            header("Location: view_category.php");
        } else {
            $errorMessage = "Error adding category!";
        }
    }
}
include "admin_header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category</title>
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
                        <!-- Display error message -->
                        <div id="errorMessage" class="alert alert-danger mt-3 d-none">
                            <span id="error-message-text"></span>
                            <button type="button" class="btn-close float-end" aria-label="Close" data-bs-dismiss="alert"></button>
                        </div>
                        <form method="POST" action="add_category.php" onsubmit="return validateForm();">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
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

    <script>
        <?php if (!empty($errorMessage)) : ?>
            var errorMessageDiv = document.getElementById("errorMessage");
            var errorMessageText = document.getElementById("error-message-text");
            errorMessageText.innerText = '<?php echo $errorMessage; ?>';
            errorMessageDiv.classList.remove("d-none"); 
        <?php endif; ?>
    </script>
</body>
</html>
