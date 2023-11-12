<?php
include "admin_header.php";
include __DIR__ . "/../controller/AdminController.php";

// Create an instance of the AdminController class
$adminController = new AdminController();

// Initialize a variable to store the success message
$successMessage = '';

// Check if the "Approve" or "Reject" button is clicked
if ($_SERVER["REQUEST_METHOD"] === "POST" && (isset($_POST["approve"]) || isset($_POST["reject"]))) {
    $sellerID = $_POST["seller_id"];
    
    if (isset($_POST["approve"])) {
        if (!$adminController->approveSeller($sellerID)) {
            $successMessage = "Seller approved successfully";
        } else {
            $successMessage = "Error approving seller";
        }
    } elseif (isset($_POST["reject"])) {
        if (!$adminController->rejectSeller($sellerID)) {
            $successMessage = "Seller rejected successfully";
        } else {
            $successMessage = "Error rejecting seller";
        }
    }
}

$result = $adminController->viewRegistrationRequests();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .table-wrapper {
            background: #fff;
            padding: 20px;
            margin: 30px 0;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            overflow-x: auto; /* Add horizontal scroll on small screens */
            min-width: 1200px; /* Adjust this to the minimum width that your table needs */
        }
        button.btn {
            width: 100px; /* Set a fixed width */
            height: 40px; /* Set a fixed height */
            line-height: 40px; /* Align text vertically */
            text-align: center; /* Align text horizontally */
            padding: 0; /* Remove padding */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Display the success message if available -->
        <?php if (!empty($successMessage)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

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
                            echo "<button type='submit' class='btn btn-danger' name='reject'>Reject</button>";
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
