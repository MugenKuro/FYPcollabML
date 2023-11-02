<!doctype html>
<html lang="en">
<?php
include '.\entity\users.php';
include 'sellerEditSettingscontroller.php';

if (isset($_POST['requestDeactivation'])){
    $sellerEntity = new sellerEdit;
    $deactivate = $sellerEntity->deactivateUser();
}

if (isset($_POST['updateLogin'])){
    $profile_image = $_POST["profile_image"]; //seller
    $profile_image = '/images/SellerLogo/' . $profile_image;
    $username= $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2']; 
    $sellerName = $_POST['seller_name']; //seller
    $description = $_POST['description']; //seller
    $preferred_category = $_POST['preferred_category'];
    $address1 = $_POST['address1']; //seller
    $address2 = $_POST['address2']; //seller
    $address3 = $_POST['address3']; //seller
    $address = $address1 . ',' . $address2 . ',' . $address3;
    $email = $_POST['email'];
    $bank_name = $_POST['bank_name'];
    $bank_account_no = $_POST['bank_account_no'];
        
    
    $sellerEntity = new sellerEdit;
        $result = $sellerEntity ->editSettings([
            'profile_image' => $profile_image,
            'username' => $username,
            'password1' => $password1,
            'password2'=> $password2,
            'seller_name'=> $sellerName,
            'description'=> $description,
            'pick_up_address'=> $address,
            'email' => $email,
            'preferred_category' => $preferred_category,
            'bank_name'=> $bank_name,
            'bank_account_no'=> $bank_account_no

        ]);
        
        if($result)
        {
            header("Location: sellerAccountSetting.php");
        }else{
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
        <a class="nav-link" href="sellerHomepage.php">Item Listings</a>
            <a class="nav-link" href="addItem.php">Add Items</a>
            <a class="nav-link" href="sellerAccountSetting.php">Account Setting</a>
            <a class="nav-link" href="sellerRequestCategory.php">Category Requests</a>
            <a class="nav-link" href="view_revenue_report.php">Revenue Report</a>
            <a class="nav-link" href="view_inventory.php">Manage Inventory</a>
        </li>
    </ul>
    <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
        <li><span class="nav-link">Welcome,
                <?php echo htmlspecialchars("seller"); ?>
            </span></li>
            <li><a class="nav-link" href="logout.php"><img src="images/user.svg"><span> log out</span></a></li>
    </ul>
</div>
</div>
</nav>
<!-- End Header/Navigation -->

    <div>
        <div class="seller-container">
            <div class="seller-container01">
                        <div class= "centering-div">
                            <br>
                        <span class= "seller-setting-header">Edit Account Setting</span>
<br><br>
                        <form class="seller-form" action="sellerEditSettings.php" method="POST">
                            <table class ="seller-edit-table">
                                <tr>
                                <td class ="seller-edit-setting-table-td"><span>Profile Image</span></td>
                                <td class ="seller-edit-setting-table-td"><input type="file" id="profile_image" placeholder="Image"
                                    name="profile_image" value=""></input></td>
                                </tr>
                            </table>
                            <br>
                            <table class ="seller-edit-table">
                            <tr>
                                <td class ="seller-edit-setting-table-td"> <span>Seller Name</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="seller name" name="seller_name"
                                    class="seller-input" /></input></td>
                                <td class ="seller-edit-setting-table-td"><span>Username</span></td>
                                <td class ="seller-edit-setting-table-td"><input type="text" placeholder="username" name="username"
                                    class="seller-input" /></input></td>
                            </tr>
                            <tr>
                            <td class ="seller-edit-setting-table-td"><span>Pick-Up Address</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="street name" name="address1"
                                    class="seller-input" /></input></td>
                                    <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="blk number" name="address2"
                                    class="seller-input" /></input></td>
                                    <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="postal code" name="address3"
                                    class="seller-input" /></input></td>
                            </tr>
                            <tr>
                            <td class ="seller-edit-setting-table-td"> <span>Email</span></td>
                            <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="email" name="email" 
                                    class="seller-input" /></td>
                            </tr>
                            <tr>
                                <td class ="seller-edit-setting-table-td"> <span>Description</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="description" name="description"
                                    class="seller-input" /></input></td>
                                <td class ="seller-edit-setting-table-td"> <span>Preferred Category</span></td>
                                <td class ="seller-edit-setting-table-td">
							<select id="category_id" name="preferred_category">
							<?php
							$sellerEntity = new sellerEntity;
							$categories = $sellerEntity->getCategoriesForDropdown();

							foreach ($categories as $category) {
								$category_id_loop = $category['category_id'];
								$category_name = $category['category_name'];
								echo "<option value='$category_id_loop' " . ($category_id == $category_id_loop ? 'selected' : '') . ">$category_name</option>";
							}
							?>
							</select>
							</td>
                            </tr>
                            <tr>
                                <td class ="seller-edit-setting-table-td"> <span>Bank Name</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="Bank Name" name="bank_name"
                                    class="seller-input" /></input></td>
                                <td class ="seller-edit-setting-table-td"> <span>Bank Number</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="Bank Number" name="bank_account_no"
                                    class="seller-input" /></input></td>
                            </tr>
                            <tr>
                                <td class ="seller-edit-setting-table-td"><span>Password</span></td>
                                <td class ="seller-edit-setting-table-td"><input type="text" placeholder="password" name="password1"
                                    class="seller-input" /></input></td>
                                    <td class ="seller-edit-setting-table-td"><span>Retype Password</span></td>
                                <td class ="seller-edit-setting-table-td"><input type="text" placeholder="password" name="password2"
                                    class="seller-input" /></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <div class= "seller-setting-button-container">
                                <td class="seller-edit-setting-button-td">
                                <input type="submit" name="updateLogin" class="seller-setting-button"
                                value="Submit"></input>
                                </td>
                                <td class="seller-edit-setting-button-td">
                                <button type="button" class="seller-setting-button1"
                                onclick="window.location='sellerAccountSetting.php'">
                                    <span>Cancel</span></button>
                                </td>
                                </div>
                            </tr>
                            </table>
                    </form>

                    <form method="POST" action="sellerEditSettings.php">
                        <div class="seller-settings-button-container">
                            <input type="submit" name="requestDeactivation" value="Request Deactivation"  class="seller-setting-button2 button">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


</body>

</html>