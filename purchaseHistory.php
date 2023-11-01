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
                        <a class="dropdown-item" href="#">T-shirt</a>
                        <a class="dropdown-item" href="#">Jean</a>
                        <a class="dropdown-item" href="#">Skirt</a>
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
                    <li><a class="nav-link" href="login.php"><img src="images/user.svg"></a></li>
                    <li><a class="nav-link" href="cart.php"><img src="images/cart.svg"></a></li>
                </ul>
            </div>
        </div>

    </nav>
    <!-- End Header/Navigation -->
    <div>
        <div class="purchase-history-container">
            <div class="purchase-history-container1">
                <h1 class="purchase-history-text">Purchase History</h1>
                <div class="purchase-history-container2">
                    <div class="purchase-history-container3">
                        <span class="purchase-history-text01">
                            <span>Images</span>
                            <br />
                        </span>
                        <span class="purchase-history-text04">
                            <span>Name</span>
                            <br />
                        </span>
                        <div class="purchase-history-container4">
                            <span class="purchase-history-text07">
                                <span>Price</span>
                                <br />
                            </span>
                            <span class="purchase-history-text10">
                                <span>Date</span>
                                <br />
                            </span>
                        </div>
                    </div>
                    <div class="purchase-history-container5" onclick="window.location='rateItem.php'">
                        <img alt="image" src="./images/jordan_x_j_balvin_shirt.jpg" class="purchase-history-image" />
                        <span class="purchase-history-text13">
                            <span>Vintage Hooter T-Shirt</span>
                            <br />
                        </span>
                        <div class="purchase-history-container6">
                            <span class="purchase-history-text16">
                                <span>$40</span>
                                <br />
                            </span>
                            <span class="purchase-history-text19">
                                <span>23/09/23  13:42:55</span>
                                <br />
                            </span>
                        </div>
                    </div>
                    <div class="purchase-history-container7" onclick="window.location='rateItem.php'">
                        <img alt="image" src="./images/alexander_mcqueen_tshirt.jpg" class="purchase-history-image1" />
                        <span class="purchase-history-text22">
                            <span>Alexander McQueen Shirt</span>
                            <br />
                        </span>
                        <div class="purchase-history-container8">
                            <span class="purchase-history-text25">
                                <span>$100</span>
                                <br />
                            </span>
                            <span class="purchase-history-text28">
                                <span>23/09/23  13:42:55</span>
                                <br />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>

</html>