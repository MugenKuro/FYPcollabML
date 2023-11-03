<!DOCTYPE html>
<html>
<head>
    <title>Seller Orders Report</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
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
    </style>
</head>
<body>
    <div class="container a">
        <!-- <h1 class="mt-4">Seller Orders Report</h1> -->
        <?php
        
        // Include the report data from generate_report.php
        if (isset($reportData)) {
            $startFormatted = date('d F Y', strtotime($reportData['startDate']));
            $endFormatted = date('d F Y', strtotime($reportData['endDate']));
            echo "<h2 class='text-center'><small class='text-muted'>Report Period:</small> {$startFormatted} to {$endFormatted}</h2>";
            // Display the order details in a Bootstrap table
            if (!empty($reportData['orders'])) {
                echo "<table class='table table-bordered'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Order Date and Time</th>";
                echo "<th>Item Name</th>";
                echo "<th>Quantity</th>";
                echo "<th>Price</th>";
                echo "<th>Revenue</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($reportData['orders'] as $order) {
                    echo "<tr>";
                    echo "<td>{$order['order_date']}</td>";
                    echo "<td>{$order['item_name']}</td>";
                    echo "<td>{$order['quantity']}</td>";
                    echo "<td>$" . number_format($order['price'], 2) . "</td>";
                    echo "<td>$" . number_format($order['revenue'], 2) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No orders found for this period.</p>";
            }
            echo "<h4><small class='text-muted'>Total Revenue:</small> $" . number_format($reportData['total_revenue'], 2) . "</h4>";
            echo "<h4><small class='text-muted'>Total Sales:</small> {$reportData['total_sales']} items</h4>";
        } else {
            echo "<p>Report data not available.</p>";
        }
        ?>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
