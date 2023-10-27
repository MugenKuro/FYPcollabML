<!doctype html>
<html lang="en">
<?php
include '.\entity\users.php';
include 'sellerRequestController.php';
include 'sellerViewReqController.php';

if(isset($_POST["requestCategory"])){
    $category = $_POST['category'];
    $sellerEntity = new sellerRequest();
    $result = $sellerEntity->requestCategory($category);
    if($result)
    {
        header("Location: sellerRequestCategory.php");
    } 
    // for some reason when else is here its also echoed?
    //else  {echo "aaa";}
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
        <div class="request-category-container">
            <div class="request-category-container01">
                <div class="request-category-container02">
                    <span class="request-category-text">
                        <span>Request for new Category</span>
                        <br />
                    </span>
                </div>
                <div class="request-category-container03"></div>
                <div class="request-category-container04">
                    <form class="request-category-form"  action="sellerRequestCategory.php" method="POST">
                        <div class="request-category-container05">
                            <span class="request-category-text03">
                                <span>Category Request: </span>
                                <br />
                            </span>
                            <input type="text" name="category" placeholder = "insert category name" class="request-category-textarea textarea"></input>
                        </div>
                        <div class="request-category-container06">
                            <div class="request-category-container07">
                                <input type="submit" name="requestCategory" value="Submit" class="request-category-button button"></input>
                                <button type="button" class="request-category-button1 button" onclick="window.location='sellerHomepage.php'">
                                    <span class="request-category-text09">
                                        <span class="request-category-text10">Cancel</span>
                                        <br />
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="request-category-container08">
                <div class="request-category-container09">
                    <span class="request-category-text12">
                        <span>Request status</span>
                        <br />
                    </span>
                </div>
                <div class="request-category-container10"></div>
                <div class="request-category-container11">
                    <form class="request-category-form1">
                        <div class="request-category-container12">
                            <div class="request-category-container13">
                                <span class="request-category-text15">
                                    <span>Category Name</span>
                                    <br />
                                </span>
                                <span class="request-category-text18">
                                    <span>Status</span>
                                    <br />
                                </span>
                            </div>
                            <?php
                            $categoryRequests = new viewRequest;
                            $result = $categoryRequests->showRequests();
                            if ($result){
                            // output data of each row
                            foreach ($result as $row){
                            ?>
                            <div class="request-category-container14">
                                <span class="request-category-text21">
                                    <span><?php echo $row["category_name"] ?></span>
                                    <br />
                                </span>
                                <span class="request-category-text24">
                                    <span><?php echo $row["status"] ?></span>
                                    <br />
                                </span>
                            </div>
                            <?php                    
                            }            }        
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  

</body>

</html>