<?php
// Include file
require_once('auth.php');
require_once dirname(__FILE__) . '/controller/categoriesController.php';
if (session_status() === PHP_SESSION_NONE)
    session_start();


// Check if the user is logged in
if (isset($_SESSION['accountType'])) {
    // Redirect the user to login_verification.php
    header("location: login_verification.php");
    exit;
}

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
    <script src="js/scripts.js"></script>


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
                        <a class="nav-link" href="index.php#">Home</a>
                        <a class="nav-link" href="index.php#services">Services</a>
                        <a class="nav-link" href="index.php#categories">Categories</a>
                        <a class="nav-link" href="registerCustomer.php">Register as Customer</a>
                        <a class="nav-link" href="registerSeller.php">Register as Seller</a>
                        <a class="nav-link" href="login.php">Login</a>
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
            <a class="masthead-button btn btn-primary btn-xl text-uppercase" href="registerSeller.php">Looking to
                sell?</a>
        </div>
    </header>


    <section class="page-section" id="services">
        <div class="container-services">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Why sell with us</h2>
                <h3 class="section-subheading text-muted"></h3>
            </div>
            <div class="text-center services-row">
                <div class="text-center services-cell col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">E-Commerce</h4>
                    <p class="text-muted">As a reputable apparel brand, You wll have access to a large Customer base.
                    </p>
                </div>
                <div class="text-center services-cell col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Tailored Recommendations</h4>
                    <p class="text-muted">We provide free analysis of your Product. Allowing to know what's best to sell
                    </p>
                </div>
                <div class="text-center services-cell col-md-4">
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


    <?php
    $category = new viewTop6Categories();
    $categories = json_decode($category->viewTopCategories());


    ?>
    <!-- categories Grid-->
    <section class="page-section bg-light" id="categories">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Categories</h2>
                <h3 class="section-subheading text-muted">Here's some of the categories we provide</h3>
            </div>
            <div class="row">
                <?php
                if (!empty($categories)) {
                    // Loop through each category
                    foreach ($categories as $category) {
                        // Output the dynamically generated HTML for each category
                        echo '<div class="col-lg-4 col-sm-6 mb-4">';
                        echo '<div class="categories-item">';
                        echo '<a class="categories-link" data-bs-toggle="modal" href="login.php">';
                        echo '<div class="categories-hover">';
                        echo '<div class="categories-hover-content"><i class="fas fa-plus fa-3x"></i></div>';
                        echo '</div>';
                        echo '<img class="img-fluid" style="width: 600px; height: 450px;" src="' .".". $category->item_image_path . '" alt="' . $category->category_name . '" />';
                        echo '</a>';
                        echo '<div class="categories-caption">';
                        echo '<div class="categories-caption-heading">' . $category->category_name . '</div>';
                        echo '<div class="categories-caption-subheading text-muted"></div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    // Handle the case when no categories are available
                    echo 'No categories available.';
                }
                ?>
            </div>
        </div>
    </section>


</body>

</html>