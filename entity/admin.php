<?php

include __DIR__ . "/../entity/db.php";

class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    // Function to get all customers
    public function getAllCustomers()
    {
        $sql = "SELECT * FROM Customers";
        $result = $this->db->query($sql);

        $customers = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
        }

        return $customers;
    }

    // Function to add a new category
    public function addCategory($categoryName, $status) {
        try {
            $sql = "INSERT INTO categories (category_name, status) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ss", $categoryName, $status);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Function to delete a category
    public function deleteCategory($categoryID) {
        try {
            $sql = "DELETE FROM categories WHERE category_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $categoryID);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function confirmDeletion() {
        // confirmation logic using javascript
        return true; 
    }

    // Function to get and update a category
    public function getCategoryById($categoryId) {
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function updateCategory($categoryId, $categoryName, $status) {
        try {
            $sql = "UPDATE categories SET category_name = ?, status = ? WHERE category_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssi", $categoryName, $status, $categoryId);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    // Function to handle category requests
    public function handleCategoryRequests() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["approve"])) {
                $request_id = $_POST["request_id"];
                
                $approveQuery = "UPDATE CategoryRequests SET status = 'Active' WHERE request_id = ?";
                $this->db->query($approveQuery, [$request_id]);
    
                $selectQuery = "SELECT category_name FROM CategoryRequests WHERE request_id = ?";
                $category_name = $this->db->query($selectQuery, [$request_id])->fetch_assoc()["category_name"];
    
                $insertQuery = "INSERT INTO Categories (category_name, status) VALUES (?, 'Active')";
                $this->db->query($insertQuery, [$category_name]);
            } elseif (isset($_POST["disapprove"])) {
                $request_id = $_POST["request_id"];
    
                // Delete the CategoryRequest instead of updating its status
                $deleteQuery = "DELETE FROM CategoryRequests WHERE request_id = ?";
                $this->db->query($deleteQuery, [$request_id]);
            }
        }
    
        try {
            $selectRequestsQuery = "SELECT request_id, seller_id, category_name FROM CategoryRequests WHERE status = 'Pending'";
            $result = $this->db->query($selectRequestsQuery);
    
            $additionalDetailsQuery = "SELECT Sellers.seller_name, CategoryRequests.description FROM Sellers
                                        INNER JOIN CategoryRequests ON Sellers.seller_id = CategoryRequests.seller_id
                                        WHERE CategoryRequests.request_id = ";
            
            $modal = "";
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $modal .= "<tr>";
                    $modal .= "<td>" . $row["request_id"] . "</td>";
                    $modal .= "<td>" . $row["seller_id"] . "</td>";
                    $modal .= "<td>" . $row["category_name"] . "</td>";
                    $modal .= "<td>
                                <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#viewModal" . $row["request_id"] . "'>View</button>
                                </td>";
                    $modal .= "</tr>";
    
                    // View Modal
                    $modal .= "<div class='modal fade' id='viewModal" . $row["request_id"] . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                    $modal .= "<div class='modal-dialog' role='document'>";
                    $modal .= "<div class='modal-content'>";
                    $modal .= "<div class='modal-header'>";
                    $modal .= "<h5 class='modal-title' id='exampleModalLabel'>Request Details</h5>";
                    $modal .= "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    $modal .= "</div>";
                    $modal .= "<div class='modal-body'>";
                    $modal .= "<p><strong>Request ID:</strong> " . $row["request_id"] . "</p>";
                    $modal .= "<p><strong>Seller ID:</strong> " . $row["seller_id"] . "</p>";
    
                    $additionalDetails = $this->db->query($additionalDetailsQuery . $row["request_id"])->fetch_assoc();
    
                    $modal .= "<p><strong>Seller Name:</strong> " . $additionalDetails["seller_name"] . "</p>";
                    $modal .= "<p><strong>Category Name:</strong> " . $row["category_name"] . "</p>";
                    $modal .= "<p><strong>Description:</strong> " . $additionalDetails["description"] . "</p>";
                    $modal .= "</div>";
                    $modal .= "<div class='modal-footer'>";
                    $modal .= "<form method='post'>";
                    $modal .= "<input type='hidden' name='request_id' value='" . $row["request_id"] . "'>";
                    $modal .= "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
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
    
        return $modal;
    }
    
    

    // Function to view all categories
    public function viewAllCategories() {
        try {
            $sql = "SELECT * FROM categories";
            $result = $this->db->query($sql);
            return $result;
        } catch (Exception $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    //Functions to view deactivation requests
    public function viewDeactivationRequests() {
        try {
            $sql = "SELECT u.*, s.seller_id FROM Users u
                    LEFT JOIN Sellers s ON u.user_id = s.user_id
                    WHERE u.status = 'Pending deactivation' AND u.account_type = 'Seller'";
            $result = $this->db->query($sql);
            return $result;
        } catch (Exception $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
    
    public function deactivateSeller($sellerID) {
        try {
            $updateSql = "UPDATE Users SET status = 'Inactive' WHERE user_id = ? AND account_type = 'Seller'";
            $stmt = $this->db->prepare($updateSql);
            $stmt->bind_param("i", $sellerID);
            $stmt->execute();
        } catch (Exception $e) {
            echo $updateSql . "<br>" . $e->getMessage();
        }
    }
    
    public function viewRegistrationRequests() {
        try {
            $sql = "SELECT u.*, s.seller_id, i.passport, b.uen, b.ACRA_filepath FROM Users u
                    LEFT JOIN Sellers s ON u.user_id = s.user_id
                    LEFT JOIN IndividualSellers i ON s.seller_id = i.seller_id
                    LEFT JOIN BusinessSellers b ON s.seller_id = b.seller_id
                    WHERE u.status = 'Pending approval' AND u.account_type = 'Seller'";
            $result = $this->db->query($sql);
            return $result;
        } catch (Exception $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
    
    public function approveSeller($sellerID) {
        try {
            $updateSql = "UPDATE Users SET status = 'Active' WHERE user_id = ? AND account_type = 'Seller'";
            $stmt = $this->db->prepare($updateSql);
            $stmt->bind_param("i", $sellerID);
            $stmt->execute();
        } catch (Exception $e) {
            echo $updateSql . "<br>" . $e->getMessage();
        }
    }
    

    // Function to view all sellers
    public function viewAllSellers() {
        try {
            // Fetch all sellers from the Sellers table
            $sql = "SELECT * FROM Sellers";
            $result = $this->db->query($sql);
            return $result;
        } catch (Exception $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
}
?>