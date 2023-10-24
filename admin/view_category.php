<?php
include __DIR__ . "/../controller/AdminController.php";
include "admin_header.php";

$adminController = new AdminController();

$result = $adminController->viewAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <style>
        .btn-add-category {
            float: right;
            padding: 5px 10px;
            font-size: 15px;
            margin-right: 5px;
        }
        .btn-add-category .glyphicon {
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
                        <a href="add_category.php" class="btn btn-success btn-add-category"><span class="glyphicon glyphicon-plus"></span> <span>Add New Category</span></a>
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
                                        <a href='update_category.php?category_id=" . $row["category_id"] . "' class='btn btn-warning' data-toggle='tooltip' title='Edit'><span class='glyphicon glyphicon-pencil'></span></a>
                                        <a href='delete_category.php?category_id=" . $row["category_id"] . "' class='btn btn-danger' data-toggle='tooltip' title='Delete'><span class='glyphicon glyphicon-trash'></span></a>
                                      </td>";
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
    <!-- Bootstrap JS and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
