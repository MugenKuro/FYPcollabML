<?php
include __DIR__ . "/../entity/db.php"; // Include the db.php file using the correct relative path
include "admin_header.php";
// Create a new Db instance
$db = new Db();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle the form submission
    if (isset($_POST["approve"])) {
        // User clicked "Approve" button
        $request_id = $_POST["request_id"];
        
        // Update CategoryRequests status to 'approved'
        $approveQuery = "UPDATE CategoryRequests SET status = 'approved' WHERE request_id = ?";
        $db->query($approveQuery, [$request_id]);

        // Retrieve category_name for the approved request
        $selectQuery = "SELECT category_name FROM CategoryRequests WHERE request_id = ?";
        $category_name = $db->query($selectQuery, [$request_id])->fetch_assoc()["category_name"];

        // Insert a new record into Categories with the same category_name and 'active' status
        $insertQuery = "INSERT INTO Categories (category_name, status) VALUES (?, 'active')";
        $db->query($insertQuery, [$category_name]);
    } elseif (isset($_POST["disapprove"])) {
        // User clicked "Disapprove" button
        $request_id = $_POST["request_id"];
        
        // Update CategoryRequests status to 'disapproved'
        $disapproveQuery = "UPDATE CategoryRequests SET status = 'disapproved' WHERE request_id = ?";
        $db->query($disapproveQuery, [$request_id]);
    }
}

try {
    // Fetch records from CategoryRequests with status 'pending'
    $selectRequestsQuery = "SELECT request_id, seller_id, category_name FROM CategoryRequests WHERE status = 'pending'";
    $result = $db->query($selectRequestsQuery);

    // Additional details query using a JOIN
    $additionalDetailsQuery = "SELECT Sellers.seller_name, CategoryRequests.description FROM Sellers
                                INNER JOIN CategoryRequests ON Sellers.seller_id = CategoryRequests.seller_id
                                WHERE CategoryRequests.request_id = ?";
    
    $modal = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modal .= "<tr>";
            $modal .= "<td>" . $row["request_id"] . "</td>";
            $modal .= "<td>" . $row["seller_id"] . "</td>";
            $modal .= "<td>" . $row["category_name"] . "</td>";
            $modal .= "<td>
                        <button class='btn btn-primary' data-toggle='modal' data-target='#viewModal" . $row["request_id"] . "'>View</button>
                        </td>";
            $modal .= "</tr>";

            // View Modal
            $modal .= "<div class='modal fade' id='viewModal" . $row["request_id"] . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
            $modal .= "<div class='modal-dialog' role='document'>";
            $modal .= "<div class='modal-content'>";
            $modal .= "<div class='modal-header'>";
            $modal .= "<h5 class='modal-title' id='exampleModalLabel'>Request Details</h5>";
            $modal .= "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            $modal .= "<span aria-hidden='true'>&times;</span>";
            $modal .= "</button>";
            $modal .= "</div>";
            $modal .= "<div class='modal-body'>";
            $modal .= "<p><strong>Request ID:</strong> " . $row["request_id"] . "</p>";
            $modal .= "<p><strong>Seller ID:</strong> " . $row["seller_id"] . "</p>";

            // Fetch additional details from Sellers and CategoryRequests
            $additionalDetails = $db->query($additionalDetailsQuery, [$row["request_id"]])->fetch_assoc();

            $modal .= "<p><strong>Seller Name:</strong> " . $additionalDetails["seller_name"] . "</p>";
            $modal .= "<p><strong>Category Name:</strong> " . $row["category_name"] . "</p>";
            $modal .= "<p><strong>Description:</strong> " . $additionalDetails["description"] . "</p>";
            $modal .= "</div>";
            $modal .= "<div class='modal-footer'>";
            $modal .= "<form method='post'>";
            $modal .= "<input type='hidden' name='request_id' value='" . $row["request_id"] . "'>";
            $modal .= "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
            $modal .= "<button type='submit' name='approve' class='btn btn-success'>Approve</button>";
            $modal .= "<button type='submit' name='disapprove' class='btn btn-danger'>Disapprove</button>";
            $modal .= "</form>";
            $modal .= "</div>";
            $modal .= "</div>";
            $modal .= "</div>";
            $modal .= "</div>";
        }
    } else {
        $modal .= "<tr><td colspan='4'>No pending category requests.</td></tr>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
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
