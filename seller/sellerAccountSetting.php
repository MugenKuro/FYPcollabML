<?php
require_once __DIR__ . '/../entity/users.php';
require_once __DIR__ . '/../controller/sellerController.php';
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../sellerAuth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/sellerStyle.css" rel="stylesheet">


    <!-- Include Bootstrap JavaScript and jQuery (required for dropdown functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>iCloth</title>
</head>

<body>
    <?php
    include dirname(__FILE__) . ('/sellerNavBar.php');
    ?>
    <div>
        <div class="seller-container">
        <div class="seller-container01">
                <div class= "centering-div">
                <?php
                $sellerController = new sellerController();
                $result = $sellerController->showSettings();
                $row = $result->fetch_assoc();
                ?>
                        <span class= "seller-setting-header">Account Setting</span>
                        <span class= "seller-setting-name">Profile Image</span>
                        <img alt="no image found " src="..<?php echo $row["profile_image"] ?>" class="seller-setting-image" />
                                 <span class= "seller-setting-header"><span>Seller Name</span></span>
                                 <span class= "seller-setting-name"><?php echo $row["seller_name"] ?></span>
                                 <br>
                                 <span class= "seller-setting-header">Username</span>
                                 <span class= "seller-setting-name"><?php echo $row["username"] ?></span>
                                 <br>
                                 <span class= "seller-setting-header">Email</span>
                                 <span class= "seller-setting-name"><?php echo $row["email"] ?></span>
                                 <br>
                                 <span class= "seller-setting-header">Pick-up Address</span>
                                 <span class= "seller-setting-name"><?php echo $row["pick_up_address"] ?></span>
                                 <br>
                                 <span class= "seller-setting-header">Description</span>
                                 <span class= "seller-setting-name"><?php echo $row["description"] ?></span>
                                 <br>
                                 <span class= "seller-setting-header">Preferred Category</span>
                                 <span class= "seller-setting-name">
                            <?php 
                                $category_name = $sellerController->getCategoryName($row["preferred_category"]);
                                $categoryQuery = $category_name->fetch_assoc();
                                $categoryString = $categoryQuery["category_name"];
                            ?>
                            </span>
                                 <span class= "seller-setting-name"><?php echo $categoryString ?></span>
                                 <br>
                                 <span class= "seller-setting-header">Bank Name</span>
                                 <span class= "seller-setting-name"><?php echo $row["bank_name"] ?></span>
                                 <br>
                                 <span class= "seller-setting-header">Bank Number</span>
                                 <span class= "seller-setting-name"><?php echo $row["bank_account_no"] ?></span>
                                 <br>
                            <table class ="seller-setting-table">
                            <tr>
                                <td class="seller-setting-button-td">
                                    <button type="button" class="seller-setting-button button"  onclick="window.location='sellerEditSettings.php'">
                                    <span>Edit login Details</span></span>
                                <td class="seller-setting-button-td">
                                    <button type="button" class="seller-setting-button1 button" onclick="window.location='sellerHomepage.php'">
                                    <span>Cancel</span></button>
                                </span>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>


</body>

</html>