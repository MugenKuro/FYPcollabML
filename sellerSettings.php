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
        <div class="seller-settings-container">
            <div class="seller-settings-container01">
                <div class="seller-settings-container02">
                    <span class="seller-settings-text">
                        <span>Update Login Details</span>
                        <br />
                    </span>
                </div>
                <div class="seller-settings-container03"></div>
                <div class="seller-settings-container04">
                    <form class="seller-settings-form">
                        <div class="seller-settings-container05">
                            <span class="seller-settings-text03">
                                <span>Username</span>
                                <br />
                            </span>
                            <div class="seller-settings-container06">
                                <input type="text" placeholder="username"
                                    class="seller-settings-textinput input" />
                            </div>
                        </div>
                        <div class="seller-settings-container07">
                            <span class="seller-settings-text06">
                                <span>Password</span>
                                <br />
                            </span>
                            <div class="seller-settings-container08">
                                <input type="text" placeholder="password" class="seller-settings-textinput1 input" />
                            </div>
                        </div>
                        <div class="seller-settings-container09">
                            <span class="seller-settings-text09">
                                <span>Re-type Passowrd</span>
                                <br />
                            </span>
                            <div class="seller-settings-container10">
                                <input type="text" placeholder="password" class="seller-settings-textinput2 input" />
                            </div>
                        </div>
                        <div class="seller-settings-container11">
                            <button type="button" class="seller-settings-button button" onclick="window.location='sellerIndex.php'">
                                <span class="seller-settings-text12">
                                    <span>Submit</span>
                                    <br />
                                </span>
                            </button>
                            <button type="button" class="seller-settings-button1 button" onclick="window.location='sellerIndex.php'">
                                <span class="seller-settings-text15">
                                    <span class="seller-settings-text16">Cancel</span>
                                    <br />
                                </span>
                            </button>
                        </div>
                    </form>
                    <button type="button" class="seller-settings-button2 button" onclick="window.location='sellerIndex.php'">
                        <span class="seller-settings-text18">
                            <span>Request for Deactivation</span>
                            <br />
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>