<!doctype html>
<html lang="en">
<?php
require_once __DIR__ . '/../entity/users.php';
require_once __DIR__ . '/../controller/sellerController.php';
//require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../sellerAuth.php';


if (isset($_POST['requestDeactivation'])){
    $sellerController = new sellerController;
    $deactivate = $sellerController->deactivateUser();
}

if (isset($_POST['updateLogin'])){
    $is_image_uploaded = !empty($_FILES["profile_image"]["name"]);
			
    if ($is_image_uploaded) {
        $target_dir = "../images/SellerLogo/";		
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadsuccess = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $check = getimagesize($_FILES["profile-image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadsuccess = 0;
        }
        
        if ($_FILES["profile_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadsuccess = 0;
        }
        
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG,, JPEG & PNG files are allowed.";
            $uploadsuccess = 0;
        }
        
        if ($uploadsuccess == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["profile_image"]["name"])) . " has been uploaded..";
                $profile_image = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                
            }
        }
    } else {
         $profile_image = isset($_POST['profile_image']) ? $_POST['profile_image'] : $profile_image;
    }
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
    
    
    $sellerController = new sellerController;
        $result = $sellerController ->editSettings([
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
            header('Location: sellerAccountSetting.php');
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

    <div>
        <div class="seller-container">
            <div class="seller-container01">
                        <div class= "centering-div">
                        <?php
    include dirname(__FILE__) . ('/sellerNavBar.php');
    ?>
    <?php
    $sellerController = new sellerController();
    $result = $sellerController->showSettings();
    $row = $result->fetch_assoc();
    ?>
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
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="seller name" name="seller_name" value="<?php echo $row['seller_name'] ?>"   
                                    class="seller-input" /></input></td>
                                <td class ="seller-edit-setting-table-td"><span>Username</span></td>
                                <td class ="seller-edit-setting-table-td"><input type="text" placeholder="username" name="username" value="<?php echo $row['username'] ?>"
                                    class="seller-input" /></input></td>
                            </tr>
                            <?php
                            $address= $row['pick_up_address'];
                            list($address1, $address2, $address3) = explode(',', $address);
                            ?>
                            <tr>
                            <td class ="seller-edit-setting-table-td"><span>Pick-Up Address</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="street name" name="address1" value="<?php echo $address1 ?>"
                                    class="seller-input" /></input></td>
                                    <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="blk number" name="address2" value="<?php echo $address2 ?>"
                                    class="seller-input" /></input></td>
                                    <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="postal code" name="address3" value="<?php echo $address3 ?>"
                                    class="seller-input" /></input></td>
                            </tr>
                            <tr>
                            <td class ="seller-edit-setting-table-td"> <span>Email</span></td>
                            <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="email" name="email"  value="<?php echo $row['email'] ?>"
                                    class="seller-input" /></td>
                            </tr>
                            <tr>
                                <td class ="seller-edit-setting-table-td"> <span>Description</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="description" name="description" value="<?php echo $row['description'] ?>"
                                    class="seller-input" /></input></td>
                                <td class ="seller-edit-setting-table-td"> <span>Preferred Category</span></td>
                                <td class ="seller-edit-setting-table-td">
							<select id="category_id" name="preferred_category">
							<?php
							$sellerController = new sellerController;
							$categories = $sellerController->getCategoriesForDropdown();

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
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="Bank Name" name="bank_name" value="<?php echo $row['bank_name'] ?>"
                                    class="seller-input" /></input></td>
                                <td class ="seller-edit-setting-table-td"> <span>Bank Number</span></td>
                                <td class ="seller-edit-setting-table-td"> <input type="text" placeholder="Bank Number" name="bank_account_no" value="<?php echo $row['bank_account_no'] ?>"
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