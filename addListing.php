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
        <div class="add-listing-container">
            <div class="add-listing-container01">
                <div class="add-listing-container02">
                    <span class="add-listing-text">
                        <span>Add Item</span>
                        <br />
                    </span>
                </div>
                <div class="add-listing-container03"></div>
                <div class="add-listing-container04">
                    <form class="add-listing-form">
                        <div class="add-listing-container05">
                            <span class="add-listing-text03">
                                <span>Image</span>
                                <br />
                            </span>
                            <button type="button" class="add-listing-button button">
                                <span class="add-listing-text06">
                                    <span class="add-listing-text07">Upload</span>
                                    <br />
                                </span>
                            </button>
                        </div>
                        <div class="add-listing-container06">
                            <span class="add-listing-text09">
                                <span>Name of Item</span>
                                <br />
                            </span>
                            <div class="add-listing-container07">
                                <input type="text" placeholder="item name" class="add-listing-textinput input" />
                            </div>
                        </div>
                        <div class="add-listing-container08">
                            <span class="add-listing-text12">
                                <span>Price</span>
                                <br />
                            </span>
                            <div class="add-listing-container09">
                                <input type="text" placeholder="23.50" class="add-listing-textinput1 input" />
                            </div>
                        </div>
                        <div class="add-listing-container10">
                            <span class="add-listing-text15">
                                <span>Category</span>
                                <br />
                            </span>
                            <select class="add-listing-select">
                                <option value="tshirt" selected>T-shirt</option>
                                <option value="jean">Jean</option>
                                <option value="skirt">Skirt</option>
                            </select>
                        </div>
                        <div class="add-listing-container11">
                            <span class="add-listing-text18">
                                <span>Description of Item</span>
                                <br />
                            </span>
                            <div class="add-listing-container12">
                                <textarea placeholder="item description"
                                    class="add-listing-textarea textarea"></textarea>
                                <div class="add-listing-container13"></div>
                            </div>
                        </div>
                        <div class="add-listing-container14">
                            <button type="button" class="add-listing-button1 button" onclick="window.location='sellerIndex.php'">
                                <span class="add-listing-text21">
                                    <span>Submit</span>
                                    <br />
                                </span>
                            </button>
                            <button type="button" class="add-listing-button2 button" onclick="window.location='sellerIndex.php'">
                                <span class="add-listing-text24">
                                    <span class="add-listing-text25">Cancel</span>
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