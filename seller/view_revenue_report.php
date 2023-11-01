<?php
// Include db.php to access the Db class
require_once('../entity/db.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $sellerId = $_POST['seller_id'];

    // Create an instance of the Db class
    $db = new Db();

    // Check the database connection
    if ($db->getConnectError()) {
        die("Connection failed: " . $db->getConnectError());
    }

    // Fetch orders for the seller within the date range
    $sql = "SELECT OrderHistory.order_id, OrderHistory.order_date, Items.item_name, CartItems.quantity, Items.price
            FROM OrderHistory
            INNER JOIN ShoppingCarts ON OrderHistory.cart_id = ShoppingCarts.cart_id
            INNER JOIN CartItems ON ShoppingCarts.cart_id = CartItems.cart_id
            INNER JOIN Items ON CartItems.item_id = Items.item_id
            WHERE Items.seller_id = ? AND OrderHistory.order_date BETWEEN ? AND ?";

    // Execute the query using prepared statements
    $params = [$sellerId, $startDate, $endDate];
    $result = $db->query($sql, $params);

    // Initialize variables for total revenue and sales
    $totalRevenue = 0;
    $totalSales = 0;

    // Initialize an array to store order details
    $orders = [];

    // Loop through the query result
    while ($row = $result->fetch_assoc()) {
        $orderDate = $row['order_date'];
        $itemName = $row['item_name'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $revenue = $quantity * $price;

        // Store order details in the array
        $orders[] = [
            'order_date' => $orderDate,
            'item_name' => $itemName,
            'quantity' => $quantity,
            'price' => $price,
            'revenue' => $revenue,
        ];

        // Update total revenue and sales
        $totalRevenue += $revenue;
        $totalSales += $quantity;
    }


    // Return the report data as an array
    $reportData = [
        'startDate' => $startDate,
        'endDate' => $endDate,
        'orders' => $orders,
        'total_revenue' => $totalRevenue,
        'total_sales' => $totalSales,
    ];

    // Load the content into another page for display (e.g., report_display.php)
    include('report_display.php'); // Create report_display.php to display the content
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seller Orders Report</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .container {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-top: 20px;
        }
        .table {
            margin-top: 20px;
        }
        body {
        font-family: Arial, sans-serif;
        font-size: 16px;
        line-height: 1.6;
        }
        table {
        background-color: #fff;
        border-collapse: collapse;
        }
        .table th,
        .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        }
        .table th {
        background-color: #f5f5f5;
        }
        .form-row {
            position: relative;
            display: flex;
            justify-content: flex-start;
            align-items: flex-end;
            height: 100%;
        }
        .btn-generate {
            position: relative; 
        }
    </style>
</head>
<body>
    <div class="container">
        <p><u><strong>ENTER DATE RANGE FOR REPORT</strong></u></p>
        <form method="post" class="mt-4">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group col-md-5">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="hidden" name="seller_id" value="101">
                </div> 
                <div class="form-group col-md-2" style="text-align: left;">
                    <button type="submit" name="generate" class="btn btn-primary btn-generate">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
