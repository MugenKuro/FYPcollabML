<?php
include __DIR__ . "/../entity/db.php";// Include the db.php file
include "admin_header.php";

// Create a new Db instance
$db = new Db();

try {
    // Fetch all customers from the Customers table
    $sql = "SELECT * FROM Customers";
    $result = $db->query($sql);
} catch (Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}
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
                    <div class="col-sm-6">
                        <h2><b>View All Customers</b></h2>
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
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["customer_id"] . "</td>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["nickname"] . "</td>";
                            echo "<td>" . $row["gender"] . "</td>";
                            echo "<td>" . $row["date_of_birth"] . "</td>";
                            echo "<td>" . $row["first_name"] . "</td>";
                            echo "<td>" . $row["last_name"] . "</td>";
                            echo "<td>" . $row["image_path"] . "</td>";
                            echo "<td>" . $row["address"] . "</td>";
                            echo "<td>" . $row["mobile"] . "</td>";
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
