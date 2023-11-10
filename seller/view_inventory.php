<?php
require '../entity/db.php'; // Include the Db class

// Create a new Db instance
$db = new Db();

// Initialize the success message and search query as empty strings
$successMessage = '';
$searchQuery = '';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the logged-in seller's user ID 
$sellerUserId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted for quantity update
    if (isset($_POST["item_id"]) && isset($_POST["new_quantity"])) {
        $itemID = $_POST["item_id"];
        $newQuantity = $_POST["new_quantity"];

        // Query to update the quantity for the selected item
        $updateSql = "UPDATE Inventory iv
                      INNER JOIN Items i ON iv.item_id = i.item_id
                      SET iv.quantity = ? 
                      WHERE iv.item_id = ? AND iv.size = ? AND i.seller_id = (SELECT seller_id FROM Users WHERE user_id = ? AND account_type = 'Seller')";
        $updateParams = [$newQuantity, $itemID, $_POST["size"], $sellerUserId];

        try {
            $result = $db->query($updateSql, $updateParams);

            if ($result) {
                // Set the success message
                $successMessage = 'Quantity updated successfully.';
            } else {
                $successMessage = 'Error updating quantity: ' . $db->getConnectError();
            }
        } catch (Exception $e) {
            $successMessage = 'Error: ' . $e->getMessage();
        }
    }

    // Check if the form was submitted for searching item names
    if (isset($_POST["search_query"])) {
        $searchQuery = $_POST["search_query"];
    }
}

// Query to retrieve inventory items for the seller with optional search
$sql = "SELECT i.item_id, i.item_name, iv.size, iv.quantity
        FROM Items i
        INNER JOIN Inventory iv ON i.item_id = iv.item_id
        WHERE i.seller_id = (SELECT seller_id FROM Sellers WHERE user_id = ?)";

// Add search condition if a search query is provided
if (!empty($searchQuery)) {
    $sql .= " AND i.item_name LIKE ?";
    $searchParam = '%' . $searchQuery . '%';
    $params = [$sellerUserId, $searchParam];
} else {
    $params = [$sellerUserId];
}

include dirname(__FILE__) . ('/sellerNavBar.php');
try {
    $result = $db->query($sql, $params);
    if ($result->num_rows > 0) {
        echo '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Inventory Management</title>
                    <link rel="stylesheet" href="../css/bootstrap.min.css">
                    <link rel="stylesheet" href="../css/style.css">
                    <script src="../js/jquery-3.7.1.min.js"></script>
                    <script src="../js/popper.min.js"></script>
                </head>
                <body>               
                    <div class="container mt-4">
                        <h1>Inventory Management</h1>';

        if (!empty($successMessage)) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $successMessage . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
        }

        // Search form
        echo '<form method="post" action="" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search_query" placeholder="Search Item Names" value="' . $searchQuery . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
              </form>';

        echo '<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Update Quantity</th>
                    </tr>
                </thead>
                <tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['item_name'] . '</td>';
            echo '<td>' . $row['size'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#updateModal' . $row['item_id'] . '">Update</button>
                  </td>';
            echo '</tr>';

            // Modal for updating quantity
            echo '<div class="modal fade" id="updateModal' . $row['item_id'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="hidden" name="item_id" value="' . $row['item_id'] . '">
                                    <input type="hidden" name="size" value="' . $row['size'] . '">
                                    <div class="form-group">
                                        <label for="new_quantity">New Quantity:</label>
                                        <input type="text" class="form-control" id="new_quantity' . $row['item_id'] . '" name="new_quantity" placeholder="New Quantity" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
        }

        echo '</tbody>
              </table>
            </div>
          </body>
        </html>';

        echo '<script src="../js/bootstrap.min.js"></script>';
    } else {
        echo 'You have no inventory records.';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>