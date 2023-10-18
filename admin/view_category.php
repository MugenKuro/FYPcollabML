<?php
include "Admin.php"; // Include the Admin class
include "admin_header.php";

$admin = new Admin();

$result = $admin->viewAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
    .btn-add-category {
        float: right;
        padding: 5px 10px;
        font-size: 15px;
        margin-right: 5px;
    }
    .btn-add-category .material-icons {
        vertical-align: middle;
    }
</style>
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
                        <a href="add_category.php" class="btn btn-success btn-add-category"><i class="material-icons">&#xE147;</i> <span>Add New Category</span></a>
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
                                echo "<td><a class='edit' href='update_category.php?category_id=" . $row["category_id"] . "'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></a>";
                                echo "<a class='delete' href='delete_category.php?category_id=" . $row["category_id"] . "'><i class='material-icons' data-toggle='tooltip' title='Delete'>&#xE872;</i></a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
