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

        .card-title {
            height: 40px;           
            overflow: hidden;       
            text-overflow: ellipsis;
            white-space: nowrap;    
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
        require_once('../entity/db.php');
        $db = new Db();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = 10;               // remove this once we have a login system
        $customer_user_id = $_SESSION['user_id'];

        // $output = shell_exec("python ../python/customer_recommender.py $customer_user_id 2>&1");
        // uncomment below code and comment above code for deployment on Azure
        $output = shell_exec("PYTHONPATH=/home/.local/lib/python3.9/site-packages /usr/bin/python3 /home/site/wwwroot/customer/customer_recommender.py $customer_user_id 2>&1");
        
        $recommendations = json_decode($output, true);
        
        if ($recommendations && json_last_error() == JSON_ERROR_NONE) {
            displayItems($db, $recommendations, "Trending items just for you");
        } else {
            $query = "SELECT Items.item_id, item_name, item_image_path, AVG(rating_value) as avg_rating FROM ItemRatings JOIN Items ON ItemRatings.item_id = Items.item_id GROUP BY Items.item_id ORDER BY avg_rating DESC LIMIT 5";
            $result = $db->query($query);
            $popularItems = [];
            
            while ($row = $result->fetch_assoc()) {
                $popularItems[] = $row['item_id'];
            }

            displayItems($db, $popularItems, "Most Popular Items");
        }

        function displayItems($db, $itemIds, $title) {
            echo "<h1 class='mt-5 text-center'>{$title}</h1>";
            echo '<div class="row justify-content-center">';
            
            foreach ($itemIds as $item_id) {
                $query = "SELECT item_name, item_image_path FROM Items WHERE item_id = ?";
                $result = $db->query($query, [$item_id]);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $item_name = $row['item_name'];
                    $item_image_path = $row['item_image_path'];
                    
                    echo '<div class="col-md-2 item-card">';
                    echo '<div class="card">';
                    echo '<a href="item_details.php?item_id=' . $item_id . '">';
                    echo '<img src="../' . $item_image_path . '" alt="' . $item_name . '" class="card-img-top">';
                    echo '</a>';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $item_name . '</h5>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            
            echo '</div>';
        }
        ?>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
