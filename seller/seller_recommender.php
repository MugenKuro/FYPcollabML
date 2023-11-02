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

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = 10;    // Change this once we have a login system
        if (isset($_SESSION['user_id'])) {
            $seller_user_id = $_SESSION['user_id'];
        } else {
            // Handle the case where seller_user_id isn't set
            die("User ID not found.");
        }

        // Get the path to the python3 interpreter
        $pythonPath = shell_exec("which python3");
        $pythonPath = trim($pythonPath);
        $scriptPath = getcwd() . "/../python/seller_recommender.py";
        $command = "{$pythonPath} {$scriptPath} {$seller_user_id} 2>&1";

        $output = shell_exec($command);
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
