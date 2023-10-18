<?php
include __DIR__ . "/../entity/db.php"; // Include the db.php file using the correct relative path

// Create a new Db instance
$db = new Db();

// Check if the category ID is provided in the URL
if (isset($_GET["category_id"]) && is_numeric($_GET["category_id"])) {
    $categoryID = $_GET["category_id"];

    // Confirm the deletion action (you can display a confirmation message or use JavaScript for a modal confirmation)
    $confirmation = confirmDeletion(); // Define this function as needed

    if ($confirmation) {
        // Delete the category from the database
        try {
            // Prepare the SQL statement to delete the category using the Db class
            $sql = "DELETE FROM categories WHERE category_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $categoryID);

            // Execute the statement
            $stmt->execute();

            // Redirect back to the categories page
            header("Location: view_category.php");
            exit();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Handle the case where the deletion is not confirmed (optional)
        echo "Category deletion canceled.";
        exit();
    }
} else {
    // Handle the case where the category ID is not provided or is not numeric
    echo "Category ID not provided or invalid.";
    exit();
}

// Function to confirm deletion (you can customize this as needed)
function confirmDeletion() {
    // Implement your logic here for confirming deletion
    // For example, you can use JavaScript for a confirmation dialog
    // and return true if the user confirms, or false if they cancel.
    return true; // For simplicity, we assume confirmation is always true here.
}
?>
