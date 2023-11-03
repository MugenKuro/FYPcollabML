<?php
include "admin_header.php";
include __DIR__ . "/../controller/AdminController.php";

// Create an instance of the AdminController class
$adminController = new AdminController();

// Check if the "Deactivate" button is clicked
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["deactivate"])) {
    $sellerID = $_POST["seller_id"];
    $adminController->deactivateSeller($sellerID);
}

$result = $adminController->viewDeactivationRequests();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .table td {
            white-space: nowrap; 
            overflow: hidden;
            text-overflow: ellipsis; 
            max-width: 200px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>View Deactivation Requests</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Seller ID</th>
                        <th>User ID</th>
                        <th>Seller Type</th>
                        <th>Seller Name</th>
                        <th>Description</th>
                        <th>Bank Name</th>
                        <th>Bank Account No</th>
                        <th>Pickup Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["seller_id"] . "</td>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["seller_type"] . "</td>";
                            echo "<td>" . $row["seller_name"] . "</td>";
                            echo "<td>" . $row["description"] . "</td>";
                            echo "<td>" . $row["bank_name"] . "</td>";
                            echo "<td>" . $row["bank_account_no"] . "</td>";
                            echo "<td>" . $row["pick_up_address"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>";
                            echo "<form method='POST'>";
                            echo "<input type='hidden' name='seller_id' value='" . $row["seller_id"] . "'>";
                            echo "<button type='submit' class='btn btn-danger' name='deactivate'>Deactivate</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No deactivation requests found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
