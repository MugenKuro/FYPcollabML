<?php
// Include file
require_once('auth.php');
require_once dirname(__FILE__) . '\controller\categoriesController.php';
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
    <?php
    include dirname(__FILE__) . ('/custNavBar.php');
    ?>

    <div>
        <link href="./homepage.css" rel="stylesheet" />
        <div class="homepage-container">
            <h1 class="homepage-text">Trending Now</h1>
            <div class="homepage-container01">
                <div class="homepage-container02">
                    <div class="homepage-container03" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/vintage_hooters_tshirt.jpg" class="homepage-image" />
                        <span>
                            <span>Vintage Hooter T-Shirt</span>
                            <br />
                        </span>
                        <span>$30</span>
                    </div>
                    <div class="homepage-container04" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/authentic_adidas_shirt_hiroko.jpg" class="homepage-image01" />
                        <span>
                            <span>Authentic Adidas Tokyo shirt</span>
                            <br />
                        </span>
                        <span>$25</span>
                    </div>
                    <div class="homepage-container05" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/jordan_x_j_balvin_shirt.jpg" class="homepage-image02" />
                        <span>
                            <span>Jordan x J balvin shirt</span>
                            <br />
                        </span>
                        <div class="homepage-container06">
                            <span>
                                <span>$40</span>
                                <br />
                            </span>
                        </div>
                    </div>
                    <div class="homepage-container07" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/alexander_mcqueen_tshirt.jpg" class="homepage-image03" />
                        <span>
                            <span>Alexander McQueen Shirt</span>
                            <br />
                        </span>
                        <span>
                            <span>$100</span>
                            <br />
                        </span>
                    </div>
                </div>
                <div class="homepage-container08">
                    <div class="homepage-container09" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/vintage_hooters_tshirt.jpg" class="homepage-image04" />
                        <span>
                            <span>Vintage Hooter T-Shirt</span>
                            <br />
                        </span>
                        <span>$30</span>
                    </div>
                    <div class="homepage-container10" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/authentic_adidas_shirt_hiroko.jpg" class="homepage-image05" />
                        <span>
                            <span>Authentic Adidas Tokyo shirt</span>
                            <br />
                        </span>
                        <span>$25</span>
                    </div>
                    <div class="homepage-container11" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/jordan_x_j_balvin_shirt.jpg" class="homepage-image06" />
                        <span>
                            <span>Jordan x J balvin shirt</span>
                            <br />
                        </span>
                        <div class="homepage-container12">
                            <span>
                                <span>$40</span>
                                <br />
                            </span>
                        </div>
                    </div>
                    <div class="homepage-container13" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/alexander_mcqueen_tshirt.jpg" class="homepage-image07" />
                        <span>
                            <span>Alexander McQueen Shirt</span>
                            <br />
                        </span>
                        <span>
                            <span>$100</span>
                            <br />
                        </span>
                    </div>
                </div>
                <div class="homepage-container14">
                    <div class="homepage-container15" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/vintage_hooters_tshirt.jpg" class="homepage-image08" />
                        <span>
                            <span>Vintage Hooter T-Shirt</span>
                            <br />
                        </span>
                        <span>$30</span>
                    </div>
                    <div class="homepage-container16" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/authentic_adidas_shirt_hiroko.jpg" class="homepage-image09" />
                        <span>
                            <span>Authentic Adidas Tokyo shirt</span>
                            <br />
                        </span>
                        <span>$25</span>
                    </div>
                    <div class="homepage-container17" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/jordan_x_j_balvin_shirt.jpg" class="homepage-image10" />
                        <span>
                            <span>Jordan x J balvin shirt</span>
                            <br />
                        </span>
                        <div class="homepage-container18">
                            <span>
                                <span>$40</span>
                                <br />
                            </span>
                        </div>
                    </div>
                    <div class="homepage-container19" onclick="redirectToViewItem()">
                        <img alt="image" src="./images/alexander_mcqueen_tshirt.jpg" class="homepage-image11" />
                        <span>
                            <span>Alexander McQueen Shirt</span>
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