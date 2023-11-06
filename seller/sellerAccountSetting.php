<!doctype html>
<html lang="en">
<?php
require_once __DIR__ . '/../entity/users.php';
require_once __DIR__ . '/../controller/sellerController.php';
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../sellerAuth.php';

$sellerController = new sellerController();
$result = $sellerController->showSettings();
?>
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
    <?php
    $row = $result->fetch_assoc();
    ?>
    <div>
        <div class="seller-container">
        <div class="seller-container01">
                <div class= "centering-div">
                        <span class= "seller-setting-header">Account Setting</span>
                        <span class= "seller-setting-name">Profile Image</span>
                        <img alt="no image found " src="..<?php echo $row["profile_image"] ?>" class="seller-setting-image" />
                        <table class ="seller-setting-table">
                            <tr>
                                <td class ="seller-setting-table-td"><span>Seller Name</span></td>
                                <td class ="seller-setting-table-td"><?php echo $row["seller_name"] ?></td>
                                <td class ="seller-setting-table-td">Username</td>
                                <td class ="seller-setting-table-td"><?php echo $row["username"] ?></td>
                            </tr>
                            <tr>
                                <td class ="seller-setting-table-td">Email</td>
                                <td class ="seller-setting-table-td"><?php echo $row["email"] ?></td>
                                <td class ="seller-setting-table-td">Pick-up Address</td>
                                <td class ="seller-setting-table-td"><?php echo $row["pick_up_address"] ?>
                            </tr>
                            <tr>
                                <td class ="seller-setting-table-td">Description</td>
                                <td class ="seller-setting-table-td"><?php echo $row["description"] ?></td>
                                <td class ="seller-setting-table-td">Preferred Category</td>
                            <?php 
                                $category_name = $sellerController->getCategoryName($row["preferred_category"]);
                                $categoryQuery = $category_name->fetch_assoc();
                                $categoryString = $categoryQuery["category_name"];
                            ?>
                                <td class ="seller-setting-table-td"><?php echo $categoryString ?></td>
                            </tr>

                            <tr>
                                <td class ="seller-setting-table-td">Bank Name</td>
                                <td class ="seller-setting-table-td"><?php echo $row["bank_name"] ?></td>
                                <td class ="seller-setting-table-td">Bank Number</td>
                                <td class ="seller-setting-table-td"><?php echo $row["bank_account_no"] ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="seller-setting-button-td">
                                    <button type="button" class="seller-setting-button button"  onclick="window.location='sellerEditSettings.php'">
                                    <span>Edit login Details</span></td>
                                <td class="seller-setting-button-td">
                                    <button type="button" class="seller-setting-button1 button" onclick="window.location='sellerHomepage.php'">
                                    <span>Cancel</span></button>
                                </td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>


</body>

</html>