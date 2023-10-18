<?php
include "Admin.php";
include "admin_header.php";

$admin = new Admin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST["category_name"];

    // Check if the 'active' checkbox is selected
    $status = isset($_POST["active"]) ? "Active" : "Inactive";

    if ($admin->addCategory($categoryName, $status)) {
        header("Location: view_category.php");
        exit();
    } else {
        echo "Error: Category not added";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Category</title>
</head>
<body>
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><b>Add New Category</b></h2>
            </div>
            <div class="panel-body">
                <form method="POST" action="add_category.php">
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <input type="text" class="form-control" id="category_name" name="category_name">
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="active" name="active"> <strong>Active</strong>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
