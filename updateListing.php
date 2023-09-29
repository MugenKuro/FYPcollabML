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
        <div class="update-listing-container">
            <div class="update-listing-container01">
                <div class="update-listing-container02">
                    <span class="update-listing-text">
                        <span>Update Item</span>
                        <br />
                    </span>
                </div>
                <div class="update-listing-container03"></div>
                <div class="update-listing-container04">
                    <form class="update-listing-form">
                        <div class="update-listing-container05">
                            <span class="update-listing-text03">
                                <span>Image</span>
                                <br />
                            </span>
                            <button type="button" class="update-listing-button button">
                                <span class="update-listing-text06">
                                    <span class="update-listing-text07">Upload</span>
                                    <br />
                                </span>
                            </button>
                        </div>
                        <div class="update-listing-container06">
                            <span class="update-listing-text09">
                                <span>Name of Item</span>
                                <br />
                            </span>
                            <div class="update-listing-container07">
                                <input type="text" placeholder="item name" value="Vintage Hooter T-Shirt"
                                    class="update-listing-textinput input" />
                            </div>
                        </div>
                        <div class="update-listing-container08">
                            <span class="update-listing-text12">
                                <span>Price</span>
                                <br />
                            </span>
                            <div class="update-listing-container09">
                                <input type="text" placeholder="23.50" value="100.00"
                                    class="update-listing-textinput1 input" />
                            </div>
                        </div>
                        <div class="update-listing-container10">
                            <span class="update-listing-text15">
                                <span>Category</span>
                                <br />
                            </span>
                            <select class="update-listing-select">
                                <option value="tshirt">T-shirt</option>
                                <option value="jean">Jean</option>
                                <option value="skirt">Skirt</option>
                            </select>
                        </div>
                        <div class="update-listing-container11">
                            <span class="update-listing-text18">
                                <span>Description of Item</span>
                                <br />
                            </span>
                            <div class="update-listing-container12">
                                <textarea placeholder="item description"
                                    class="update-listing-textarea textarea">&#62; Only provide the best with reasonable price</textarea>
                                <div class="update-listing-container13"></div>
                            </div>
                        </div>
                        <div class="update-listing-container14">
                            <button type="button" class="update-listing-button1 button" onclick="window.location='sellerIndex.php'">
                                <span class="update-listing-text21">
                                    <span>Submit</span>
                                    <br />
                                </span>
                            </button>
                            <button type="button" class="update-listing-button2 button" onclick="window.location='viewListing.php'">
                                <span class="update-listing-text24">
                                    <span class="update-listing-text25">Cancel</span>
                                    <br />
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




</body>

</html>