<?php
require_once '../entity/db.php'; // Include the Db class
require_once '../sellerAuth.php';

// Create a new Db instance
$db = new Db();

// Initialize the success message and search query as empty strings
$successMessage = '';
$searchQuery = '';
$errorMessage = ''; // Add an error message variable

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the logged-in seller's user ID 
$sellerUserId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted for quantity update
    if (isset($_POST["inventory_id"]) && isset($_POST["new_quantity"])) {
        $inventoryID = $_POST["inventory_id"];
        $newQuantity = $_POST["new_quantity"];

        // Query to update the quantity for the selected inventory item
        $updateSql = "UPDATE Inventory iv
                      INNER JOIN Items i ON iv.item_id = i.item_id
                      SET iv.quantity = ? 
                      WHERE iv.inventory_id = ? AND iv.size = ? AND i.seller_id = (SELECT seller_id FROM Users WHERE user_id = ? AND account_type = 'Seller')";
        $updateParams = [$newQuantity, $inventoryID, $_POST["size"], $sellerUserId];

        try {
            $result = $db->query($updateSql, $updateParams);

            if ($result) {
                // Set the success message
                $successMessage = 'Quantity updated successfully.';
            } else {
                $errorMessage = 'Error updating quantity: ' . $db->getConnectError();
            }
        } catch (Exception $e) {
            $errorMessage = 'Error: ' . $e->getMessage();
        }
    }

    // Check if the form was submitted for adding new inventory
    if (isset($_POST["item_name"]) && isset($_POST["size"]) && isset($_POST["quantity"])) {
        $itemName = $_POST["item_name"];
        $size = $_POST["size"];
        $quantity = $_POST["quantity"];

        // Query to check if the size already exists for the selected item
        $checkSizeSql = "SELECT COUNT(*) AS size_count
            FROM Inventory iv
            INNER JOIN Items i ON iv.item_id = i.item_id
            WHERE i.item_id = ? AND iv.size = ?";
            // AND i.seller_id = (SELECT seller_id FROM Users WHERE user_id = ?)";
        $checkSizeParams = [$_POST["item_id"], $size];

        try {
            $sizeResult = $db->query($checkSizeSql, $checkSizeParams);
            $sizeRow = $sizeResult->fetch_assoc();

            if ($sizeRow['size_count'] > 0) {
                // Size already exists, set an error message
                $errorMessage = 'Size already exists for this item.';
            } else {
                // Size doesn't exist, proceed to add new inventory record
                // Query to add a new inventory record
                $insertSql = "INSERT INTO Inventory (item_id, size, quantity)
                              VALUES (?, ?, ?)";
                $insertParams = [$_POST["item_id"], $size, $quantity];

                try {
                    $result = $db->query($insertSql, $insertParams);

                    if ($result) {
                        // Set the success message
                        $successMessage = 'Inventory added successfully.';
                    } else {
                        $errorMessage = 'Error adding inventory: ' . $db->getConnectError();
                    }
                } catch (Exception $e) {
                    $errorMessage = 'Error: ' . $e->getMessage();
                }
            }
        } catch (Exception $e) {
            $errorMessage = 'Error: ' . $e->getMessage();
        }
    }

    // Check if the form was submitted for searching item names
    if (isset($_POST["search_query"])) {
        $searchQuery = $_POST["search_query"];
    }
}

// Query to retrieve inventory items for the seller with optional search
$sql = "SELECT i.item_id, iv.inventory_id, i.item_name, iv.size, iv.quantity
        FROM Items i
        INNER JOIN Inventory iv ON i.item_id = iv.item_id
        WHERE i.seller_id = (SELECT seller_id FROM Sellers WHERE user_id = ?) AND i.status = 'Active'";

