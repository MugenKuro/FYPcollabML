<!DOCTYPE html>
<html>
<head>
    <title>Seller Recommendations</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Execute the Python script
        $output = shell_exec('python python/seller_recommender.py 2>&1');
        
        // Parse the JSON output
        $recommendations = json_decode($output);
        
        // Display recommendations
        echo '<h1 class="mt-5 text-center">Your Most Recommended Items:</h1>';
        if ($recommendations) {
            echo '<ul class="list-group">';
            foreach ($recommendations as $item) {
                echo '<li class="list-group-item">' . $item . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p class="mt-3">No recommendations available.</p>';
        }
        ?>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
