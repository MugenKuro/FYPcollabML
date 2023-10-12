<!doctype html>
<html lang="en">
<?php
require dirname(__FILE__) . '\entity\users.php';
$database = new Db();
$seller = new Users();
$ID = $seller->getUserId();
?>
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
    <?php

        $sql = "SELECT * FROM sellers JOIN users ON sellers.user_id = users.user_id  WHERE sellers.user_id=$ID" ;
        $sellerSetting = $database->query($sql);
        while($row = mysqli_fetch_assoc($sellerSetting)){
    ?>
    <div>
        <div class="account-setting-container">
            <div class="account-setting-container01">
                <div class="account-setting-container02">
                    <span class="account-setting-text">
                        <span>Account Setting</span>
                        <br />
                    </span>
                </div>
                <div class="account-setting-container03"></div>
                <div class="account-setting-container04">
                    <form class="account-setting-form">
                        <div class="account-setting-container05">
                            <span class="account-setting-text03">
                                <span>Profile Image</span>
                                <br />
                            </span>
                            <div class="account-setting-container06">
                                <img alt="no image found " src="<?php echo $row["profile_image"] ?>" class="account-setting-image" />
                            </div>
                        </div>
                        <div class="account-setting-container07">
                            <span class="account-setting-text06">
                                <span>Seller Name</span>
                                <br />
                            </span>
                            <span class="account-setting-text09">
                                <span><?php echo $row["seller_name"] ?></span>
                                <br />
                            </span>
                        </div>
                        <div class="account-setting-container08">
                            <span class="account-setting-text12">
                                <span>
                                    Description
                                </span>
                                <br />
                            </span>
                            <span class="account-setting-text15">
                                <span>
                                <?php echo $row["description"] ?>
                                </span>
                                <br />
                            </span>
                        </div>
                        <div class="account-setting-container09">
                            <span class="account-setting-text18">
                                <span>Pick-up Address</span>
                                <br />
                            </span>
                            <span class="account-setting-text21">
                                <span><?php echo $row["pick_up_address"] ?>
                                </span>
                            </span>
                        </div>
                        <div class="account-setting-container10">
                            <span class="account-setting-text28">
                                <span>Payment QR</span>
                                <br />
                            </span>
                            <img alt="no image found" src="<?php echo $row["payment_QR"] ?>" class="account-setting-image1" />
                        </div>
                        <div class="account-setting-container11">
                            <span class="account-setting-text31">
                                <span>Username</span>
                                <br />
                            </span>
                            <span class="account-setting-text34">
                                <span><?php echo $row["username"] ?></span>
                                <br />
                            </span>
                        </div>
                        <div class="account-setting-container12">
                            <span class="account-setting-text37">
                                <span>Email</span>
                                <br />
                            </span>
                            <span class="account-setting-text40">
                                <span><?php echo $row["email"] ?></span>
                                <br />
                            </span>
                        </div>
                        <?php
                         }
                        ?>

                        <div class="account-setting-container13">
                            <button type="button" class="account-setting-button button"  onclick="window.location='sellerSettings.php'">
                                <span class="account-setting-text43">
                                    <span>Edit login Details</span>
                                    <br />
                                </span>
                            </button>
                            <button type="button" class="account-setting-button1 button" onclick="window.location='sellerIndex.php'">
                                <span class="account-setting-text46">
                                    <span class="account-setting-text47">Cancel</span>
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