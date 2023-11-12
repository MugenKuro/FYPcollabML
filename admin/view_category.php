<?php
include __DIR__ . "/../controller/AdminController.php";
include "admin_header.php";

$adminController = new AdminController();

$result = $adminController->viewAllCategories();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Admin</title>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>View All Categories</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="add_category.php" class="btn btn-success float-end"><span>Add New Category</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["category_id"] . "</td>";
                                echo "<td>" . $row["category_name"] . "</td>";
                                echo "<td>" . $row["status"] . "</td>";
                                echo "<td>
                                        <div class='btn-group'>
                                            <a href='update_category.php?category_id=" . $row["category_id"] . "' class='btn btn-warning btn-update text-white' data-bs-toggle='tooltip' title='Edit'>Update</a>
                                            <a href='delete_category.php?category_id=" . $row["category_id"] . "' class='btn btn-danger btn-delete text-white' data-bs-toggle='tooltip' title='Delete'>Delete</a>
                                        </div>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>0 results</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
