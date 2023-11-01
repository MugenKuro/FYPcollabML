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
        <div class="user-account-setting-container">
            <div class="user-account-setting-container01">
                <div class="user-account-setting-container02">
                    <span class="user-account-setting-text">
                        <span>Account Setting</span>
                        <br />
                    </span>
                </div>
                <div class="user-account-setting-container03"></div>
                <div class="user-account-setting-container04">
                    <form class="user-account-setting-form">
                        <div class="user-account-setting-container05">
                            <span class="user-account-setting-text03">
                                <span>Profile Image</span>
                                <br />
                            </span>
                            <div class="user-account-setting-container06">
                                <img src="./images/default_user.jpg" alt="image" class="user-account-setting-image" />
                            </div>
                        </div>
                        <div class="user-account-setting-container07">
                            <span class="user-account-setting-text06">
                                <span>Nickname</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text09">
                                <span>Janelle331</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container08">
                            <span class="user-account-setting-text12">
                                <span>First Name</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text15">
                                <span>Janelle</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container09">
                            <span class="user-account-setting-text18">
                                <span>Last Name</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text21">
                                <span>Lee</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container10">
                            <span class="user-account-setting-text24">
                                <span>Gender</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text27">
                                <span>Female</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container11">
                            <span class="user-account-setting-text30">
                                <span>Date of Birth</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text33">
                                <span>12/02/1999</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container12">
                            <span class="user-account-setting-text36">
                                <span>Mobile</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text39">
                                <span>88854123</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container13">
                            <span class="user-account-setting-text42">
                                <span>Address</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text45">
                                <span>Jurong west street 81,</span>
                                <br />
                                <span>BLK 812 #04-12,</span>
                                <br />
                                <span>Singapore 640812</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container14">
                            <span class="user-account-setting-text52">
                                <span>Username</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text55">
                                <span>Janelle22</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container15">
                            <span class="user-account-setting-text58">
                                <span>Email</span>
                                <br />
                            </span>
                            <span class="user-account-setting-text61">
                                <span>Janelle22@gmail.com</span>
                                <br />
                            </span>
                        </div>
                        <div class="user-account-setting-container16">
                            <button type="button" class="user-account-setting-button button" onclick="window.location='settings.php'">
                                <span class="user-account-setting-text64">
                                    <span>Edit login Details</span>
                                    <br />
                                </span>
                            </button>
                            <button type="button" class="user-account-setting-button1 button" onclick="window.location='index.php'">
                                <span class="user-account-setting-text67">
                                    <span class="user-account-setting-text68">Cancel</span>
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