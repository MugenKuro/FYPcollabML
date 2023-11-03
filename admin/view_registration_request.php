<?php
include "admin_header.php";
include __DIR__ . "/../controller/AdminController.php";

// Create an instance of the AdminController class
$adminController = new AdminController();

// Check if the "Approve" button is clicked
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["approve"])) {
    $sellerID = $_POST["seller_id"];
    $adminController->approveSeller($sellerID);
}

$result = $adminController->viewRegistrationRequests();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .table td {
            overflow: hidden;
            text-overflow: ellipsis; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>View Registration Requests</b></h2>
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
                        <th>Passport (Individual)</th>
                        <th>UEN (Business)</th>
                        <th>ACRA (Business)</th>
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
                            if (!empty($row["passport"])) {
                                echo "<td>" . $row["passport"] . "</td>";
                            } else {
                                echo "<td>N/A</td>";
                            }
                            if (!empty($row["uen"])) {
                                echo "<td>" . $row["uen"] . "</td>";
                            } else {
                                echo "<td>N/A</td>";
                            }
                            echo "<td>";
                            if (!empty($row["ACRA_filepath"])) {
                                echo "<a href='" . $row["ACRA_filepath"] . "' download>Download</a>";
                            } else {
                                echo "N/A";
                            }
                            echo "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>";
                            echo "<form method='POST'>";
                            echo "<input type='hidden' name='seller_id' value='" . $row["seller_id"] . "'>";
                            echo "<button type='submit' class='btn btn-success' name='approve'>Approve</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No pending sellers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
