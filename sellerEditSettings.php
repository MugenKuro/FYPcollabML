<!doctype html>
<html lang="en">
<?php
include '.\entity\users.php';
include 'sellerEditSettingscontroller.php';

if (isset($_POST['requestDeactivation'])) {
    $sellerEntity = new sellerEdit;
    $deactivate = $sellerEntity->deactivateUser();
}

if (isset($_POST['updateLogin'])) {
    $profile_image = $_POST["profile_image"]; //seller
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $sellerName = $_POST['seller_name']; //seller
    $description = $_POST['description']; //seller
    $address = $_POST['pick_up_address']; //seller
    $paymentQR = $_POST['payment_QR']; //seller
    $email = $_POST['email'];

    $sellerEntity = new sellerEdit;
    $result = $sellerEntity->editSettings([
        'username' => $username,
        'password1' => $password1,
        'password2' => $password2,
        'seller_name' => $sellerName,
        'description' => $description,
        'pick_up_address' => $address,
        'email' => $email
    ]);

    if ($result) {
        header("Location: sellerAccountSetting.php");
    } else {
        echo "Failed to edit.";
    }
}

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
            <a class="navbar-brand" href="sellerHomepage.php">iCloth</a>

            <div class="collapse navbar-collapse">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li>
                        <a class="nav-link" href="sellerHomepage.php">Home</a>
                        <a class="nav-link" href="sellerRequestCategory.php">Request new category</a>
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
                    <form class="seller-settings-form" action="sellerEditSettings.php" method="POST">
                        <div class="seller-settings-container05">
                            <span class="seller-settings-text03">Profile Image</span>
                            <span><input type="file" class="form-control" id="profile_image" placeholder="Image"
                                    name="profile_image" value=""></span>
                        </div>
                        <div class="seller-settings-container05">
                            <span class="seller-settings-text03">
                                <span>Username</span>
                                <br />
                            </span>
                            <div class="seller-settings-container06">
                                <input type="text" placeholder="username" name="username"
                                    class="seller-settings-textinput input" />
                                </input>
                            </div>
                        </div>
                        <div class="seller-settings-container07">
                            <span class="seller-settings-text06">
                                <span>Password</span>
                                <br />
                            </span>
                            <div class="seller-settings-container08">
                                <input type="text" placeholder="password" name="password1"
                                    class="seller-settings-textinput1 input" /></input>
                            </div>
                        </div>
                        <div class="seller-settings-container09">
                            <span class="seller-settings-text09">
                                <span>Retype Password</span>
                                <br />
                            </span>
                            <div class="seller-settings-container10">
                                <input type="text" placeholder="password" name="password2"
                                    class="seller-settings-textinput2 input" /></input>
                            </div>
                        </div>
                        <div class="seller-settings-container05">
                            <span class="seller-settings-text03">
                                <span>Seller Name</span>
                                <br />
                            </span>
                            <div class="seller-settings-container06">
                                <input type="text" placeholder="sellername" name="seller_name"
                                    class="seller-settings-textinput input" />
                                </input>
                            </div>
                        </div>
                        <div class="seller-settings-container05">
                            <span class="seller-settings-text03">
                                <span>Description</span>
                                <br />
                            </span>
                            <div class="seller-settings-container06">
                                <input type="text" placeholder="description" name="description"
                                    class="seller-settings-textinput input" />
                                </input>
                            </div>
                        </div>
                        <div class="seller-settings-container05">
                            <span class="seller-settings-text03">
                                <span>Address</span>
                                <br />
                            </span>
                            <div class="seller-settings-container06">
                                <input type="text" placeholder="address" name="pick_up_address"
                                    class="seller-settings-textinput input" />
                                </input>
                            </div>
                        </div>
                        <div class="seller-settings-container05">
                            <span class="seller-settings-text03">payment QR</span>
                            <span><input type="file" class="form-control" id="payment_QR" placeholder="QR Code"
                                    name="payment_QR" value=""></span>
                        </div>
                        <div class="seller-settings-container05">
                            <span class="seller-settings-text03">
                                <span>Email</span>
                                <br />
                            </span>
                            <div class="seller-settings-container06">
                                <input type="text" placeholder="email" name="email"
                                    class="seller-settings-textinput input" />
                                </input>
                            </div>
                        </div>
                        <div class="seller-settings-button-container">
                            <input type="submit" name="updateLogin" class="seller-settings-button button"
                                value="Submit"></input>

                            <button type="button" class="seller-settings-button1 button"
                                onclick="window.location='sellerAccountSetting.php'">
                                <span class="seller-settings-text15">
                                    <span class="seller-settings-text16">Cancel</span>
                                    
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="seller-settings-container02">
                    <form method="POST" action="sellerEditSettings.php">
                        <div class="seller-settings-button-container">
                            <input type="submit" name="requestDeactivation" value="Request Deactivation"
                                class="seller-settings-button2 button">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


</body>

</html>