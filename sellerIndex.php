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

    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="iCloth navigation bar">

        <div class="container">
            <a class="navbar-brand" href="sellerIndex.php">iCloth</a>

            <div class="collapse navbar-collapse">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li>
                        <a class="nav-link" href="sellerIndex.php">Home</a>
                        <a class="nav-link" href="requestCategory.php">Request new category</a>
                        <a class="nav-link" href="sellerAccountSetting.php">settings</a>
                    </li>
                </ul>

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
                    <li><a class="nav-link" href="login.php"><img src="images/user.svg"></a></li>
                </ul>
            </div>
        </div>

    </nav>
    <!-- End Header/Navigation -->
    <div>
        <div class="seller-listings-container">
            <div class="seller-listings-container01">
                <img src="./images/seller_profile.jpg" alt="image" class="seller-listings-image" />
                <h1 class="seller-listings-text">HyperSeller</h1>
                <div class="seller-listings-container02"></div>
                <span class="seller-listings-text01">
                    Best Clothes seller, cheap and affordable, buy from me and you won&apos;t regret
                    guarentee.
                </span>
            </div>
            <div class="seller-listings-container03">
                <div class="seller-listings-container04">
                    <h1 class="seller-listings-text02">Listings</h1>
                    <button type="button" class="seller-listings-button button" onclick="window.location='addListing.php'">
                        <span class="seller-listings-text03">
                            <span class="seller-listings-text04">Add new Listing</span>
                            <br />
                        </span>
                    </button>
                </div>
                <div class="seller-listings-container05">
                    <div class="seller-listings-container06" onclick="window.location='viewListing.php'">
                        <img alt="image" src="./images/vintage_hooters_tshirt.jpg" class="seller-listings-image1" />
                        <span>
                            <span>Vintage Hooter T-Shirt</span>
                            <br />
                        </span>
                        <span>$30</span>
                    </div>
                    <div class="seller-listings-container07" onclick="window.location='viewListing.php'">
                        <img alt="image" src="./images/authentic_adidas_shirt_hiroko.jpg" class="seller-listings-image2" />
                        <span>
                            <span>Vintage Hooter T-Shirt</span>
                            <br />
                        </span>
                        <span>$25</span>
                    </div>
                    <div class="seller-listings-container08" onclick="window.location='viewListing.php'">
                        <img alt="image" src="./images/jordan_x_j_balvin_shirt.jpg" class="seller-listings-image3" />
                        <span>
                            <span>Vintage Hooter T-Shirt</span>
                            <br />
                        </span>
                        <div class="seller-listings-container09">
                            <span>
                                <span>$40</span>
                                <br />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="seller-listings-container10">
                    <div class="seller-listings-container11" onclick="window.location='viewListing.php'">
                        <img alt="image" src="./images/alexander_mcqueen_tshirt.jpg" class="seller-listings-image4" />
                        <span>
                            <span>Vintage Hooter T-Shirt</span>
                            <br />
                        </span>
                        <span>
                            <span>$100</span>
                            <br />
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>

</html>