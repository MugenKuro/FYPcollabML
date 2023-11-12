<?php
include "admin_header.php";
include __DIR__ . "/../controller/AdminController.php";

// Create an instance of the AdminController class
$adminController = new AdminController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sellerTypeFilter = $_POST["seller_type"];
    $statusFilter = $_POST["status"];
    $sellers = $adminController->viewAllSellers($sellerTypeFilter, $statusFilter);
} else {
    $sellers = $adminController->viewAllSellers("All", "All");
}
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
                    <div class="col-sm-6">
                        <form method="POST" action="view_seller.php">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="seller_type">Seller Type:</label>
                                    <select class="form-control" name="seller_type">
                                        <option value="All">All</option>
                                        <option value="Individual Seller">Individual Seller</option>
                                        <option value="Business Seller">Business Seller</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="status">Status:</label>
                                    <select class="form-control" name="status">
                                        <option value="All">All</option>
                                        <option value="Active">Active</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Pending Approval">Pending Approval</option>
                                        <option value="Pending Deactivation">Pending Deactivation</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                                </div>
                            </div>
                        </form>
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
                    if ($sellers->num_rows > 0) {
                        while ($row = $sellers->fetch_assoc()) {
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
