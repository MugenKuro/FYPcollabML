<?php
require_once './controller/userController.php';
?>


<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="iCloth navigation bar">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the .search element
            var searchElement = document.querySelector('.search');

            // Check if it's empty
            if (searchElement.innerHTML.trim() === '') {
                // Set z-index to -1
                searchElement.style.zIndex = '-1';
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            var searchElement = document.querySelector('.search');

            // Add a click event listener to the document
            document.addEventListener('click', function (event) {
                // Check if the clicked element is not within the .search element
                if (!searchElement.contains(event.target)) {
                    // Clear the content of the .search element
                    searchElement.innerHTML = '';
                    // Set z-index to -1
                    searchElement.style.zIndex = '-1';
                }
            });
        });

    </script>

    <div class="container">
        <a class="navbar-brand" href="index.php">iCloth</a>

        <div class="collapse navbar-collapse">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li>
                    <a class="nav-link" href="index.php">Home</a>
                    <a class="nav-link" href="purchaseHistory.php">Purchase history</a>
                    <a class="nav-link" href="userAccountSetting.php">settings</a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    style="background-color: #10a4e3; border-color:#10a4e3">All Category
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php
                    $category = new viewAllCategories();
                    $data = json_decode($category->viewAllCategories());
                    foreach ($data as $category) {
                        echo '<a class="dropdown-item" href="viewItemByCat.php?category_id=' . $category->category_id . '">' . $category->category_name . '</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="right-content">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="search-box">

                        <!-- Another variation with a button -->
                        <div class="input-group">
                            <input type="text" name="tags" class="form-control" placeholder="Search" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"
                                    style="background-color: #10a4e3; border-color:#10a4e3 ">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!--  Search pop up -->
                        <div class="search">
                            <?php

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST["tags"])) {
                                    $search = str_replace(",", "|", $_POST["tags"]);
                                    $searchItem = new searchItemByName();
                                    $result = json_decode($searchItem->searchItem($search));
                                    // Iterate over movie data and generate HTML for each movie
                                    foreach ($result as $item) {
                                        // Extract movie data from current row
                                        $item_id = $item->item_id;
                                        $item_name = $item->item_name;
                                        $item_price = $item->price;
                                        $image_path = $item->item_image_path;
                                        $image_src = "." . $image_path;

                                        // Generate HTML for current movie
                                        echo '<a href=' . "viewitem.php?item_id=$item_id" . ' class="card">';
                                        echo '<div class="card-content">';
                                        echo '<img id="card_image" src="' . $image_src . '" alt="">';
                                        echo '<div class="cont" style="pointer-events: auto; overflow-y: auto;">';
                                        echo '<h3>' . $item_name . '</h3>';
                                        echo '<p>' . '$' . $item_price . '</p>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</a>';
                                    }
                                }
                            }

                            ?>
                        </div>
                    </div>
                </form>
            </div>
            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <li><span class="nav-link">Welcome,
                        <?php echo htmlspecialchars($_SESSION["username"]); ?>
                    </span></li>
                <li><a class="nav-link" href="logout.php"><img src="images/user.svg"><span> log out</span></a></li>
                <li><a class="nav-link" href="cart.php"><img src="images/cart.svg"><span> cart</span></a></li>
            </ul>
        </div>
    </div>

</nav>
<!-- End Header/Navigation -->