<?php
require_once "../controller/AdminController.php";

$categoryId = $_GET["category_id"];
$adminController = new AdminController();

$categoryData = $adminController->getCategoryById($categoryId);

if (!$categoryData) {
    echo "Category not found.";
    exit();
}

$Message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = htmlspecialchars($_POST["category_name"]);
    $status = isset($_POST["active"]) ? "Active" : "Inactive";

    if (empty($categoryName)) {
        $Message = "Category name is required";
    } else {
        if ($adminController->updateCategory($categoryId, $categoryName, $status)) {
            $Message = "Category updated successfully!";
            header("Location: view_category.php");
            exit();
        } else {
            $Message = "Error updating category!";
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
                        <!-- Display message -->
                        <?php if (!empty($Message)) : ?>
                                <div class="alert alert-<?php echo $Message == 'Category updated successfully!' ? 'success' : 'danger'; ?> alert-dismissible mt-3" role="alert">
                                    <?php echo $Message; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        <form method="POST" action="update_category.php?category_id=<?php echo $categoryId; ?>">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $categoryData["category_name"]; ?>">
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
</body>
</html>
