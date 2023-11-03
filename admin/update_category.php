<?php
include __DIR__ . "/../controller/AdminController.php";

$categoryId = $_GET["category_id"];
$adminController = new AdminController();

$categoryData = $adminController->getCategoryById($categoryId);

if (!$categoryData) {
    echo "Category not found.";
    exit();
}

$categoryNameErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = htmlspecialchars($_POST["category_name"]);
    $status = isset($_POST["active"]) ? "Active" : "Inactive";

    if (empty($categoryName)) {
        $categoryNameErr = "Category name is required";
    }

    if (empty($categoryNameErr)) {
        if ($adminController->updateCategory($categoryId, $categoryName, $status)) {
            header("Location: view_category.php");
            exit();
        } else {
            echo "Error: Category not updated";
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
                        <form method="POST" action="update_category.php?category_id=<?php echo $categoryId; ?>">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $categoryData["category_name"]; ?>">
                                <span class="text-danger"><?php echo $categoryNameErr; ?></span>
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
