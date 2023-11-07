<div class="view-item-container23">
    <span class="view-item-text63">
        <span>Similar Items</span>
        <br />
    </span>
    <div class="view-item-container24">
        <?php
        $item_id_rec = $_SESSION['item_id'];
        $output = shell_exec("python3 /home/site/wwwroot/item-recommender/ViewSimilarItems.py $item_id_rec 2>&1");
        $recommendations = json_decode($output, true);

        // Database connection
        require_once dirname(__FILE__) . ('/entity/db.php');
        $db = new Db();

        // Check if there are recommendations, if not, display most popular items
        if ($recommendations && json_last_error() == JSON_ERROR_NONE) {
            echo '<div class="homepage-container">';
            echo '<h1 class="homepage-text">Recommended Just For You</h1>';
            echo '<div class="homepage-container01">';

            // Initialize counter for homepage-container02
            $container02Count = 25;

            // Loop through the recommendations and display them dynamically
            foreach ($recommendations as $recommendation) {
                // Query to retrieve item details based on item_id
                $itemQuery = "SELECT item_name, item_image_path, price FROM Items WHERE item_id = ?";
                $itemResult = $db->query($itemQuery, [$recommendation]);

                if ($itemResult->num_rows > 0) {
                    $row = $itemResult->fetch_assoc();
                    $item_id = $recommendation;
                    $item_name = $row['item_name'];
                    $item_image_path = $row['item_image_path'];
                    $item_price = $row['price'];

                    echo '<div class="view-item-container' . $container02Count . '" onclick="redirectToViewItem(' . $item_id . ')">';
                    echo '<img alt="image" src="./' . $item_image_path . '" class="homepage-image" />';
                    echo '<span>';
                    echo '<span>' . $item_name . '</span>';
                    echo '<br />';
                    echo '</span>';
                    echo '<span>$' . $item_price . '</span>';
                    echo '</div>';

                    $container02Count++;
                }
            }

            echo '</div>';
            echo '</div>';
        } /* else {
            // failure so display random
            // Set the seed
            mt_srand($item_id_rec);
            $container02Count = 25;

            for ($x = 0; $x < 3; $x++) {

                // Generate a random number between 1 and 10
                $random_number = mt_rand(4, 580);

                $itemQuery = "SELECT item_name, item_image_path, price FROM Items WHERE item_id = ?";
                $itemResult = $db->query($itemQuery, [$random_number]);

                if ($itemResult->num_rows > 0) {
                    $row = $itemResult->fetch_assoc();
                    $item_id = $random_number;
                    $item_name = $row['item_name'];
                    $item_image_path = $row['item_image_path'];
                    $item_price = $row['price'];

                    echo '<div class="view-item-container' . $container02Count . '" onclick="redirectToViewItem(' . $item_id . ')">';
                    echo '<img alt="image" src="./' . $item_image_path . '" class="homepage-image" />';
                    echo '<span>';
                    echo '<span>' . $item_name . '</span>';
                    echo '<br />';
                    echo '</span>';
                    echo '<span>$' . $item_price . '</span>';
                    echo '</div>';

                    $container02Count++;
                }
            } 
            }*/
        ?>
        <script>
            function redirectToViewItem(itemId) {
                // Redirect to the viewItem page with the item ID as a parameter
                window.location.href = "viewItem.php?item_id=" + itemId;
            }
        </script>
    </div>
</div>