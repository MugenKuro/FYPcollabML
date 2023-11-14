<?php
require_once('auth.php');
require_once dirname(__FILE__) . '/controller/categoriesController.php';
if (session_status() === PHP_SESSION_NONE)
    session_start();

if (isset($_SESSION['accountType'])) {
    $userRole = $_SESSION['accountType'];
    $allowedRoles = array("Customer");

    if (!in_array($userRole, $allowedRoles)) {
        header("location: trending.php");
        exit;
    }
} else {
    header("location: login.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>iCloth</title>

</head>
<body>
    <?php
    include dirname(__FILE__) . ('/custNavBar.php');

    $customer_user_id = $_SESSION['user_id'];
    // for windows
    // $output = shell_exec("python customer/customer_recommender.py $customer_user_id 2>&1");

    // for Azure
    $output = shell_exec("/home/site/wwwroot/myenv/bin/python3 /home/site/wwwroot/customer/customer_recommender.py $customer_user_id 2>&1");
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
        $container02Count = 0;

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

                if ($container02Count % 4 == 0) {
                    // Start a new homepage-container02 after every 4 items
                    echo '<div class="homepage-container02">';
                }

                echo '<div class="homepage-container03" onclick="redirectToViewItem(' . $item_id . ')">';
                echo '<img alt="image" src="./' . $item_image_path . '" class="homepage-image" />';
                echo '<span>';
                echo '<span>' . $item_name . '</span>';
                echo '<br />';
                echo '</span>';
                echo '<span>$' . $item_price . '</span>';
                echo '</div>';

                if (($container02Count + 1) % 4 == 0) {
                    // Close the current homepage-container02 after every 4 items
                    echo '</div>';
                }

                $container02Count++;
            }
        }

        // Close the last homepage-container02 if not already closed
        if ($container02Count % 4 != 0) {
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
    } else {
        echo $output;

        echo '<div class="homepage-container">';
        echo '<h1 class="homepage-text">Most Popular Items</h1>';
        echo '<div class="homepage-container01">';

        // Fetch the user's gender from the Customer table
        $genderQuery = "SELECT gender FROM Customers WHERE user_id = ?";
        $genderResult = $db->query($genderQuery, [$customer_user_id]);

        if ($genderResult->num_rows > 0) {
            $row = $genderResult->fetch_assoc();
            $userGender = $row['gender'];

            // Determine the category range based on user's gender
            if ($userGender === 'Male' || $userGender === 'male') {
                // For male users, use category_id ranging from 1 to 5
                $minCategoryId = 1;
                $maxCategoryId = 5;
            } elseif ($userGender === 'Female' || $userGender === 'female') {
                // For female users, use category_id ranging from 6 to 11
                $minCategoryId = 6;
                $maxCategoryId = 11;
            } else {
                // Handle other gender options as needed
                $minCategoryId = null;
                $maxCategoryId = null;
            }

            // Check if the user's gender is valid and determine the category range
            if ($minCategoryId !== null && $maxCategoryId !== null) {
                // Display most popular items based on user's gender and category range
                // Query to retrieve most popular items filtered by gender and category range
                $popularItemsQuery = "SELECT Items.item_id, item_name, item_image_path, price FROM Items 
                    JOIN ItemRatings ON Items.item_id = ItemRatings.item_id 
                    WHERE Items.category_id >= ? AND Items.category_id <= ?  AND Items.status = 'Active'
                    GROUP BY Items.item_id 
                    ORDER BY AVG(ItemRatings.rating_value) DESC 
                    LIMIT 8";

                // Execute the query with the category range as parameters
                $popularItemsResult = $db->query($popularItemsQuery, [$minCategoryId, $maxCategoryId]);

                // Initialize counter for homepage-container02
                $container02Count = 0;

                // Loop through the popular items and display them
                while ($row = $popularItemsResult->fetch_assoc()) {
                    $item_id = $row['item_id'];
                    $item_name = $row['item_name'];
                    $item_image_path = $row['item_image_path'];
                    $item_price = $row['price'];

                    if ($container02Count % 4 == 0) {
                        // Start a new homepage-container02 after every 4 items
                        echo '<div class="homepage-container02">';
                    }

                    echo '<div class="homepage-container03" onclick="redirectToViewItem(' . $item_id . ')">';
                    echo '<img alt="image" src="' . $item_image_path . '" class="homepage-image" />';
                    echo '<span>';
                    echo '<span>' . $item_name . '</span>';
                    echo '<br />';
                    echo '</span>';
                    echo '<span>$' . $item_price . '</span>';
                    echo '</div>';

                    if (($container02Count + 1) % 4 == 0) {
                        // Close the current homepage-container02 after every 4 items
                        echo '</div>';
                    }

                    $container02Count++;
                }

                // Close the last homepage-container02 if not already closed
                if ($container02Count % 4 != 0) {
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
            } else {
                echo 'Invalid user gender or other options.';
            }
        } else {
            echo 'User gender not found.';
        }
    }
    ?>
    <script>
        function redirectToViewItem(itemId) {
            // Redirect to the viewItem page with the item ID as a parameter
            window.location.href = "viewItem.php?item_id=" + itemId;
        }
    </script>
</body>
</html>
