<?php
include __DIR__ . "/../entity/db.php"; // Include the db.php file using the correct relative path
include "admin_header.php";
// Create a new Db instance
$db = new Db();

// Initialize variables to store form data
$categoryName = $status = "";
$categoryNameErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $categoryName = htmlspecialchars($_POST["category_name"]);

    // Check if the 'active' checkbox is selected
    if (isset($_POST["active"])) {
        $status = "Active";
    } else {
        $status = "Inactive";
    }

    // Validate category name (required field)
    if (empty($categoryName)) {
        $categoryNameErr = "Category name is required";
    }

    // If there are no errors, insert the category into the database
    if (empty($categoryNameErr)) {
        try {
            // Prepare the SQL statement using the Db class
            $sql = "INSERT INTO categories (category_name, status) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ss", $categoryName, $status);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect back to the categories page
                header("Location: view_category.php");
                exit();
            } else {
                echo "Error: Category not added";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
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
                            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $categoryName; ?>">
                            <span class="text-danger"><?php echo $categoryNameErr; ?></span>
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