// Add search condition if a search query is provided
if (!empty($searchQuery)) {
    $sql .= " AND i.item_name LIKE ?";
    $searchParam = '%' . $searchQuery . '%';
    $params = [$sellerUserId, $searchParam];
} else {
    $params = [$sellerUserId];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/sellerStyle.css" rel="stylesheet">


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>iCloth</title>

    <style>
    .close-right {
        position: absolute;
        right: 10px;
    }
</style>

</head>
<body>
<?php include('sellerNavBar.php'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Inventory Management</h1>
        <button class="btn btn-success" data-toggle="modal" data-target="#addInventoryModal">Add Inventory</button>
    </div>
    <form method="post" action="" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search_query" placeholder="Search Item Names"
                   value="<?php echo $searchQuery; ?>">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <?php
	try {
        $result = $db->query($sql, $params);
        if ($result->num_rows > 0) {
            ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Update Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['size']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateModal<?php echo $row['inventory_id']; ?>">Update</button>
                        </td>
                    </tr>

                    <!-- Modal for updating quantity -->
                    <div class="modal fade" id="updateModal<?php echo $row['inventory_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Quantity</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="">
                                        <input type="hidden" name="inventory_id" value="<?php echo $row['inventory_id']; ?>">
                                        <input type="hidden" name="size" value="<?php echo $row['size']; ?>">
                                        <div class="form-group">
                                            <label for="new_quantity">New Quantity:</label>
                                            <input type="text" class="form-control" id="new_quantity<?php echo $row['inventory_id']; ?>" name="new_quantity" placeholder="New Quantity" required>
                                        </div>
                                        
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					 </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </tbody>
            </table>
        <?php
        } else {
            echo 'You have no inventory records.';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    ?>
</div>

<!-- Modal for adding inventory -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Error message display -->
                <div id="errorMessage" class="alert alert-danger mt-3" style="display: none;">
                    <span id="error-message-text"></span>
                    <button type="button" class="close close-right" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="" onsubmit="return validateForm();">
                    <div class="form-group">
                        <label for="item_name">Item Name:</label>
                        <select class="form-control" id="item_name" name="item_name" required>
                            <?php
                            // Query to retrieve item names for the seller
                            $itemNamesSql = "SELECT item_id, item_name FROM Items WHERE seller_id = (SELECT seller_id FROM Sellers WHERE user_id = ?) AND status = 'Active'";
                            $itemNamesParams = [$sellerUserId];

                            try {
                                $itemNamesResult = $db->query($itemNamesSql, $itemNamesParams);
                                while ($itemNameRow = $itemNamesResult->fetch_assoc()) {
                                    echo "<option value='" . $itemNameRow['item_name'] . "' data-item-id='" . $itemNameRow['item_id'] . "'>" . $itemNameRow['item_name'] . "</option>";
                                }
                            } catch (Exception $e) {
                                echo 'Error: ' . $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" id="item_id" name="item_id" value=""> 
                    <div class="form-group">
                        <label for="size">Size:</label>
                        <input type="text" class="form-control" id="size" name="size" placeholder="Size" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity" required>
                        <span id="quantity-error" class="text-danger"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                    
                </form>
            </div>
            <div class="modal-footer">      
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#item_name").change(function() {
            var selectedItem = $("#item_name option:selected");
            var itemId = selectedItem.data("item-id");
            $("#item_id").val(itemId);
        });
    });
</script>
<script>
    function validateForm() {
        var size = document.getElementById("size").value;
        var quantity = document.getElementById("quantity").value;

        // Check if size is empty
        if (size.trim() === "") {
            alert("Size cannot be empty.");
            return false;
        }

        // Check if quantity is empty
        if (quantity.trim() === "") {
            alert("Quantity cannot be empty.");
            return false;
        }

        // Check if quantity is a valid number
        if (isNaN(quantity)) {
            document.getElementById("quantity-error").innerText = "Quantity must be a valid number.";
            return false;
        }
        

        // Clear any previous error message
        document.getElementById("quantity-error").innerText = "";

        return true;
    }
</script>
<script>
    // Display error message using JavaScript
    var errorMessage = "<?php echo $errorMessage; ?>";
    if (errorMessage !== "") {
        var errorMessageDiv = document.getElementById("errorMessage");
        var errorMessageText = document.getElementById("error-message-text");
        errorMessageText.innerText = errorMessage;
        errorMessageDiv.style.display = "block";

        $('#addInventoryModal').modal('show');
    }
</script>
</body>
</html>
