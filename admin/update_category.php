<?php
include __DIR__ . "/../entity/db.php"; // Include the database class
include "admin_header.php";

// Initialize a new Db instance
$db = new Db();

// Initialize variables to store form data
$categoryName = $status = "";
$categoryNameErr = "";

// Check if the category ID is provided in the URL
if (isset($_GET["category_id"]) && is_numeric($_GET["category_id"])) {
    $categoryId = $_GET["category_id"];

    // Check if the category exists in the database
    $sql = "SELECT * FROM categories WHERE category_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $categoryName = $row["category_name"];
        $status = $row["status"];
    } else {
        // Handle the case when the category is not found
        echo "Category not found.";
        exit();
    }
} else {
    // Handle the case when the category ID is not provided in the URL
    echo "Category ID is missing or invalid.";
    exit();
}

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

    // If there are no errors, update the category in the database
    if (empty($categoryNameErr)) {
        try {
            // Prepare the SQL statement
            $sql = "UPDATE categories SET category_name = ?, status = ? WHERE category_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssi", $categoryName, $status, $categoryId);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect back to the categories page after updating
                header("Location: view_category.php");
                exit();
            } else {
                echo "Error: Category not updated";
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
                            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $categoryName; ?>">
                            <span class="text-danger"><?php echo $categoryNameErr; ?></span>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="active" name="active" <?php if ($status === "Active") echo "checked"; ?>> Active
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
