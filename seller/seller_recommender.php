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
        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }
        $_SESSION['user_id'] = 43;           // remove this once we have a login system
        
        // Assume the seller's user ID is stored in a session. Fetch it.
        $seller_user_id = $_SESSION['user_id'];

        if (!$seller_user_id) {
            echo '<p class="mt-3">Error: Seller user ID not found.</p>';
            exit;
        }

        $output = shell_exec("python ../python/seller_recommender.py $seller_user_id 2>&1");

        // uncomment below code and comment above code for deployment on Azure 
        // $output = shell_exec("python3 site/wwwroot/python/seller_recommender.py $seller_user_id 2>&1");

        // Parse the JSON output
        $recommendations = json_decode($output, true);
        
        // Display recommendations
        echo '<h1 class="mt-5 text-center">Your Most Recommended Items:</h1>';
        if ($recommendations && json_last_error() == JSON_ERROR_NONE) {
            echo '<ul class="list-group">';
            foreach ($recommendations as $item) {
                echo '<li class="list-group-item">' . $item . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p class="mt-3">No recommendations available. Error: ' . $output . '</p>';  // Display the actual error from the Python script.
        }
        ?>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
