<?php
include "admin_header.php";
include __DIR__ . "/../controller/AdminController.php";

// Create an instance of the AdminController class
$adminController = new AdminController();

$result = $adminController->viewAllSellers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View All Sellers</title>
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
                        <h2><b>View All Sellers</b></h2>
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
                        <!-- <th>Profile Image</th> -->
                        <th>Bank</th>
                        <th>Bank Acc No.</th>
                        <th>Pickup Address</th>
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
                            // echo "<td>" . $row["profile_image"] . "</td>";
                            echo "<td>" . $row["bank_name"] . "</td>";
                            echo "<td>" . $row["bank_account_no"] . "</td>";
                            echo "<td>" . $row["pick_up_address"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No sellers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
