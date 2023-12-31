<style>
    .item-name {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        /* Number of lines to show */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .seller-name-link:hover {
        font-size: 1.2em;
        transition: font-size 0.3s;
    }
</style>

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

            // Initialize counter for homepage-container02
            $container02Count = 25;

            // Loop through the recommendations and display them dynamically
            foreach ($recommendations as $recommendation) {
                // Query to retrieve item details based on item_id
                $itemQuery = "SELECT item_name, item_image_path, price, seller_id FROM Items WHERE item_id = ?";
                $itemResult = $db->query($itemQuery, [$recommendation]);

                if ($itemResult->num_rows > 0) {
                    $row = $itemResult->fetch_assoc();
                    $item_id = $recommendation;
                    $item_name = $row['item_name'];
                    $item_image_path = $row['item_image_path'];
                    $item_price = $row['price'];
                    $seller_id = $row['seller_id'];

                    // Query to retrieve seller name based on seller_id
                    $sellerQuery = "SELECT seller_name FROM Sellers
                                    WHERE seller_id = ?";
                    $sellerResult = $db->query($sellerQuery, [$seller_id]);
                    $seller_name = ($sellerResult->num_rows > 0) ? $sellerResult->fetch_assoc()['seller_name'] : 'Prem Shop';

                    echo '<div class="view-item-container' . $container02Count . '" onclick="redirectToViewItem(' . $item_id . ')">';
                    echo '<a href="viewSellerIndex.php?seller_id=' . $seller_id . '" class="seller-name-link" style="font-weight: bold; text-decoration: none; color: inherit;">' . $seller_name . '</a>';
                    echo '<img alt="image" src="./' . $item_image_path . '" class="homepage-image" />';
                    echo '<span class="item-name">';
                    echo '<span>' . $item_name . '</span>';
                    echo '<br />';
                    echo '</span>';
                    echo '<span>$' . $item_price . '</span>';
                    echo '</div>';

                    $container02Count++;
                }
            }

        } else {
            // failure so display random
            // Set the seed
            mt_srand($item_id_rec);
            $container02Count = 25;

            for ($x = 0; $x < 3; $x++) {

                // Generate a random number between 1 and 10
                $random_number = mt_rand(4, 580);

                $itemQuery = "SELECT item_name, item_image_path, price, seller_id FROM Items WHERE item_id = ?";
                $itemResult = $db->query($itemQuery, [$random_number]);

                if ($itemResult->num_rows > 0) {
                    $row = $itemResult->fetch_assoc();
                    $item_id = $random_number;
                    $item_name = $row['item_name'];
                    $item_image_path = $row['item_image_path'];
                    $item_price = $row['price'];
                    $seller_id = $row['seller_id'];

                    // Query to retrieve seller name based on seller_id
                    $sellerQuery = "SELECT seller_name FROM Sellers
                                    WHERE seller_id = ?";
                    $sellerResult = $db->query($sellerQuery, [$seller_id]);
                    $seller_name = ($sellerResult->num_rows > 0) ? $sellerResult->fetch_assoc()['seller_name'] : 'Prem Shop';


                    echo '<div class="view-item-container' . $container02Count . '" onclick="redirectToViewItem(' . $item_id . ')">';
                    echo '<a href="viewSellerIndex.php?seller_id=' . $seller_id . '" class="seller-name-link" style="font-weight: bold; text-decoration: none; color: inherit;">' . $seller_name . '</a>';
                    echo '<img alt="image" src="./' . $item_image_path . '" class="homepage-image" />';
                    echo '<span>';
                    echo '<span style="display: block; text-align: center">' . $item_name . '</span>';
                    echo '<br />';
                    echo '</span>';
                    echo '<span>$' . $item_price . '</span>';
                    echo '</div>';

                    $container02Count++;
                }
            }
        }
        ?>
        <script>
            function redirectToViewItem(itemId) {
                // Redirect to the viewItem page with the item ID as a parameter
                window.location.href = "viewItem.php?item_id=" + itemId;
            }
        </script>
    </div>
</div>
