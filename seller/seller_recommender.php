<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$seller_user_id = $_SESSION['user_id'];

require_once ('../entity/db.php');
require_once ('../sellerAuth.php');

$db = new Db();

// Retrieve the top 5 items with the most sales
$sql = "SELECT I.item_name, SUM(CI.quantity) AS total_sales
        FROM Items AS I
        JOIN CartItems AS CI ON I.item_id = CI.item_id
        JOIN ShoppingCarts AS SC ON CI.cart_id = SC.cart_id
        JOIN OrderHistory AS OH ON SC.cart_id = OH.cart_id
        GROUP BY I.item_name
        ORDER BY total_sales DESC
        LIMIT 5";

$saleResult = $db->query($sql);

// Create arrays to store item names and sales data
$item_Names = [];
$totalSales = [];

if ($saleResult->num_rows > 0) {
    while ($row = $saleResult->fetch_assoc()) {
        $item_Names[] = $row['item_name'];
        $totalSales[] = $row['total_sales'];
    }
}

// Execute the Python script to get recommendations

// for windows
// $pythonScript = "python seller_recommender.py $seller_user_id";

// for Azure
$pythonScript = "/home/site/wwwroot/myenv/bin/python3 /home/site/wwwroot/seller/seller_recommender.py $seller_user_id 2>&1";
$output = shell_exec($pythonScript);
// echo $output;

// Parse the JSON output from the Python script
$recommendations = json_decode($output, true);
echo '<!Doctype html>
<html lang="en">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <title>iCloth</title>

</head>
<body>';
include('sellerNavBar.php');
if (!$recommendations) {
    echo '<div class="container mt-5"><p class="text-center">No recommendations available.</p></div>';
} else {
    echo '<div class="container mt-5">';
    echo '<h1 class="text-center">Your Recommended Items:</h1>';
    echo '<div class="row">';

    $itemNames = [];
    $predictedRatings = [];

    foreach ($recommendations as $rec) {
        // Fetch additional item details from the database
        $item_id = $rec['item_id'];
        $sql = "SELECT item_id, item_name, price, item_image_path FROM Items WHERE item_id = $item_id";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $item_name = $row['item_name'];
            $price = $row['price'];
            $item_image_path = '../' . $row['item_image_path'];

            // Truncate long item names and add ellipsis
            $displayed_item_name = strlen($item_name) > 30 ? substr($item_name, 0, 30) . '...' : $item_name;

            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<img src="' . $item_image_path . '" class="card-img-top" alt="' . $item_name . '" style="height: 250px;">'; // Set a fixed height
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $displayed_item_name . '</h5>'; // Display truncated item name
            echo '<p class="card-text">Price: $' . $price . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            // Store item names and predicted ratings for the chart
            $itemNames[] = $displayed_item_name;
            $predictedRatings[] = $rec['predicted_rating'];
            $prices[] = $price;
        }
    }

    echo '</div>';
    echo '</div>';
}
?>
<!-- HTML element for the bar chart -->
<div class="container mt-5">
    <h1 class="text-center">predicted ratings for your recommended items</h1>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <canvas id="barChart" width="1000" height="500"></canvas>
        </div>
    </div>
</div>
<!-- HTML element for the second bar chart -->
<div class="container mt-5">
    <h1 class="text-center">Top 5 Items with Most Sales</h1>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <!-- HTML element for the bar chart -->
            <canvas id="barChart2"></canvas>
        </div>
    </div>
</div>

</body>
<!-- JavaScript for creating the bar chart -->
<script>
    var ctx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($itemNames); ?>,
            datasets: [{
                label: 'Predicted Ratings',
                data: <?php echo json_encode($predictedRatings); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5 // You can adjust the max value as needed
                }
            }
        }
    });
</script>
<!-- JavaScript for creating barchart 2 -->
<script>
    var ctx = document.getElementById('barChart2').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($item_Names); ?>,
            datasets: [{
                label: 'Total Sales',
                data: <?php echo json_encode($totalSales); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
</script>
</html>


