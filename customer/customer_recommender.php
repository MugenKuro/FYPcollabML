<!DOCTYPE html>
<html>
<head>
    <title>Customer Recommendations</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }

        .item-card {
            margin-bottom: 20px;
            padding: 10px;
        }

        .item-card img {
            max-width: 100%;
            height: 200px; 
            object-fit: cover; 
        }

        .center-content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Include db.php to access the Db class
        require_once('../entity/db.php');
        
        // Create an instance of the Db class
        $db = new Db();
        
        // Execute the Python script to get recommendations
        $output = shell_exec("python ../python/customer_recommender.py 2>&1");
        echo $output;
        // Parse the JSON output
        $recommendations = json_decode($output);
    
        // Display recommendations
        if ($recommendations) {
            echo '<h1 class="mt-5 text-center">Trending items just for you</h1>';
            echo '<div class="row justify-content-center">';
            
            // Use the Db class to execute queries
            foreach ($recommendations as $item_id) {
                // Retrieve item details including the image path from the database
                $query = "SELECT item_name, item_image_path FROM Items WHERE item_id = ?";
                $result = $db->query($query, [$item_id]);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $item_name = $row['item_name'];
                    $item_image_path = $row['item_image_path'];
                    
                    // Check if the image path exists
                    if (file_exists($item_image_path)) {
                        // Display item details with a clickable image as a Bootstrap card
                        echo '<div class="col-md-2 item-card">';
                        echo '<div class="card">';
                        echo '<a href="item_details.php?item_id=' . $item_id . '">';
                        echo '<img src="' . $item_image_path . '" alt="' . $item_name . '" class="card-img-top">';
                        echo '</a>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $item_name . '</h5>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Display item details with a default image
                        $default_image_path = 'item_images/default.jpg';
                        echo '<div class="col-md-2 item-card">';
                        echo '<div class="card">';
                        echo '<a href="item_details.php?item_id=' . $item_id . '">';
                        echo '<img src="' . $default_image_path . '" alt="' . $item_name . '" class="card-img-top">';
                        echo '</a>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $item_name . '</h5>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
            
            echo '</div>';
        } else {
            echo '<p class="mt-3 text-center">No recommendations available.</p>';
        }
        ?>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
