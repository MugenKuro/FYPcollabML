<?php
require_once "../controller/AdminController.php";

$categoryId = $_GET["category_id"];
$adminController = new AdminController();

$categoryData = $adminController->getCategoryById($categoryId);

if (!$categoryData) {
    echo "Category not found.";
    exit();
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = htmlspecialchars($_POST["category_name"]);
    $status = isset($_POST["active"]) ? "Active" : "Inactive";

    // Check if the category name already exists for updating
    if (!empty($categoryName) && $adminController->isCategoryExistsForUpdate($categoryName, $categoryId)) {
        $errorMessage = "Category name already exists!";
    } else {
        if ($adminController->updateCategory($categoryId, $categoryName, $status)) {
            echo "Category updated successfully!";
            header("Location: view_category.php");
            exit();
        } else {
            $errorMessage = "Error updating category!";
        }
    }
}
include "admin_header.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Category</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><b>Update Category</b></h2>
                    </div>
                    <div class="card-body">
                        <!-- Display error message -->
                        <div id="errorMessage" class="alert alert-danger mt-3 d-none">
                            <span id="error-message-text"></span>
                            <button type="button" class="btn-close float-end" aria-label="Close" data-bs-dismiss="alert"></button>
                        </div>
                        <form method="POST" action="update_category.php?category_id=<?php echo $categoryId; ?>" onsubmit="return validateForm();">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $categoryData["category_name"]; ?>" required>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="active" name="active" <?php if ($categoryData["status"] === "Active") echo "checked"; ?>>
                                <label class="form-check-label" for="active">Active</label>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Update Category</button>
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
