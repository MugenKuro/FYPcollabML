<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userID = $_SESSION['user_id'];

require_once('../entity/db.php');
require_once('../sellerAuth.php');
include('sellerNavBar.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $userID = $_SESSION['user_id'];

    // Create an instance of the Db class
    $db = new Db();

    // Check the database connection
    if ($db->getConnectError()) {
        die("Connection failed: " . $db->getConnectError());
    }

    // Fetch seller details based on the user ID
    $sellerQuery = "SELECT seller_id FROM Sellers WHERE user_id = ?";
    $sellerParams = [$userID];
    $sellerResult = $db->query($sellerQuery, $sellerParams);

    if ($sellerResult) {
        $sellerRow = $sellerResult->fetch_assoc();
        $sellerID = $sellerRow['seller_id'];

        // Fetch orders for the seller within the date range
        $sql = "SELECT OrderHistory.order_id, OrderHistory.order_date, Items.item_name, CartItems.quantity, Items.price,
                       (Items.price * CartItems.quantity * 0.01) AS fee,
                       ((Items.price * CartItems.quantity) - (Items.price * CartItems.quantity * 0.01)) AS revenue
                FROM OrderHistory
                INNER JOIN ShoppingCarts ON OrderHistory.cart_id = ShoppingCarts.cart_id
                INNER JOIN CartItems ON ShoppingCarts.cart_id = CartItems.cart_id
                INNER JOIN Items ON CartItems.item_id = Items.item_id
                WHERE Items.seller_id = ? AND OrderHistory.order_date BETWEEN ? AND ?";
        $params = [$sellerID, $startDate, $endDate];

        // Execute the query using prepared statements
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
            $fee = $row['fee'];
            $revenue = $row['revenue'];

            // Store order details in the array
            $orders[] = [
                'order_date' => $orderDate,
                'item_name' => $itemName,
                'quantity' => $quantity,
                'price' => $price,
                'fee' => $fee,
                'revenue' => $revenue,
            ];

            // Update total revenue, sales, and fee
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
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/sellerStyle.css" rel="stylesheet">


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>iCloth</title>

    <style>
        .a {
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
        }
        .btn-generate {
            position: relative; 
        }
    </style>
</head>
<body>
    <?php
    include('report_display.php'); // report_display.php to display the content
    ?>
    <div class="container a">
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
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8'); ?>">
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
