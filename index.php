<?php
// Include file
require_once('auth.php');
require_once dirname(__FILE__) . '/controller/categoriesController.php';
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


}
?>

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
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <title>iCloth</title>

    <script>
        function redirectToViewItem() {
            window.location.href = "viewItem.php";
        }
    </script>
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
                        <a class="nav-link" href="registerCustomer.php">Register as Customer</a>
                        <a class="nav-link" href="registerSeller.php">Register as Seller</a>
                    </li>
                </ul>

            </div>
        </div>

    </nav>
    <!-- End Header/Navigation -->

    <header class="masthead">
        <div class="container-index">
            <div class="masthead-subheading">Welcome To iCloth!</div>
            <div class="masthead-heading text-uppercase">APPARELS JUST FOR YOU</div>
            <a class="masthead-button btn btn-primary btn-xl text-uppercase" href="#services">Looking to sell?</a>
        </div>
    </header>


    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Why sell with us</h2>
                <h3 class="section-subheading text-muted"></h3>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">E-Commerce</h4>
                    <p class="text-muted">As a reputable apparel brand, You wll have access to a large Customer base.
                    </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Tailored Recommendations</h4>
                    <p class="text-muted">We provide free analysis of your Product. Allowing to know what's best to sell
                    </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Security</h4>
                    <p class="text-muted">We take security very seriously. Rest assured your data and privacy will
                        always be covered by us.</p>
                </div>
            </div>
        </div>
    </section>



</body>

</html>