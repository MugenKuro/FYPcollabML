<?php
include "admin_header.php";
include __DIR__ . "/../controller/AdminController.php";

// Create an instance of the AdminController class
$adminController = new AdminController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $statusFilter = $_POST["statusFilter"];
    $genderFilter = $_POST["genderFilter"];
    $customers = $adminController->viewAllCustomers($statusFilter, $genderFilter);
} else {
    $customers = $adminController->viewAllCustomers("All", "All");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View All Customers</title>
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
                    <h2><b>View All Customers</b></h2>
                </div>
                <div class="col-sm-6">
                    <form method="POST" action="view_customer.php">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="statusFilter">Status:</label>
                                <select class="form-control" name="statusFilter">
                                    <option value="All">All</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="genderFilter">Gender:</label>
                                <select class="form-control" name="genderFilter">
                                    <option value="All">All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-4" >
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
                <th>Customer ID</th>
                <th>User ID</th>
                <th>Nickname</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Image Path</th>
                <th>Address</th>
                <th>Mobile</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($customers)) {
                foreach ($customers as $customer) {
                    echo "<tr>";
                    echo "<td>" . $customer["customer_id"] . "</td>";
                    echo "<td>" . $customer["user_id"] . "</td>";
                    echo "<td>" . $customer["nickname"] . "</td>";
                    echo "<td>" . $customer["gender"] . "</td>";
                    echo "<td>" . $customer["date_of_birth"] . "</td>";
                    echo "<td>" . $customer["first_name"] . "</td>";
                    echo "<td>" . $customer["last_name"] . "</td>";
                    echo "<td>" . $customer["image_path"] . "</td>";
                    echo "<td>" . $customer["address"] . "</td>";
                    echo "<td>" . $customer["mobile"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No customers found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
