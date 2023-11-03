    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="iCloth navigation bar">

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

                <div class="search">
                    <!-- Another variation with a button -->
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button"
                                style="background-color: #10a4e3; border-color:#10a4e3 ">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
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