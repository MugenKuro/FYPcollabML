<?php
include __DIR__ . "/../controller/AdminController.php";
include "admin_header.php";

$adminController = new AdminController();

$modal = $adminController->handleCategoryRequests();

?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-12">
                        <h2><b>View Pending Category Requests</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Seller ID</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    echo $modal; // Output the modal HTML
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
