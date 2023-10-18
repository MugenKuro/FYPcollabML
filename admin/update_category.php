<?php
include "Admin.php";

$categoryId = $_GET["category_id"];
$admin = new Admin();

$categoryData = $admin->getCategoryById($categoryId);

if (!$categoryData) {
    echo "Category not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = htmlspecialchars($_POST["category_name"]);
    $status = isset($_POST["active"]) ? "Active" : "Inactive";

    if (empty($categoryName)) {
        $categoryNameErr = "Category name is required";
    }

    if (empty($categoryNameErr)) {
        if ($admin->updateCategory($categoryId, $categoryName, $status)) {
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
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title"><b>Update Category</b></h2>
                </div>
                <div class="panel-body">
                    <form method="POST" action="update_category.php?category_id=<?php echo $categoryId; ?>">
                        <div class="form-group">
                            <label for="category_name">Category Name:</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $categoryData["category_name"]; ?>">
                            <span class="text-danger"><?php echo $categoryNameErr; ?></span>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="active" name="active" <?php if ($categoryData["status"] === "Active") echo "checked"; ?>> Active
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
?>
